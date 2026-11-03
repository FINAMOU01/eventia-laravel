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
 * Recruitment application: the CV is stored privately (storage/app/private/cv, random file name, no public URL),
 * the application is recorded, then e-mailed to the recruitment address with the CV attached.
 */
class ApplicationController extends Controller
{
    use HandlesFormSubmission;

    public function __invoke(Request $request, string $locale): JsonResponse|RedirectResponse
    {
        $data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:40', 'regex:/^\+?[0-9 ().-]{6,25}$/'],
            'email' => ['required', 'email', 'max:190'],
            'city' => ['required', 'string', 'max:120'],
            'mission_type' => ['required', 'string', 'max:200'],
            'experience' => ['required', 'string', 'max:3000'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'website' => ['prohibited'],
        ], $this->validationMessages($locale))->validate();

        $email = Site::CONTACT['recruitmentEmail'];
        $file = $request->file('cv');
        $path = null;

        try {
            $path = $file->store('cv', 'local');
            $application = JobApplication::create([
                ...collect($data)->except('cv')->all(),
                'locale' => $locale,
                'cv_path' => $path,
                'cv_original_name' => $file->getClientOriginalName(),
                'cv_mime' => $file->getMimeType(),
                'cv_size' => $file->getSize(),
            ]);
        } catch (Throwable $exception) {
            report($exception);
            if ($path) {
                Storage::disk('local')->delete($path);
            }

            return $this->respond($request, 'application', 'candidature', false, $this->failureMessage($locale, $email));
        }

        try {
            Mail::to($email)->send(new JobApplicationReceived($application));
            $application->update(['notified_at' => now()]);
        } catch (Throwable $exception) {
            // The application is kept (notified_at empty) so it can be sent again; the visitor is told it did not go through.
            report($exception);

            return $this->respond($request, 'application', 'candidature', false, $this->failureMessage($locale, $email));
        }

        return $this->respond($request, 'application', 'candidature', true);
    }
}
