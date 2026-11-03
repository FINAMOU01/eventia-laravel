@props(['locale'])
@php
    $content = Content::get($locale);
    $t = [
        'fr' => [
            'title' => 'Candidature',
            'labels' => [
                'name' => 'Nom et prénom',
                'phone' => 'Téléphone',
                'email' => 'E-mail',
                'city' => 'Ville',
                'mission_type' => 'Type de mission recherché',
                'experience' => 'Expériences pertinentes',
                'cv' => 'CV',
            ],
            'cvPlaceholder' => 'Choisir un fichier',
            'cvHint' => 'PDF, DOC ou DOCX, 5 Mo maximum.',
            'submit' => 'Envoyer ma candidature',
            'successTitle' => 'Votre candidature a bien été envoyée.',
            'successText' => 'Merci, l’équipe EVENTIA a bien reçu votre candidature et votre CV.',
        ],
        'en' => [
            'title' => 'Application',
            'labels' => [
                'name' => 'Full name',
                'phone' => 'Phone',
                'email' => 'E-mail',
                'city' => 'City',
                'mission_type' => 'Type of assignment sought',
                'experience' => 'Relevant experience',
                'cv' => 'CV',
            ],
            'cvPlaceholder' => 'Choose a file',
            'cvHint' => 'PDF, DOC or DOCX, 5 MB maximum.',
            'submit' => 'Send my application',
            'successTitle' => 'Your application has been sent.',
            'successText' => 'Thank you, the EVENTIA team has received your application and CV.',
        ],
    ][$locale];
    $l = $t['labels'];
    $missionTypes = $content['recruitment']['missionTypes'];
@endphp
<x-site.ajax-form
  id="candidature"
  form="application"
  :action="route($locale.'.recrutement.submit')"
  :locale="$locale"
  :title="$t['title']"
  :submit="$t['submit']"
  :success-title="$t['successTitle']"
  :success-text="$t['successText']"
  :privacy="$content['privacy']['application']"
  :contact-email="Site::CONTACT['recruitmentEmail']"
  :files="true"
>
  <x-site.form-field form="candidature" name="name" :label="$l['name']" :required="true" autocomplete="name" maxlength="150" />
  <x-site.form-field form="candidature" name="phone" type="tel" :label="$l['phone']" :required="true" autocomplete="tel" inputmode="tel" maxlength="40" />
  <x-site.form-field form="candidature" name="email" type="email" :label="$l['email']" :required="true" autocomplete="email" inputmode="email" maxlength="190" />
  <x-site.form-field form="candidature" name="city" :label="$l['city']" :required="true" autocomplete="address-level2" maxlength="120" />
  @if ($missionTypes)
    <x-site.form-field form="candidature" name="mission_type" type="select" :label="$l['mission_type']" :required="true" :options="array_combine($missionTypes, $missionTypes)" :wide="true" />
  @else
    <x-site.form-field form="candidature" name="mission_type" :label="$l['mission_type']" :required="true" maxlength="200" :wide="true" />
  @endif
  <x-site.form-field form="candidature" name="experience" type="textarea" :label="$l['experience']" :required="true" maxlength="3000" :wide="true" />
  <x-site.form-field form="candidature" name="cv" type="file" :label="$l['cv']" :required="true" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" :placeholder="$t['cvPlaceholder']" :hint="$t['cvHint']" :wide="true" />
</x-site.ajax-form>
