<?php

use App\Http\Controllers\PageController;
use App\Support\Metadata;
use Illuminate\Support\Facades\Route;

// Same URLs as the Next.js site: French at the root, English under /en.
foreach (['fr' => '', 'en' => '/en'] as $locale => $prefix) {
    foreach (Metadata::PATHS as $page => $path) {
        $uri = $path === '/' ? ($prefix ?: '/') : $prefix.$path;
        Route::get($uri, PageController::class)
            ->defaults('locale', $locale)
            ->defaults('page', $page)
            ->name("{$locale}.{$page}");
    }
}
