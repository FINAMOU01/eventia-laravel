Nouvelle candidature reçue sur eventianj.com ({!! strtoupper($application->locale) !!})

Nom et prénom : {!! $application->name !!}
Téléphone : {!! $application->phone !!}
E-mail : {!! $application->email !!}
Ville : {!! $application->city !!}
Type de mission recherché : {!! $application->mission_type !!}

Expériences pertinentes :
{!! $application->experience !!}

CV : en pièce jointe ({!! $application->cv_original_name !!}).

--
Candidature n° {!! $application->id !!}, reçue le {!! $application->created_at->format('d/m/Y à H:i') !!}.
Répondez directement à cet e-mail pour écrire au candidat.
