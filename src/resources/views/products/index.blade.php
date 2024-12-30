@extends('layouts.app')

@section('head')
<link href="{{ asset('css/products.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <!-- 商品一覧タイトルと追加ボタンが含まれるヘッダーコンテナ -->
<div class="header-container" style="position: relative;">
    <div class="product-title-container">
        <h1 class="product-title">商品一覧</h1>
    </div>
    <div class="add-product-container">
        <a href="{{ url('/products/register') }}" class="add-product-button">+ 商品を追加</a>
    </div>
</div>

    <div class="columns">
        <div class="column column-1">
            <form action="{{ url('/products') }}" method="GET" class="search-form">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="商品名で検索" class="form-control">
                <button type="submit" class="search-button">検索</button>
                <p class="price-order">価格順で表示</p>
                <select name="sort" class="sort-order" onchange="this.form.submit()">
                    <option value="">並び替え</option>
                    <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>高い順に表示</option>
                    <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>低い順に表示</option>
                </select>
            </form>
        </div>
        <div class="column column-2">
            @foreach ($products->slice(0, 2) as $product)
                @include('partials.product_card', ['product' => $product])
            @endforeach
        </div>
        <div class="column column-3">
            @foreach ($products->slice(2, 2) as $product)
                @include('partials.product_card', ['product' => $product])
            @endforeach
        </div>
        <div class="column column-4">
            @foreach ($products->slice(4, 2) as $product)
                @include('partials.product_card', ['product' => $product])
            @endforeach
        </div>
    </div>
    <div class="pagination-container">
        {{ $products->appends(['search' => request('search'), 'sort' => request('sort')])->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
