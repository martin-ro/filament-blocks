@props(["tag" => "h1", "class" => null])

@php
	$headingClasses = \Illuminate\Support\Arr::toCssClasses([
        "text-gray-800 dark:text-white",
		match ($tag) {
			"h1" => "text-4xl md:text-5xl font-extrabold",
			"h2" => "text-3xl md:text-4xl font-bold",
			"h3" => "text-2xl lg:text-3xl font-bold",
			"h4" => "text-xl lg:text-2xl font-bold",
			"h5" => "text-lg lg:text-xl font-bold",
			"h6" => "text-base lg:text-lg font-bold",
			default => "",
		},
	]);
@endphp

<{{ $tag }} {{ $attributes->class([ $class ?? $headingClasses ]) }}>{{ $slot }}</{{ $tag }}>
