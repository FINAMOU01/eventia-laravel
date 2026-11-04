@props(['locale'])
@php
    $t = [
        'fr' => ['email' => 'E-mail', 'phone' => 'Téléphone', 'location' => 'Adresse', 'socials' => 'Réseaux sociaux'],
        'en' => ['email' => 'E-mail', 'phone' => 'Phone', 'location' => 'Address', 'socials' => 'Social media'],
    ][$locale];
    $contact = Site::CONTACT;
    $channels = [
        ['icon' => 'map-pin', 'label' => $t['location'], 'value' => $contact['address'], 'href' => null],
        ['icon' => 'phone', 'label' => $t['phone'], 'value' => $contact['phoneDisplay'], 'href' => $contact['phoneHref']],
        ['icon' => 'phone', 'label' => $t['phone'], 'value' => $contact['phone2Display'], 'href' => $contact['phone2Href']],
        ['icon' => 'mail', 'label' => $t['email'], 'value' => $contact['email'], 'href' => 'mailto:'.$contact['email']],
    ];
@endphp
<ul class="flex flex-col border-t border-line">
  @foreach ($channels as $channel)
    @php $tag = $channel['href'] ? 'a' : 'div'; @endphp
    <li class="border-b border-line">
      <{{ $tag }} @if ($channel['href']) href="{{ $channel['href'] }}" class="group/channel flex items-center gap-4 py-5" @else class="flex items-center gap-4 py-5" @endif><span class="grid size-11 shrink-0 place-items-center rounded-full border border-line text-accent transition-colors group-hover/channel:border-accent"><x-icon :name="$channel['icon']" class="size-5" /></span><span class="flex min-w-0 flex-col gap-0.5"><span class="text-eyebrow font-medium tracking-[0.14em] text-fg-muted uppercase">{{ $channel['label'] }}</span><span class="text-lead text-fg [overflow-wrap:anywhere] transition-colors group-hover/channel:text-accent">{{ $channel['value'] }}</span></span></{{ $tag }}>
    </li>
  @endforeach
</ul>
<div class="mt-8">
  <p class="text-eyebrow font-medium tracking-[0.14em] text-fg-muted uppercase">{{ $t['socials'] }}</p>
  <ul class="mt-3 flex flex-wrap gap-x-6 gap-y-2 text-body">
    @foreach (Site::SOCIALS as $social)
      <li>
        @if ($social['url'])
          <x-ui.link :href="$social['url']" target="_blank">{{ $social['label'][$locale] }}</x-ui.link>
        @else
          <span class="text-fg">{{ $social['label'][$locale] }}</span>
        @endif
      </li>
    @endforeach
  </ul>
</div>
