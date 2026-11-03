@props(['locale'])
@php
    $content = Content::get($locale);
    $t = [
        'fr' => [
            'title' => 'Demande de devis',
            'labels' => [
                'name' => 'Nom',
                'organisation' => 'Organisation',
                'phone' => 'Téléphone',
                'email' => 'E-mail',
                'pole' => 'Pôle concerné',
                'service_type' => 'Type de prestation',
                'project_date' => 'Date du projet',
                'location' => 'Lieu du projet',
                'budget' => 'Budget indicatif',
                'description' => 'Description courte du besoin',
            ],
            'optional' => 'Facultatif',
            'submit' => 'Envoyer ma demande',
            'successTitle' => 'Votre demande a bien été envoyée.',
            'successText' => 'Merci, l’équipe EVENTIA a bien reçu votre demande de devis.',
        ],
        'en' => [
            'title' => 'Quote request',
            'labels' => [
                'name' => 'Name',
                'organisation' => 'Organisation',
                'phone' => 'Phone',
                'email' => 'E-mail',
                'pole' => 'Division concerned',
                'service_type' => 'Type of service',
                'project_date' => 'Project date',
                'location' => 'Project location',
                'budget' => 'Indicative budget',
                'description' => 'Short description of your needs',
            ],
            'optional' => 'Optional',
            'submit' => 'Send my request',
            'successTitle' => 'Your request has been sent.',
            'successText' => 'Thank you, the EVENTIA team has received your quote request.',
        ],
    ][$locale];
    $l = $t['labels'];
    $poles = collect($content['poles'])->mapWithKeys(fn ($pole) => [$pole['id'] => $pole['name']])->all();
    // Division pre-selected when arriving from a division page (?pole=hotesses).
    $selectedPole = array_key_exists(request('pole'), $poles) ? request('pole') : null;
    $serviceTypes = $content['contact']['serviceTypes'];
@endphp
<x-site.ajax-form
  id="demande-devis"
  form="quote"
  :action="route($locale.'.contact.submit')"
  :locale="$locale"
  :title="$t['title']"
  :submit="$t['submit']"
  :success-title="$t['successTitle']"
  :success-text="$t['successText']"
  :privacy="$content['privacy']['quote']"
  :contact-email="Site::CONTACT['email']"
>
  <x-site.form-field form="devis" name="name" :label="$l['name']" :required="true" autocomplete="name" maxlength="150" />
  <x-site.form-field form="devis" name="organisation" :label="$l['organisation']" autocomplete="organization" maxlength="150" />
  <x-site.form-field form="devis" name="phone" type="tel" :label="$l['phone']" :required="true" autocomplete="tel" inputmode="tel" maxlength="40" />
  <x-site.form-field form="devis" name="email" type="email" :label="$l['email']" :required="true" autocomplete="email" inputmode="email" maxlength="190" />
  <x-site.form-field form="devis" name="pole" type="select" :label="$l['pole']" :required="true" :options="$poles" :value="$selectedPole" />
  @if ($serviceTypes)
    <x-site.form-field form="devis" name="service_type" type="select" :label="$l['service_type']" :required="true" :options="array_combine($serviceTypes, $serviceTypes)" />
  @else
    <x-site.form-field form="devis" name="service_type" :label="$l['service_type']" :required="true" maxlength="200" />
  @endif
  <x-site.form-field form="devis" name="project_date" type="date" :label="$l['project_date']" :required="true" />
  <x-site.form-field form="devis" name="location" :label="$l['location']" :required="true" maxlength="200" />
  <x-site.form-field form="devis" name="budget" :label="$l['budget']" :hint="$t['optional']" maxlength="100" :wide="true" />
  <x-site.form-field form="devis" name="description" type="textarea" :label="$l['description']" :required="true" maxlength="3000" :wide="true" />
</x-site.ajax-form>
