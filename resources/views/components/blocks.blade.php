@props(["blocks" => null])

@if(is_iterable($blocks))
	@foreach ($blocks as $block)
		<x-dynamic-component
				:component="'blocks.'.$block['type']"
				:attributes="new \Illuminate\View\ComponentAttributeBag($block['data'])"
		/>
	@endforeach
@endif
