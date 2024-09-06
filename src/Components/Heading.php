<?php

namespace MartinRo\FilamentBlocks\Components;

use Filament\Forms;
use Filament\Forms\Components\Component;
use Guava\FilamentClusters\Forms\Cluster;

class Heading extends Component
{
    public static function make(
        string $name = 'heading',
        string $label = 'Heading',
        string $defaultTag = 'h1',
        bool $required = true,
    ) {
        return Cluster::make()
            ->label($label)
            ->columns(12)
            ->schema([
                Forms\Components\TextInput::make($name)
                    ->columnSpan(['lg' => 10])
                    ->required($required)
                    ->maxLength(255),

                HeadingTagSelect::make(name: $name.'_tag', label: 'Tag', required: $required, default: $defaultTag)
                    ->columnSpan(['lg' => 2]),
            ]);
    }
}
