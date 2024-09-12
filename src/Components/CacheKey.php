<?php

namespace MartinRo\FilamentBlocks\Components;

use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Model;

final class CacheKey extends Hidden
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(true);

        $this->beforeStateDehydrated(function (Forms\Components\Component $component, Forms\Set $set, ?Model $record) {
            $key = sprintf(
                '%s:%s:%s',
                $record->getTable(),
                $record->id,
                $component->getContainer()->getStatePath(),
            );

            $set('cacheKey', $key);
        });
    }

    public static function make(string $name = 'cacheKey'): static
    {
        return parent::make($name);
    }
}
