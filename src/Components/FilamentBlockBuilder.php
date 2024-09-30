<?php

namespace MartinRo\FilamentBlocks\Components;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Builder;
use MartinRo\FilamentBlocks\Facades\FilamentBlocks;

final class FilamentBlockBuilder extends Builder
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->hiddenLabel();

        $this->addActionLabel('Add Block');

        $this->addBetweenActionLabel('Add Block');

        $this->blockPreviews();

        $this->collapsible();

        $this->cloneable();

        $this->blockPickerColumns(3);

        $this->deleteAction(
            fn (Action $action) => $action->requiresConfirmation(),
        );

        $this->editAction(
            fn (Action $action) => $action->modalSubmitActionLabel('Update'),
        );

        $this->schema(FilamentBlocks::getBlocks());
    }

    public static function make(string $name = 'blocks'): static
    {
        return parent::make($name);
    }
}
