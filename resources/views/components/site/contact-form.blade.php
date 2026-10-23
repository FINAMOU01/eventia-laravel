@props(['locale'])
@php
    $t = [
        'fr' => [
            'required' => 'Ce champ est requis.',
            'invalidEmail' => 'Merci de saisir une adresse e-mail valide.',
            'title' => 'Demande de devis',
            'successTitle' => 'Votre demande est prête.',
            'successText' => 'Votre messagerie s’est ouverte avec votre demande pré-remplie : il vous suffit d’envoyer l’e-mail pour nous la transmettre. Si elle ne s’est pas ouverte, écrivez-nous à',
            'again' => 'Faire une nouvelle demande',
            'labels' => [
                'name' => 'Nom & prénom',
                'company' => 'Société',
                'email' => 'E-mail',
                'phone' => 'Téléphone',
                'date' => 'Date',
                'location' => 'Lieu',
                'eventType' => 'Type d’événement',
                'need' => 'Besoin',
            ],
            'placeholders' => [
                'location' => 'Ville, salle…',
                'eventType' => 'Concours, lancement de produit, salon, gala…',
                'need' => 'Nombre de personnes, horaires, profils, tenue, langues…',
            ],
            'submitting' => 'Préparation…',
            'submit' => 'Envoyer ma demande',
            'noteStart' => 'Les champs marqués d’un',
            'noteEnd' => 'sont requis. Votre demande s’ouvre dans votre messagerie, prête à être envoyée à',
        ],
        'en' => [
            'required' => 'This field is required.',
            'invalidEmail' => 'Please enter a valid e-mail address.',
            'title' => 'Quote request',
            'successTitle' => 'Your request is ready.',
            'successText' => 'Your e-mail app has opened with your request pre-filled: simply send the e-mail to pass it on to us. If it did not open, write to us at',
            'again' => 'Make a new request',
            'labels' => [
                'name' => 'Full name',
                'company' => 'Company',
                'email' => 'E-mail',
                'phone' => 'Phone',
                'date' => 'Date',
                'location' => 'Venue',
                'eventType' => 'Type of event',
                'need' => 'Requirements',
            ],
            'placeholders' => [
                'location' => 'City, venue…',
                'eventType' => 'Pageant, product launch, trade show, gala…',
                'need' => 'Number of people, schedule, profiles, dress code, languages…',
            ],
            'submitting' => 'Preparing…',
            'submit' => 'Send my request',
            'noteStart' => 'Fields marked with an',
            'noteEnd' => 'are required. Your request opens in your e-mail app, ready to be sent to',
        ],
    ][$locale];
    // Port of lib/quote-request.ts: labels, subject and intro of the pre-filled e-mail.
    $email = [
        'fr' => [
            'labels' => ['name' => 'Nom & prénom', 'company' => 'Société', 'email' => 'E-mail', 'phone' => 'Téléphone', 'date' => 'Date', 'location' => 'Lieu', 'eventType' => 'Type d’événement', 'need' => 'Besoin'],
            'subject' => 'Demande de devis',
            'intro' => "Bonjour,\n\nJe souhaite obtenir un devis pour mon événement.",
        ],
        'en' => [
            'labels' => ['name' => 'Full name', 'company' => 'Company', 'email' => 'E-mail', 'phone' => 'Phone', 'date' => 'Date', 'location' => 'Venue', 'eventType' => 'Type of event', 'need' => 'Requirements'],
            'subject' => 'Quote request',
            'intro' => "Hello,\n\nI would like to request a quote for my event.",
        ],
    ][$locale];
    $required = ['name', 'email', 'need'];
    $inputClasses = 'w-full rounded-none border-0 border-b border-input bg-transparent px-0 py-3 text-body text-fg transition-[border-color,box-shadow] duration-300 placeholder:text-fg-muted/60 hover:border-fg/40 focus:border-accent focus:shadow-[0_1px_0_0_var(--color-accent)] focus-visible:outline-none aria-invalid:border-fg aria-invalid:shadow-[0_1px_0_0_var(--color-fg)]';
    $fields = [
        ['name' => 'name', 'type' => 'text', 'attrs' => ['autocomplete' => 'name']],
        ['name' => 'company', 'type' => 'text', 'attrs' => ['autocomplete' => 'organization']],
        ['name' => 'email', 'type' => 'email', 'attrs' => ['autocomplete' => 'email', 'inputmode' => 'email']],
        ['name' => 'phone', 'type' => 'tel', 'attrs' => ['autocomplete' => 'tel', 'inputmode' => 'tel']],
        ['name' => 'date', 'type' => 'date', 'attrs' => []],
        ['name' => 'location', 'type' => 'text', 'attrs' => ['placeholder' => $t['placeholders']['location']]],
        ['name' => 'eventType', 'type' => 'text', 'attrs' => ['placeholder' => $t['placeholders']['eventType']], 'wide' => true],
        ['name' => 'need', 'type' => 'textarea', 'attrs' => ['rows' => 5, 'placeholder' => $t['placeholders']['need']], 'wide' => true],
    ];
    $contactEmail = Site::CONTACT['email'];
@endphp
<div
  id="demande-devis"
  role="region"
  aria-labelledby="devis-titre"
  x-data="quoteForm({ required: @js($required), messages: { required: @js($t['required']), invalidEmail: @js($t['invalidEmail']) }, email: @js($email), to: @js($contactEmail) })"
  class="rounded-card border border-line bg-surface p-6 sm:p-10 lg:p-12"
>
  <x-ui.eyebrow id="devis-titre">{{ $t['title'] }}</x-ui.eyebrow>

  <div x-show="status === 'success'" x-cloak role="status" class="mt-8 flex flex-col items-start gap-5">
    <x-icon name="check-circle-2" class="size-10 text-accent" />
    <p class="font-display text-h3 text-fg">{{ $t['successTitle'] }}</p>
    <p class="max-w-md text-body text-fg-muted">{{ $t['successText'] }} <a href="mailto:{{ $contactEmail }}" class="text-accent underline underline-offset-4">{{ $contactEmail }}</a>.</p>
    <x-ui.button variant="text" x-on:click="startOver()">{{ $t['again'] }}</x-ui.button>
  </div>

  <form
    x-show="status !== 'success'"
    x-ref="form"
    novalidate
    x-on:submit.prevent="submit()"
    x-on:input="recheck($event)"
    aria-busy="false"
    x-bind:aria-busy="status === 'submitting' ? 'true' : 'false'"
    aria-describedby="devis-mention"
    class="mt-8 flex flex-col gap-8"
  >
    <div class="grid gap-x-8 gap-y-7 sm:grid-cols-2">
      @foreach ($fields as $field)
        @php
            $name = $field['name'];
            $id = "devis-{$name}";
            $errorId = "{$id}-erreur";
            $isRequired = in_array($name, $required, true);
        @endphp
        <div @class(['flex flex-col', 'sm:col-span-2' => $field['wide'] ?? false])>
          <label for="{{ $id }}" class="text-eyebrow font-medium tracking-[0.14em] text-fg-muted uppercase">{{ $t['labels'][$name] }}@if ($isRequired)<span aria-hidden="true" class="text-accent"> *</span>@endif</label>
          @php
              $common = new \Illuminate\View\ComponentAttributeBag(array_merge([
                  'id' => $id,
                  'name' => $name,
                  'required' => $isRequired ? true : null,
              ], $field['attrs']));
          @endphp
          @if ($field['type'] === 'textarea')
            <textarea {{ $common }} :aria-invalid="errors.{{ $name }} ? 'true' : null" :aria-describedby="errors.{{ $name }} ? '{{ $errorId }}' : null" class="{{ Ui::cn($inputClasses, 'min-h-36 resize-y') }}"></textarea>
          @else
            <input {{ $common }} :aria-invalid="errors.{{ $name }} ? 'true' : null" :aria-describedby="errors.{{ $name }} ? '{{ $errorId }}' : null" type="{{ $field['type'] }}" class="{{ $inputClasses }}">
          @endif
          <template x-if="errors.{{ $name }}">
            <p id="{{ $errorId }}" class="mt-2 flex items-center gap-1.5 text-small text-fg">
              <x-icon name="alert-circle" class="size-4 shrink-0 text-accent" />
              <span class="contents" x-text="errors.{{ $name }}"></span>
            </p>
          </template>
        </div>
      @endforeach
    </div>

    <div class="flex flex-col gap-4">
      <button type="submit" x-bind:disabled="status === 'submitting'" class="{{ Ui::buttonClasses('primary', 'lg', 'w-full sm:w-auto sm:self-start') }}">
        <span x-text="status === 'submitting' ? {{ \Illuminate\Support\Js::from($t['submitting']) }} : {{ \Illuminate\Support\Js::from($t['submit']) }}">{{ $t['submit'] }}</span>
        <span aria-hidden="true" class="inline-flex shrink-0 transition-transform motion-safe:group-hover/button:translate-x-0.5 [&_svg]:size-4"><x-icon name="loader-2" class="animate-spin" x-show="status === 'submitting'" x-cloak /><x-icon name="arrow-right" x-show="status !== 'submitting'" /></span>
      </button>
      <p id="devis-mention" class="text-small text-fg-muted">{{ $t['noteStart'] }} <span class="text-accent">*</span> {{ $t['noteEnd'] }} {{ $contactEmail }}.</p>
    </div>
  </form>
</div>
