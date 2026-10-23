<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/** Renders one of the site pages (port of the app/(fr) and app/(en)/en route segments). */
class PageController extends Controller
{
    public function __invoke(string $locale, string $page): View
    {
        return view("pages.{$page}", ['locale' => $locale, 'page' => $page]);
    }
}
