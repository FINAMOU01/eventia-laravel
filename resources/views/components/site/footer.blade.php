@props(['locale'])
@php
    $text = Site::text($locale);
    $t = [
        'fr' => ['nav' => 'Navigation du pied de page', 'navTitle' => 'Navigation', 'rights' => 'Tous droits réservés.', 'legal' => 'Mentions légales'],
        'en' => ['nav' => 'Footer navigation', 'navTitle' => 'Navigation', 'rights' => 'All rights reserved.', 'legal' => 'Legal notice'],
    ][$locale];
    $contact = Site::CONTACT;
@endphp
<footer class="tone-deep bg-ink pb-16 text-fg md:pb-0">
  <x-ui.container :grid="true" class="gap-y-6 py-8 md:gap-y-8 lg:py-12">
    <div class="col-span-full flex flex-col gap-4 md:col-span-8 lg:col-span-4">
      <a href="{{ I18n::localizeHref('/#accueil', $locale) }}" aria-label="{{ Site::NAME }} — {{ $text['backHome'] }}" class="flex items-center gap-3 self-start rounded-media">
        <x-site.logo class="h-10 lg:h-11" />
        <span aria-hidden="true" class="font-display text-[1.375rem] tracking-[0.12em] text-fg">{{ Site::NAME }}</span>
      </a>
      <p class="max-w-xs text-small text-fg-muted">{{ $text['title'] }}.</p>
      <p class="text-eyebrow font-medium tracking-[0.18em] text-accent uppercase">{{ implode(' ', array_map(fn ($word) => "{$word}.", $text['signature'])) }}</p>
    </div>

    <nav aria-label="{{ $t['nav'] }}" class="col-span-full md:col-span-4 lg:col-span-4 lg:col-start-6">
      <p class="text-eyebrow text-fg-muted uppercase">{{ $t['navTitle'] }}</p>
      <ul class="mt-3 grid grid-cols-3 gap-x-4 gap-y-2 text-small md:mt-4 md:grid-cols-2 md:gap-x-6 md:gap-y-2.5">
        @foreach (Site::navigation($locale) as $item)
          <li><a href="{{ $item['href'] }}" class="text-fg transition-colors hover:text-accent">{{ $item['label'] }}</a></li>
        @endforeach
      </ul>
    </nav>

    <div class="col-span-full md:col-span-4 lg:col-span-3 lg:col-start-10">
      <p class="text-eyebrow text-fg-muted uppercase">Contact</p>
      <ul class="mt-3 flex flex-col gap-2 text-small md:mt-4 md:gap-2.5">
        <li><x-ui.link href="mailto:{{ $contact['email'] }}" class="break-all">{{ $contact['email'] }}</x-ui.link></li>
        <li class="flex flex-wrap gap-x-4 gap-y-2.5">
          <x-ui.link :href="$contact['phoneHref']">{{ $contact['phoneDisplay'] }}</x-ui.link>
          <x-ui.link :href="$contact['phone2Href']">{{ $contact['phone2Display'] }}</x-ui.link>
        </li>
        <li class="text-fg">{{ $contact['address'] }}</li>
      </ul>
    </div>
  </x-ui.container>

  <x-ui.container class="flex flex-col gap-2 border-t border-line py-4 text-small text-fg-muted sm:flex-row sm:items-center sm:justify-between">
    <p>© {{ date('Y') }} {{ Site::NAME }}. {{ $t['rights'] }}</p>
    <a href="{{ I18n::localizeHref('/mentions-legales', $locale) }}" class="transition-colors hover:text-fg">{{ $t['legal'] }}</a>
  </x-ui.container>
</footer>
