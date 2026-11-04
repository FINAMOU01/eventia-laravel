<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesFormSubmission;
use App\Mail\QuoteRequestReceived;
use App\Models\QuoteRequest;
use App\Support\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

/** Contact page quote request: stored in the database, then e-mailed to the EVENTIA team. */
class QuoteRequestController extends Controller
{
    use HandlesFormSubmission;

    public const POLES = ['image', 'hotesses', 'events'];

    public function __invoke(Request $request, string $locale): JsonResponse|RedirectResponse
    {
        $data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:150'],
            'organisation' => ['nullable', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:40', 'regex:/^\+?[0-9 ().-]{6,25}$/'],
            'email' => ['required', 'email', 'max:190'],
            'pole' => ['required', Rule::in(self::POLES)],
            'service_type' => ['required', 'string', 'max:200'],
            'project_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:200'],
            'budget' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:3000'],
            // Invisible field: only bots fill it in.
            'website' => ['prohibited'],
        ], $this->validationMessages($locale))->validate();

        $email = Site::CONTACT['email'];

        try {
            $quote = QuoteRequest::create([...$data, 'locale' => $locale]);
            Mail::to($email)->send(new QuoteRequestReceived($quote));
            $quote->update(['notified_at' => now()]);
        } catch (Throwable $exception) {
            // The request stays stored (if it was) with notified_at empty; the visitor is told it did not go through.
            report($exception);

            return $this->respond($request, 'quote', 'demande-devis', false, $this->failureMessage($locale, $email));
        }

        return $this->respond($request, 'quote', 'demande-devis', true);
    }
}
