@extends('layouts.app')

@section('content')
  <x-site.hero :locale="$locale" />
  <x-site.expertise :locale="$locale" />
  <x-site.realisations :locale="$locale" />
  <x-site.equipe :locale="$locale" />
  <x-site.recrutement :locale="$locale" />
  <x-site.contact :locale="$locale" />
@endsection
