<?php

namespace MartinRo\FilamentBlocks\Components;

use Filament\Forms\Components\Builder\Block;

abstract class FilamentBlock
{
    abstract public static function getBlockSchema(): Block;

    public static function getName(): string
    {
        return static::getBlockSchema()->getName();
    }
}
