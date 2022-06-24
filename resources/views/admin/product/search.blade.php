<ul class="list-unstyled">
	@foreach ($products as $product)
		<li>
			<a 	class="product-name"
				href="javascript:void(0)"
				title="{{ $product->name }}"
                data="{{ $product->barcode }}"
			>
				<img src="{{ asset('') }}images/{{ $product->featured_image }}" alt="{{ $product->name }}">
				{{ $product->name }}
			</a>
		</li>
	@endforeach
</ul>
