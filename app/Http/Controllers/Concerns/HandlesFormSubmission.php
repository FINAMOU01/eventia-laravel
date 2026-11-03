<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Shared behaviour of the quote and application forms.
 * Success is only reported once the request is stored AND the EVENTIA team has been notified by e-mail.
 */
trait HandlesFormSubmission
{
    protected function validationMessages(string $locale): array
    {
        return $locale === 'en' ? [
            'required' => 'This field is required.',
            'email' => 'Please enter a valid e-mail address.',
            'regex' => 'Please enter a valid phone number.',
            'date' => 'Please enter a valid date.',
            'in' => 'Please choose an option from the list.',
            'max' => 'This field is too long.',
            'prohibited' => 'Your request could not be sent.',
            'cv.required' => 'Please attach your CV.',
            'cv.file' => 'Your CV could not be uploaded. Please check that it does not exceed 5 MB.',
            'cv.uploaded' => 'Your CV could not be uploaded. Please check that it does not exceed 5 MB.',
            'cv.mimes' => 'Your CV must be a PDF, DOC or DOCX file.',
            'cv.max' => 'Your CV must not exceed 5 MB.',
        ] : [
            'required' => 'Ce champ est requis.',
            'email' => 'Merci de saisir une adresse e-mail valide.',
            'regex' => 'Merci de saisir un numéro de téléphone valide.',
            'date' => 'Merci de saisir une date valide.',
            'in' => 'Merci de choisir une option dans la liste.',
            'max' => 'Ce champ est trop long.',
            'prohibited' => 'Votre demande n’a pas pu être envoyée.',
            'cv.required' => 'Merci de joindre votre CV.',
            'cv.file' => 'Votre CV n’a pas pu être envoyé. Vérifiez qu’il ne dépasse pas 5 Mo.',
            'cv.uploaded' => 'Votre CV n’a pas pu être envoyé. Vérifiez qu’il ne dépasse pas 5 Mo.',
            'cv.mimes' => 'Votre CV doit être un fichier PDF, DOC ou DOCX.',
            'cv.max' => 'Votre CV ne doit pas dépasser 5 Mo.',
        ];
    }

    protected function failureMessage(string $locale, string $email): string
    {
        return $locale === 'en'
            ? "Your request could not be sent. Please try again in a few moments or write to us at {$email}."
            : "Votre demande n’a pas pu être transmise. Merci de réessayer dans quelques instants ou de nous écrire à {$email}.";
    }

    /** JSON for the enhanced (JavaScript) form, redirect with a flash status otherwise. */
    protected function respond(Request $request, string $form, string $anchor, bool $ok, ?string $message = null): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return $ok
                ? response()->json(['ok' => true], 201)
                : response()->json(['ok' => false, 'message' => $message], 503);
        }

        $redirect = redirect()->to(strtok(url()->previous(), '#').'#'.$anchor)
            ->with('form_status', ['form' => $form, 'ok' => $ok, 'message' => $message]);

        return $ok ? $redirect : $redirect->withInput();
    }
}
