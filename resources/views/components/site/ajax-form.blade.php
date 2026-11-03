@props(['id', 'form', 'action', 'locale', 'title', 'submit', 'successTitle', 'successText', 'privacy', 'contactEmail', 'files' => false])
@php
    $t = [
        'fr' => [
            'required' => 'Ce champ est requis.',
            'invalidEmail' => 'Merci de saisir une adresse e-mail valide.',
            'invalidPhone' => 'Merci de saisir un numéro de téléphone valide.',
            'invalidFile' => 'Ce format de fichier n’est pas accepté.',
            'fileTooLarge' => 'Ce fichier ne doit pas dépasser 5 Mo.',
            'tooMany' => 'Trop de demandes ont été envoyées depuis votre connexion. Merci de réessayer dans une heure.',
            'failure' => "Votre demande n’a pas pu être transmise. Merci de réessayer dans quelques instants ou de nous écrire à {$contactEmail}.",
            'submitting' => 'Envoi en cours…',
            'again' => 'Envoyer une autre demande',
            'noteStart' => 'Les champs marqués d’un',
            'noteEnd' => 'sont requis.',
        ],
        'en' => [
            'required' => 'This field is required.',
            'invalidEmail' => 'Please enter a valid e-mail address.',
            'invalidPhone' => 'Please enter a valid phone number.',
            'invalidFile' => 'This file format is not accepted.',
            'fileTooLarge' => 'This file must not exceed 5 MB.',
            'tooMany' => 'Too many requests have been sent from your connection. Please try again in an hour.',
            'failure' => "Your request could not be sent. Please try again in a few moments or write to us at {$contactEmail}.",
            'submitting' => 'Sending…',
            'again' => 'Send another request',
            'noteStart' => 'Fields marked with an',
            'noteEnd' => 'are required.',
        ],
    ][$locale];
    // Result of a submission made without JavaScript (redirect back with a flash status).
    $flash = session('form_status');
    $flash = ($flash['form'] ?? null) === $form ? $flash : null;
    $initialStatus = $flash ? ($flash['ok'] ? 'success' : 'error') : 'idle';
    $initialErrors = $errors->any() && old('_form') === $form ? collect($errors->getMessages())->map(fn ($messages) => $messages[0])->all() : [];
@endphp
<div
  id="{{ $id }}"
  role="region"
  aria-labelledby="{{ $id }}-titre"
  x-data="ajaxForm({ messages: @js($t), initialStatus: @js($initialStatus), initialErrors: @js((object) $initialErrors), initialMessage: @js($flash['message'] ?? '') })"
  class="rounded-card border border-line bg-surface p-6 sm:p-10 lg:p-12"
>
  <x-ui.eyebrow id="{{ $id }}-titre">{{ $title }}</x-ui.eyebrow>

  {{-- Shown only once the server has confirmed the request was stored and sent. --}}
  <div x-show="status === 'success'" @unless ($initialStatus === 'success') x-cloak @endunless role="status" class="mt-8 flex flex-col items-start gap-5">
    <x-icon name="check-circle-2" class="size-10 text-accent" />
    <p class="font-display text-h3 text-fg">{{ $successTitle }}</p>
    <p class="max-w-md text-body text-fg-muted">{{ $successText }}</p>
    <x-ui.button variant="text" x-on:click="startOver()">{{ $t['again'] }}</x-ui.button>
  </div>

  <form
    x-show="status !== 'success'"
    @if ($initialStatus === 'success') x-cloak @endif
    x-ref="form"
    method="POST"
    action="{{ $action }}"
    @if ($files) enctype="multipart/form-data" @endif
    novalidate
    x-on:submit.prevent="submit()"
    x-on:input="recheck($event)"
    x-on:change="recheck($event)"
    aria-busy="false"
    x-bind:aria-busy="status === 'submitting' ? 'true' : 'false'"
    aria-describedby="{{ $id }}-mention"
    class="mt-8 flex flex-col gap-8"
  >
    @csrf
    <input type="hidden" name="_form" value="{{ $form }}">
    {{-- Invisible to visitors; bots that fill it in are rejected. --}}
    <div aria-hidden="true" class="absolute -left-[9999px] h-px w-px overflow-hidden">
      <label for="{{ $id }}-website">Website</label>
      <input id="{{ $id }}-website" type="text" name="website" tabindex="-1" autocomplete="off">
    </div>

    <div class="grid gap-x-8 gap-y-7 sm:grid-cols-2">
      {{ $slot }}
    </div>

    <p x-show="status === 'error'" @unless ($initialStatus === 'error') x-cloak @endunless role="alert" class="flex items-start gap-2 rounded-card border border-line bg-canvas px-4 py-3 text-small text-fg">
      <x-icon name="alert-circle" class="mt-0.5 size-4 shrink-0 text-accent" />
      <span x-text="serverMessage">{{ $flash['message'] ?? '' }}</span>
    </p>

    <div class="flex flex-col gap-4">
      <button type="submit" x-bind:disabled="status === 'submitting'" class="{{ Ui::buttonClasses('primary', 'lg', 'w-full sm:w-auto sm:self-start') }}">
        <span x-text="status === 'submitting' ? {{ \Illuminate\Support\Js::from($t['submitting']) }} : {{ \Illuminate\Support\Js::from($submit) }}">{{ $submit }}</span>
        <span aria-hidden="true" class="inline-flex shrink-0 transition-transform motion-safe:group-hover/button:translate-x-0.5 [&_svg]:size-4"><x-icon name="loader-2" class="animate-spin" x-show="status === 'submitting'" x-cloak /><x-icon name="arrow-right" x-show="status !== 'submitting'" /></span>
      </button>
      <p id="{{ $id }}-mention" class="text-small text-fg-muted">{{ $t['noteStart'] }} <span class="text-accent">*</span> {{ $t['noteEnd'] }}</p>
      <p class="text-small text-fg-muted">{{ $privacy }}</p>
    </div>
  </form>
</div>
