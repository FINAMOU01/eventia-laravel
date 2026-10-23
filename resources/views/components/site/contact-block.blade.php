@props(['locale', 'aside'])
{{-- Two-column block: contact details on the left, quote form on the right. --}}
<div class="site-grid gap-y-14">
  <x-ui.reveal class="col-span-full lg:sticky lg:top-[calc(var(--header-height)+2rem)] lg:col-span-5 lg:self-start">{{ $aside }}</x-ui.reveal>
  <x-ui.reveal :delay="0.1" class="col-span-full lg:col-span-7 xl:col-span-6 xl:col-start-7">
    <x-site.contact-form :locale="$locale" />
  </x-ui.reveal>
</div>
