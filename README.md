# Block-Builder for Filament

Provides a block builder for Filament. Blocks can be setup in the backend and rendered on the front-end.

## Installation
You can install this package via composer:
```bash
composer require martin-ro/filament-blocks
```

## Creating a Block

```bash
php artisan make:filament-block Hero/MyHero
```

This will create the following Block class:

```php
use Filament\Forms\Components\Builder\Block;
use MartinRo\FilamentBlocks\PageBlock;
 
class MyHero extends FilamentBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('hero.my-hero')
            ->label('My Hero')
            ->icon('phosphor-cards-three')
            ->preview('components.blocks.hero.my-hero')
            ->schema([
                //
            ]);
    }
}
```

and its corresponding blade component view:
```html
@props([
    //
])

<div>
    //
</div>

```

## Using Blocks in your template

```html
<x-filament-blocks::page-blocks :blocks="$page->blocks" />
```

## Credits

- [Martin Ro](https://github.com/martin-ro)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
