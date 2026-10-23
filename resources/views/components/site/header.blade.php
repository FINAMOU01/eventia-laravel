@props(['locale', 'pathname'])
@php
    $text = Site::text($locale);
    $t = [
        'fr' => ['open' => 'Ouvrir le menu', 'close' => 'Fermer le menu', 'mainNav' => 'Navigation principale', 'menuNav' => 'Menu principal'],
        'en' => ['open' => 'Open the menu', 'close' => 'Close the menu', 'mainNav' => 'Main navigation', 'menuNav' => 'Main menu'],
    ][$locale];
    $navigation = Site::navigation($locale);
    $homeHref = I18n::localizeHref('/#accueil', $locale);
    $ctaHref = I18n::localizeHref(Site::PRIMARY_CTA_HREF, $locale);
    $basePath = I18n::stripLocale($pathname);
    // Pages opening on a dark hero keep the bar transparent with light text until the user scrolls.
    $darkHero = in_array($basePath, ['/', '/expertises', '/realisations', '/equipe', '/recrutement', '/contact'], true);
    $routeSection = collect($navigation)->firstWhere('href', $pathname)['id'] ?? null;
    $initialActive = $routeSection ?? 'accueil';
    $contact = Site::CONTACT;
@endphp
<header
  x-data="siteHeader({ darkHero: @js($darkHero), routeSection: @js($routeSection), sections: @js(array_column($navigation, 'id')) })"
  x-ref="header"
  class="fixed inset-x-0 top-0 z-50 border-b text-fg transition-[background-color,border-color,box-shadow] duration-300 {{ $darkHero ? 'tone-deep border-transparent bg-transparent' : 'border-transparent bg-transparent' }}"
  :class="headerClasses"
>
  <x-ui.container class="flex h-(--header-height) items-center gap-6">
    <a href="{{ $homeHref }}" aria-label="{{ Site::NAME }} — {{ $text['backHome'] }}" x-on:click="navigateFromMenu($event, @js($homeHref))" class="flex shrink-0 items-center gap-3 rounded-media">
      <x-site.logo :preload="true" />
      <span aria-hidden="true" class="font-display text-[1.375rem] leading-none tracking-[0.24em] text-fg lg:text-[1.5rem]">EVENTIA</span>
    </a>

    <nav aria-label="{{ $t['mainNav'] }}" class="ml-auto hidden xl:block">
      <ul class="flex items-center gap-8">
        @foreach ($navigation as $item)
          @php $isActive = $initialActive === $item['id']; @endphp
          <li>
            <a
              href="{{ $item['href'] }}"
              @if ($isActive) aria-current="true" @endif
              :aria-current="active === @js($item['id']) ? 'true' : null"
              @class([
                  'relative block py-2 text-button uppercase transition-colors after:absolute after:inset-x-0 after:bottom-0 after:h-px after:origin-left after:bg-accent after:transition-transform after:duration-300',
                  'text-fg after:scale-x-100' => $isActive,
                  'text-fg-muted after:scale-x-0 hover:text-fg hover:after:scale-x-100' => ! $isActive,
              ])
              :class="{ 'text-fg after:scale-x-100': active === @js($item['id']), 'text-fg-muted after:scale-x-0 hover:text-fg hover:after:scale-x-100': active !== @js($item['id']) }"
            >{{ $item['label'] }}</a>
          </li>
        @endforeach
      </ul>
    </nav>

    <x-site.language-switcher :locale="$locale" :base-path="$basePath" class="ml-auto xl:ml-6" />

    <div class="hidden sm:block">
      <x-ui.link :href="$ctaHref" appearance="primary" x-on:click="navigateFromMenu($event, {{ \Illuminate\Support\Js::from($ctaHref) }})" class="animate-cta-pulse hover:animate-none focus-visible:animate-none">{{ $text['primaryCta'] }}</x-ui.link>
    </div>

    <x-ui.icon-button
      x-ref="toggle"
      :label="$t['open']"
      x-bind:aria-label="isOpen ? {{ \Illuminate\Support\Js::from($t['close']) }} : {{ \Illuminate\Support\Js::from($t['open']) }}"
      variant="ghost"
      aria-expanded="false"
      x-bind:aria-expanded="isOpen ? 'true' : 'false'"
      aria-controls="menu-principal"
      x-on:click="toggleMenu()"
      class="-mr-2 xl:hidden"
    >
      <x-slot:icon><x-icon name="x" x-show="isOpen" x-cloak /><x-icon name="menu" x-show="!isOpen" /></x-slot:icon>
    </x-ui.icon-button>
  </x-ui.container>

  <div
    x-ref="menu"
    x-show="menuVisible"
    x-cloak
    id="menu-principal"
    class="tone-deep fixed inset-x-0 top-(--header-height) bottom-0 overflow-y-auto overscroll-contain bg-canvas text-fg xl:hidden"
    style="opacity:0"
  >
    <x-ui.container class="flex min-h-full flex-col gap-10 pt-4 pb-10">
      <nav aria-label="{{ $t['menuNav'] }}">
        <ol>
          @foreach ($navigation as $index => $item)
            @php $isActive = $initialActive === $item['id']; @endphp
            <li data-menu-item class="border-b border-line" style="{{ Ui::revealStyle('up') }}">
              <a
                href="{{ $item['href'] }}"
                @if ($isActive) aria-current="true" @endif
                :aria-current="active === @js($item['id']) ? 'true' : null"
                x-on:click="navigateFromMenu($event, @js($item['href']))"
                @class([
                    'flex items-baseline gap-5 py-4 font-display text-h3 transition-colors',
                    'text-accent' => $isActive,
                    'text-fg hover:text-accent' => ! $isActive,
                ])
                :class="{ 'text-accent': active === @js($item['id']), 'text-fg hover:text-accent': active !== @js($item['id']) }"
              ><span aria-hidden="true" class="w-6 font-sans text-eyebrow text-fg-muted">{{ Web::pad($index + 1) }}</span>{{ $item['label'] }}</a>
            </li>
          @endforeach
        </ol>
      </nav>

      <div data-menu-item class="sm:hidden" style="{{ Ui::revealStyle('up') }}">
        <x-ui.link :href="$ctaHref" appearance="primary" size="lg" x-on:click="navigateFromMenu($event, {{ \Illuminate\Support\Js::from($ctaHref) }})" class="w-full">{{ $text['primaryCta'] }}</x-ui.link>
      </div>

      <div data-menu-item class="mt-auto flex flex-col items-start gap-2 text-small text-fg-muted" style="{{ Ui::revealStyle('up') }}">
        <x-ui.link href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</x-ui.link>
        <x-ui.link :href="$contact['phoneHref']">{{ $contact['phoneDisplay'] }}</x-ui.link>
        <p>{{ $contact['address'] }}</p>
        <p class="pt-4 text-eyebrow text-accent uppercase">{{ implode(' ', array_map(fn ($word) => "{$word}.", $text['signature'])) }}</p>
      </div>
    </x-ui.container>
  </div>
</header>
