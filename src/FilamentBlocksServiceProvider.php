<?php

namespace MartinRo\FilamentBlocks;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use MartinRo\FilamentBlocks\Commands\MakeBlockCommand;
use MartinRo\FilamentBlocks\Components\FilamentBlock;
use MartinRo\FilamentBlocks\Facades\FilamentBlocks;
use MartinRo\FlowbiteBlocks\FilamentBlocksManager;
use ReflectionClass;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Symfony\Component\Finder\SplFileInfo;

class FilamentBlocksServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-blocks';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews('filament-blocks')
            ->hasCommands([
                MakeBlockCommand::class,
            ]);
    }

    public function packageRegistered(): void
    {
        parent::packageRegistered();

        $this->app->scoped('filament-blocks', function () {
            return new FilamentBlocksManager;
        });
    }

    public function bootingPackage(): void
    {
        $this->registerComponentsFromDirectory(
            FilamentBlock::class,
            [],
            app_path('Forms/Components/Blocks'),
            'App\\Forms\\Components\\Blocks'
        );
    }

    protected function registerComponentsFromDirectory(string $baseClass, array $register, ?string $directory, ?string $namespace): void
    {
        if (blank($directory) || blank($namespace)) {
            return;
        }

        $filesystem = app(Filesystem::class);

        if ((! $filesystem->exists($directory)) && (! Str::of($directory)->contains('*'))) {
            return;
        }

        $namespace = Str::of($namespace);
        ray($namespace);
        array_merge(
            $register,
            collect($filesystem->allFiles($directory))
                ->map(function (SplFileInfo $file) use ($namespace): string {
                    $variableNamespace = $namespace->contains('*') ? str_ireplace(
                        ['\\'.$namespace->before('*'), $namespace->after('*')],
                        ['', ''],
                        Str::of($file->getPath())
                            ->after(base_path())
                            ->replace(['/'], ['\\']),
                    ) : null;

                    return (string) $namespace
                        ->append('\\', $file->getRelativePathname())
                        ->replace('*', $variableNamespace)
                        ->replace(['/', '.php'], ['\\', '']);
                })
                ->filter(fn (string $class): bool => is_subclass_of($class, $baseClass) && (! (new ReflectionClass($class))->isAbstract()))
                ->each(fn (string $class) => FilamentBlocks::register($class, $baseClass))
                ->all(),
        );
    }
}
