<?php

namespace MartinRo\FilamentBlocks\Facades;

use Illuminate\Support\Facades\Facade;

class FilamentBlocks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'filament-blocks';
    }
}
