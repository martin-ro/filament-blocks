<?php

namespace MartinRo\FilamentBlocks\Facades;

use Illuminate\Support\Facades\Facade;

final class FilamentBlocks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'filament-blocks';
    }
}
