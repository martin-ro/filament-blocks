<?php

declare(strict_types=1);

namespace MartinRo\FilamentBlocks\Facades;

use Illuminate\Support\Facades\Facade;

final class FilamentBlocks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'filament-blocks';
    }
}
