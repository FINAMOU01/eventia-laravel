@props(['locale'])
@php
    $t = [
        'fr' => ['email' => 'E-mail', 'phone' => 'Téléphone', 'location' => 'Localisation'],
        'en' => ['email' => 'E-mail', 'phone' => 'Phone', 'location' => 'Location'],
    ][$locale];
    $contact = Site::CONTACT;
    $channels = [
        ['icon' => 'mail', 'label' => $t['email'], 'value' => $contact['email'], 'href' => 'mailto:'.$contact['email']],
        ['icon' => 'phone', 'label' => $t['phone'], 'value' => $contact['phoneDisplay'], 'href' => $contact['phoneHref']],
        ['icon' => 'map-pin', 'label' => $t['location'], 'value' => $contact['address'], 'href' => null],
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
