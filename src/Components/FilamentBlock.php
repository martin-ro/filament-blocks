<?php

declare(strict_types=1);

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
