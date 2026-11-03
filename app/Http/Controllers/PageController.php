<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/** Renders one of the site pages; the three division pages share the same template. */
class PageController extends Controller
{
    private const POLE_PAGES = ['image', 'hotesses', 'events'];

    public function __invoke(string $locale, string $page): View
    {
        $view = in_array($page, self::POLE_PAGES, true) ? 'pages.pole' : "pages.{$page}";

        return view($view, ['locale' => $locale, 'page' => $page]);
    }
}
