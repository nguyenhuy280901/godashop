<ul class="list-unstyled">
    @foreach ($products as $product)
		<li>
			<a 	class="product-name"
				style="display: flex; align-items: center; color: #000; font-weight: 550"
				href="{{ route('product.show', [
                    "product" => $product->id
                ]) }}" 
				title="{{ $product->name }}"
			>
				<img style="width: 50px; margin-right: 15px" src="{{ asset('') }}images/{{ $product->featured_image }}" alt="{{ $product->name }}">
				{{ $product->name }}
			</a>
		</li>
    @endforeach
</ul>