@props(['locale', 'pathname'])
@php
    $text = Site::text($locale);
    $t = [
        'fr' => ['open' => 'Ouvrir le menu', 'close' => 'Fermer le menu', 'mainNav' => 'Navigation principale', 'menuNav' => 'Menu principal', 'submenu' => 'Afficher les expertises'],
        'en' => ['open' => 'Open the menu', 'close' => 'Close the menu', 'mainNav' => 'Main navigation', 'menuNav' => 'Main menu', 'submenu' => 'Show the areas of expertise'],
    ][$locale];
    $navigation = Site::navigation($locale);
    $homeHref = I18n::localizeHref('/#accueil', $locale);
    $ctaHref = I18n::localizeHref(Site::PRIMARY_CTA_HREF, $locale);
    $basePath = I18n::stripLocale($pathname);
    // Pages opening on a dark hero keep the bar transparent with light text until the user scrolls.
    $darkHero = $basePath !== '/mentions-legales';
    // Division pages highlight "Nos expertises"; other pages highlight their own entry.
    $routeSection = str_starts_with($basePath, '/expertises/')
        ? 'expertise'
        : (collect($navigation)->firstWhere('href', $pathname)['id'] ?? null);
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
          @php
              $isActive = $initialActive === $item['id'];
              $linkClasses = 'relative block py-2 text-button uppercase transition-colors after:absolute after:inset-x-0 after:bottom-0 after:h-px after:origin-left after:bg-accent after:transition-transform after:duration-300';
          @endphp
          @if ($item['children'])
            <li
              class="relative flex items-center gap-1"
              x-data="{ open: false }"
              x-on:mouseenter="open = true"
              x-on:mouseleave="open = false"
              x-on:keydown.escape.stop="open = false; $refs.trigger.focus()"
              x-on:focusout="if (!$el.contains($event.relatedTarget)) open = false"
            >
              <a
                href="{{ $item['href'] }}"
                @if ($isActive) aria-current="true" @endif
                :aria-current="active === @js($item['id']) ? 'true' : null"
                @class([$linkClasses, 'text-fg after:scale-x-100' => $isActive, 'text-fg-muted after:scale-x-0 hover:text-fg hover:after:scale-x-100' => ! $isActive])
                :class="{ 'text-fg after:scale-x-100': active === @js($item['id']), 'text-fg-muted after:scale-x-0 hover:text-fg hover:after:scale-x-100': active !== @js($item['id']) }"
              >{{ $item['label'] }}</a>
              <button
                type="button"
                x-ref="trigger"
                aria-label="{{ $t['submenu'] }}"
                aria-haspopup="true"
                aria-expanded="false"
                :aria-expanded="open ? 'true' : 'false'"
                aria-controls="sous-menu-expertises"
                x-on:click="open = !open"
                class="-mr-1 inline-flex size-6 items-center justify-center text-fg-muted transition-colors hover:text-fg"
              ><x-icon name="chevron-down" class="size-3.5 transition-transform duration-300" x-bind:class="open && 'rotate-180'" /></button>

              {{-- Same deep tone and hairlines as the mobile menu. --}}
              <div
                id="sous-menu-expertises"
                x-show="open"
                x-cloak
                x-transition:enter="transition duration-300 ease-eventia"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:leave="transition duration-200 ease-eventia"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="tone-deep absolute top-full left-1/2 w-[25rem] -translate-x-1/2 pt-3"
              >
                <ul class="rounded-card border border-line bg-canvas p-2 text-fg shadow-lift">
                  @foreach ($item['children'] as $child)
                    @php $childActive = $basePath === Metadata::PATHS[$child['id']]; @endphp
                    <li>
                      <a
                        href="{{ $child['href'] }}"
                        @if ($childActive) aria-current="page" @endif
                        @class(['group/sub flex items-baseline gap-4 rounded-media px-4 py-3 transition-colors hover:bg-white/5', 'bg-white/5' => $childActive])
                      >
                        <span aria-hidden="true" class="font-display text-base text-accent italic">{{ $child['number'] }}</span>
                        <span class="flex flex-col gap-1">
                          <span class="text-button tracking-[0.12em] text-fg uppercase transition-colors group-hover/sub:text-accent">{{ $child['label'] }}</span>
                          <span class="font-display text-small text-fg-muted italic">{{ $child['signature'] }}</span>
                        </span>
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </li>
          @else
            <li>
              <a
                href="{{ $item['href'] }}"
                @if ($isActive) aria-current="true" @endif
                :aria-current="active === @js($item['id']) ? 'true' : null"
                @class([$linkClasses, 'text-fg after:scale-x-100' => $isActive, 'text-fg-muted after:scale-x-0 hover:text-fg hover:after:scale-x-100' => ! $isActive])
                :class="{ 'text-fg after:scale-x-100': active === @js($item['id']), 'text-fg-muted after:scale-x-0 hover:text-fg hover:after:scale-x-100': active !== @js($item['id']) }"
              >{{ $item['label'] }}</a>
            </li>
          @endif
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
              @if ($item['children'])
                {{-- The three divisions, indented under "Nos expertises". --}}
                <ul class="-mt-1 flex flex-col pb-4 pl-11">
                  @foreach ($item['children'] as $child)
                    @php $childActive = $basePath === Metadata::PATHS[$child['id']]; @endphp
                    <li>
                      <a
                        href="{{ $child['href'] }}"
                        @if ($childActive) aria-current="page" @endif
                        @class(['flex items-baseline gap-3 py-2 text-button tracking-[0.12em] uppercase transition-colors', 'text-accent' => $childActive, 'text-fg-muted hover:text-accent' => ! $childActive])
                      ><span aria-hidden="true" class="font-display text-small tracking-normal text-accent normal-case italic">{{ $child['number'] }}</span>{{ $child['label'] }}</a>
                    </li>
                  @endforeach
                </ul>
              @endif
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
