Nouvelle demande de devis reçue sur eventianj.com ({!! strtoupper($quote->locale) !!})

Nom : {!! $quote->name !!}
Organisation : {!! $quote->organisation ?: '—' !!}
Téléphone : {!! $quote->phone !!}
E-mail : {!! $quote->email !!}
Pôle concerné : {!! $pole !!}
Type de prestation : {!! $quote->service_type !!}
Date du projet : {!! $quote->project_date->format('d/m/Y') !!}
Lieu du projet : {!! $quote->location !!}
Budget indicatif : {!! $quote->budget ?: '—' !!}

Description du besoin :
{!! $quote->description !!}

--
Demande n° {!! $quote->id !!}, reçue le {!! $quote->created_at->format('d/m/Y à H:i') !!}.
Répondez directement à cet e-mail pour écrire au demandeur.
