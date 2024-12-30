<a href="{{ route('products.show', $product->id) }}" class="card product-card">
    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-price">￥{{ number_format($product->price) }}</p>
    </div>
</a>
