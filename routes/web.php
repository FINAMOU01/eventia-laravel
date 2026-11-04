<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuoteRequestController;
use App\Support\I18n;
use App\Support\Metadata;
use Illuminate\Support\Facades\Route;

// French at the root, English under /en.
foreach (['fr' => '', 'en' => '/en'] as $locale => $prefix) {
    foreach (Metadata::PATHS as $page => $path) {
        $uri = $path === '/' ? ($prefix ?: '/') : $prefix.$path;
        Route::get($uri, PageController::class)
            ->defaults('locale', $locale)
            ->defaults('page', $page)
            ->name("{$locale}.{$page}");
    }

    // Former site structure: permanent redirects keep old links and search results working.
    foreach (Metadata::REDIRECTS as $from => $to) {
        Route::permanentRedirect($prefix.$from, I18n::localizeHref($to, $locale));
    }

    // Form submissions, limited to 5 per hour and per visitor to block abuse.
    Route::post($prefix.'/contact', QuoteRequestController::class)
        ->defaults('locale', $locale)
        ->middleware('throttle:5,60')
        ->name("{$locale}.contact.submit");
    Route::post($prefix.'/recrutement/candidature', ApplicationController::class)
        ->defaults('locale', $locale)
        ->middleware('throttle:5,60')
        ->name("{$locale}.recrutement.submit");
}
