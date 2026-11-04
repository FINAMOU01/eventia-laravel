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
            'file' => 'This file could not be uploaded. Please check that it does not exceed 5 MB.',
            'uploaded' => 'This file could not be uploaded. Please check that it does not exceed 5 MB.',
            'cv.required' => 'Please attach your CV.',
            'cover_letter.required' => 'Please attach your cover letter.',
            'photo_portrait.required' => 'Please attach a recent portrait photo.',
            'photo_full.required' => 'Please attach a recent full-length photo.',
            'cv.mimes' => 'Your CV must be a PDF, DOC or DOCX file.',
            'cover_letter.mimes' => 'Your cover letter must be a PDF, DOC or DOCX file.',
            'photo_portrait.mimes' => 'The photo must be a JPG, PNG, WEBP or HEIC image.',
            'photo_full.mimes' => 'The photo must be a JPG, PNG, WEBP or HEIC image.',
            'cv.max' => 'This file must not exceed 5 MB.',
            'cover_letter.max' => 'This file must not exceed 5 MB.',
            'photo_portrait.max' => 'This file must not exceed 5 MB.',
            'photo_full.max' => 'This file must not exceed 5 MB.',
        ] : [
            'required' => 'Ce champ est requis.',
            'email' => 'Merci de saisir une adresse e-mail valide.',
            'regex' => 'Merci de saisir un numéro de téléphone valide.',
            'date' => 'Merci de saisir une date valide.',
            'in' => 'Merci de choisir une option dans la liste.',
            'max' => 'Ce champ est trop long.',
            'prohibited' => 'Votre demande n’a pas pu être envoyée.',
            'file' => 'Ce fichier n’a pas pu être envoyé. Vérifiez qu’il ne dépasse pas 5 Mo.',
            'uploaded' => 'Ce fichier n’a pas pu être envoyé. Vérifiez qu’il ne dépasse pas 5 Mo.',
            'cv.required' => 'Merci de joindre votre CV.',
            'cover_letter.required' => 'Merci de joindre votre lettre de motivation.',
            'photo_portrait.required' => 'Merci de joindre une photo portrait récente.',
            'photo_full.required' => 'Merci de joindre une photo récente en pied.',
            'cv.mimes' => 'Votre CV doit être un fichier PDF, DOC ou DOCX.',
            'cover_letter.mimes' => 'Votre lettre de motivation doit être un fichier PDF, DOC ou DOCX.',
            'photo_portrait.mimes' => 'La photo doit être une image JPG, PNG, WEBP ou HEIC.',
            'photo_full.mimes' => 'La photo doit être une image JPG, PNG, WEBP ou HEIC.',
            'cv.max' => 'Ce fichier ne doit pas dépasser 5 Mo.',
            'cover_letter.max' => 'Ce fichier ne doit pas dépasser 5 Mo.',
            'photo_portrait.max' => 'Ce fichier ne doit pas dépasser 5 Mo.',
            'photo_full.max' => 'Ce fichier ne doit pas dépasser 5 Mo.',
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
