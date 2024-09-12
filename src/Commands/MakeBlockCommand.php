<?php

declare(strict_types=1);

namespace MartinRo\FilamentBlocks\Commands;

use Filament\Support\Commands\Concerns\CanIndentStrings;
use Filament\Support\Commands\Concerns\CanManipulateFiles;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\text;

final class MakeBlockCommand extends Command
{
    use CanIndentStrings;
    use CanManipulateFiles;

    protected $signature = 'make:filament-block {name?} {--F|force}';

    protected $description = 'Create a new filament block';

    public function handle(): int
    {
        $block = (string) Str::of($this->argument('name') ?? text(label: 'Name (e.g. `Hero`)', required: true))
            ->trim('/')
            ->trim('\\')
            ->trim(' ')
            ->replace('/', '\\');

        $blockClass = (string) Str::of($block)->afterLast('\\');

        $blockNamespace = Str::of($block)->contains('\\') ?
            (string) Str::of($block)->beforeLast('\\') : '';

        $label = Str::of($block)
            ->beforeLast('Block')
            ->explode('\\')
            ->map(fn ($segment) => Str::title($segment))
            ->implode(': ');

        $shortName = Str::of($block)
            ->beforeLast('Block')
            ->explode('\\')
            ->map(fn ($segment) => Str::kebab($segment))
            ->implode('.');

        $view = Str::of($block)
            ->beforeLast('Block')
            ->prepend('components\\blocks\\')
            ->explode('\\')
            ->map(fn ($segment) => Str::kebab($segment))
            ->implode('.');

        $path = app_path(
            (string) Str::of($block)
                ->prepend('Forms\\Components\\Blocks\\')
                ->replace('\\', '/')
                ->append('.php'),
        );

        $viewPath = resource_path(
            (string) Str::of($view)
                ->replace('.', '/')
                ->prepend('views/')
                ->append('.blade.php'),
        );

        $files = [$path, $viewPath];

        if (! $this->option('force') && $this->checkForCollision($files)) {
            return self::INVALID;
        }

        $this->copyStubToApp('Block', $path, [
            'class' => $blockClass,
            'namespace' => 'App\\Forms\\Components\\Blocks'.($blockNamespace !== '' ? "\\{$blockNamespace}" : ''),
            'label' => $label,
            'shortName' => $shortName,
            'componentPath' => "components.blocks.$shortName",
        ]);

        $this->copyStubToApp('BlockView', $viewPath);

        $this->info("Successfully created {$block}!");

        return self::SUCCESS;
    }
}
