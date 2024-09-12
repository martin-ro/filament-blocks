<?php

declare(strict_types=1);

namespace MartinRo\FlowbiteBlocks;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use MartinRo\FilamentBlocks\Components\FilamentBlock;
use MartinRo\FilamentPageBlocks\Exceptions\InvalidClassTypeException;

final class FilamentBlocksManager
{
    /** @var Collection<string,string> */
    private Collection $blocks;

    public function __construct()
    {
        /** @var Collection<string,string> $blocks */
        $blocks = collect([]);

        $this->blocks = $blocks;
    }

    public function getBlocks(): array
    {
        return $this->blocks->map(fn ($block) => $block::getBlockSchema())->toArray();
    }

    public function register(string $class, string $baseClass): void
    {
        match ($baseClass) {
            FilamentBlock::class => self::registerBlock($class),
            default => throw new InvalidClassTypeException('Invalid class type'),
        };
    }

    public function registerBlock(string $block): void
    {
        if (! is_subclass_of($block, FilamentBlock::class)) {
            throw new InvalidArgumentException("{$block} must extend ".FilamentBlock::class);
        }

        $this->blocks->put($block::getName(), $block);
    }
}
