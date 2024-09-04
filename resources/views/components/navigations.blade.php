@props([
	'handle',
	'componentName',
])

<?php
use Illuminate\Support\Facades\Cache;

$navigation = Cache::rememberForever(
	key: "navigations::$handle",
	callback: fn() => RyanChandler\FilamentNavigation\Models\Navigation::fromHandle($handle),
);
?>

<x-dynamic-component :component="$componentName" :navigation="$navigation" />
