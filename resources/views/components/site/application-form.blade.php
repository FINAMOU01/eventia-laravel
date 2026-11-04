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
            ],
            'filePlaceholder' => 'Choisir un fichier',
            'documentHint' => 'PDF, DOC ou DOCX, 5 Mo maximum.',
            'photoHint' => 'JPG, PNG, WEBP ou HEIC, 5 Mo maximum.',
            'invalid' => [
                'cv' => 'Votre CV doit être un fichier PDF, DOC ou DOCX.',
                'cover_letter' => 'Votre lettre de motivation doit être un fichier PDF, DOC ou DOCX.',
                'photo' => 'La photo doit être une image JPG, PNG, WEBP ou HEIC.',
            ],
            'submit' => 'Envoyer ma candidature',
            'successTitle' => 'Votre candidature a bien été envoyée.',
            'successText' => 'Merci, l’équipe EVENTIA a bien reçu votre candidature et vos documents.',
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
            ],
            'filePlaceholder' => 'Choose a file',
            'documentHint' => 'PDF, DOC or DOCX, 5 MB maximum.',
            'photoHint' => 'JPG, PNG, WEBP or HEIC, 5 MB maximum.',
            'invalid' => [
                'cv' => 'Your CV must be a PDF, DOC or DOCX file.',
                'cover_letter' => 'Your cover letter must be a PDF, DOC or DOCX file.',
                'photo' => 'The photo must be a JPG, PNG, WEBP or HEIC image.',
            ],
            'submit' => 'Send my application',
            'successTitle' => 'Your application has been sent.',
            'successText' => 'Thank you, the EVENTIA team has received your application and documents.',
        ],
    ][$locale];
    $l = $t['labels'];
    // Labels of the four documents: the exact wording of the "Documents demandés" list.
    $documents = $content['recruitment']['documents'];
    $missionTypes = $content['recruitment']['missionTypes'];
    $documentAccept = '.pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    $photoAccept = '.jpg,.jpeg,.png,.webp,.heic,.heif,image/jpeg,image/png,image/webp,image/heic,image/heif';
    $documentExtensions = App\Http\Controllers\ApplicationController::DOCUMENT_TYPES;
    $photoExtensions = App\Http\Controllers\ApplicationController::PHOTO_TYPES;
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
  :contact-email="Site::CONTACT['email']"
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

  {{-- The four documents requested on the page, in the same order. --}}
  <x-site.form-field form="candidature" name="cv" type="file" :label="$documents[0]" :required="true" :accept="$documentAccept" :extensions="$documentExtensions" :invalid-message="$t['invalid']['cv']" :placeholder="$t['filePlaceholder']" :hint="$t['documentHint']" />
  <x-site.form-field form="candidature" name="cover_letter" type="file" :label="$documents[1]" :required="true" :accept="$documentAccept" :extensions="$documentExtensions" :invalid-message="$t['invalid']['cover_letter']" :placeholder="$t['filePlaceholder']" :hint="$t['documentHint']" />
  <x-site.form-field form="candidature" name="photo_portrait" type="file" :label="$documents[2]" :required="true" :accept="$photoAccept" :extensions="$photoExtensions" :invalid-message="$t['invalid']['photo']" :placeholder="$t['filePlaceholder']" :hint="$t['photoHint']" />
  <x-site.form-field form="candidature" name="photo_full" type="file" :label="$documents[3]" :required="true" :accept="$photoAccept" :extensions="$photoExtensions" :invalid-message="$t['invalid']['photo']" :placeholder="$t['filePlaceholder']" :hint="$t['photoHint']" />
</x-site.ajax-form>
