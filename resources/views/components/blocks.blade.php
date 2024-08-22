@php use Illuminate\Support\Facades\File; @endphp
@props([
	'blocks' => null,
	'provider' => null,
])

@if(is_array($blocks) && $provider)
	@foreach ($blocks as $block)
		@include($provider.'::components.' . $block['type'], [...$block['data']])
	@endforeach
@endif
