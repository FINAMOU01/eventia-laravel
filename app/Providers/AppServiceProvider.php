<?php

namespace App\Providers;

use App\Support\Content;
use App\Support\I18n;
use App\Support\Web;
use App\Support\Media;
use App\Support\Metadata;
use App\Support\Site;
use App\Support\Ui;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Short names for the data layer inside Blade views (e.g. Site::text($locale)).
        $loader = AliasLoader::getInstance();
        foreach ([
            'Content' => Content::class,
            'I18n' => I18n::class,
            'Web' => Web::class,
            'Media' => Media::class,
            'Metadata' => Metadata::class,
            'Site' => Site::class,
            'Ui' => Ui::class,
        ] as $alias => $class) {
            $loader->alias($alias, $class);
        }
    }
}
