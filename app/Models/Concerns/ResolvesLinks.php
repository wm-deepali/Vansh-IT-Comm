<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Route;

/**
 * Lets a model store a link as either a named route (*_route) or a raw URL (*_url).
 *
 *  - linkValue('btn_primary') => what the admin sees/edits (route name or URL)
 *  - linkFor('btn_primary')   => the final href to print in Blade
 */
trait ResolvesLinks
{
    public function linkValue(string $prefix): ?string
    {
        return $this->{$prefix . '_route'} ?: $this->{$prefix . '_url'};
    }

    public function linkFor(string $prefix): string
    {
        $route = $this->{$prefix . '_route'};

        if ($route && Route::has($route)) {
            return route($route);
        }

        return $this->{$prefix . '_url'} ?: '#';
    }
}