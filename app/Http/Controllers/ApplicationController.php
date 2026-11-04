<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesFormSubmission;
use App\Mail\JobApplicationReceived;
use App\Models\JobApplication;
use App\Support\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

/**
 * Recruitment application: the four documents are stored privately (storage/app/private/candidatures, random
 * file names, no public URL), the application is recorded, then e-mailed to the recruitment address with the
 * documents attached.
 */
class ApplicationController extends Controller
{
    use HandlesFormSubmission;

    public const MAX_FILE_KB = 5120;

    public const DOCUMENT_TYPES = 'pdf,doc,docx';

    public const PHOTO_TYPES = 'jpg,jpeg,png,webp,heic,heif';

    public function __invoke(Request $request, string $locale): JsonResponse|RedirectResponse
    {
        $document = ['required', 'file', 'mimes:'.self::DOCUMENT_TYPES, 'max:'.self::MAX_FILE_KB];
        $photo = ['required', 'file', 'mimes:'.self::PHOTO_TYPES, 'max:'.self::MAX_FILE_KB];

        $data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:40', 'regex:/^\+?[0-9 ().-]{6,25}$/'],
            'email' => ['required', 'email', 'max:190'],
            'city' => ['required', 'string', 'max:120'],
            'mission_type' => ['required', 'string', 'max:200'],
            'experience' => ['required', 'string', 'max:3000'],
            'cv' => $document,
            'cover_letter' => $document,
            'photo_portrait' => $photo,
            'photo_full' => $photo,
            'website' => ['prohibited'],
        ], $this->validationMessages($locale))->validate();

        $email = Site::CONTACT['recruitmentEmail'];
        $stored = [];

        try {
            foreach (JobApplication::DOCUMENTS as $key) {
                $file = $request->file($key);
                $stored[$key] = [
                    'path' => $file->store('candidatures', 'local'),
                    'name' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ];
            }
            $application = JobApplication::create([
                ...collect($data)->except(JobApplication::DOCUMENTS)->all(),
                'locale' => $locale,
                'documents' => $stored,
            ]);
        } catch (Throwable $exception) {
            report($exception);
            Storage::disk('local')->delete(array_column($stored, 'path'));

            return $this->respond($request, 'application', 'candidature', false, $this->failureMessage($locale, Site::CONTACT['email']));
        }

        try {
            Mail::to($email)->send(new JobApplicationReceived($application));
            $application->update(['notified_at' => now()]);
        } catch (Throwable $exception) {
            // The application is kept (notified_at empty) so it can be sent again; the visitor is told it did not go through.
            report($exception);

            return $this->respond($request, 'application', 'candidature', false, $this->failureMessage($locale, Site::CONTACT['email']));
        }

        return $this->respond($request, 'application', 'candidature', true);
    }
}
