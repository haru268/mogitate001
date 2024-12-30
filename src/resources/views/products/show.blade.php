@extends('layouts.app')

@section('head')
<link href="{{ asset('css/product_details.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container7">
    <h2 class="product-header7"><span class="product-list-title">商品一覧</span> > {{ $product->name }}</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- エラーメッセージ表示エリア -->
        @if ($errors->update->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->update->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="product-body7">
            <!-- 画像表示 -->
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="product-image7">

            <div class="product-form7">
                <!-- 商品名 -->
                <label for="product-name7" id="product-name7-label">商品名</label>
                <input type="text" id="product-name7" name="name" value="{{ old('name', $product->name) }}" class="product-name7" required>
                @if ($errors->has('name'))
                    <p style="color: red; margin-top: 2px;">{{ $errors->first('name') }}</p>
                @endif

                <!-- 値段 -->
                <label for="product-price7" id="product-price7-label">値段</label>
                <input type="number" id="product-price7" name="price" value="{{ old('price', $product->price) }}" class="product-price7" required>
                @if ($errors->has('price'))
                    <p style="color: red; margin-top: 2px;">{{ $errors->first('price') }}</p>
                @endif

                <!-- 季節 -->
                <label class="label-season7">季節</label>
                <div class="checkbox-group7">
                    @foreach(['spring' => '春', 'summer' => '夏', 'autumn' => '秋', 'winter' => '冬'] as $seasonKey => $seasonName)
                        <label class="checkbox-label7">
                            <input type="checkbox" name="season[]" value="{{ $seasonKey }}" {{ $product->seasons->pluck('name')->contains($seasonKey) ? 'checked' : '' }}>
                            <span class="season-text7">{{ $seasonName }}</span>
                        </label>
                    @endforeach
                </div>
                @if ($errors->has('season'))
                    <p style="color: red; margin-top: 2px;">{{ $errors->first('season') }}</p>
                @endif

                <!-- ファイル選択 -->
                <label for="product-image">商品画像</label>
                <div style="display: flex; align-items: center;">
                    <input type="file" id="product-image" name="image" class="product-file-input7" onchange="updateFileName();" style="margin-right: 10px;">
                    <span id="file-name">{{ basename($product->image) }}</span>
                </div>
                @if ($errors->has('image'))
                    <p style="color: red; margin-top: 2px;">{{ $errors->first('image') }}</p>
                @endif

                <!-- 商品説明 -->
                <label for="product-description7">商品説明</label>
                <textarea id="product-description7" name="description" class="product-description7">{{ old('description', $product->description) }}</textarea>
                @if ($errors->has('description'))
                    <p style="color: red; margin-top: 2px;">{{ $errors->first('description') }}</p>
                @endif

                <!-- ボタン群 -->
                <div class="actions7" style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ url('/products') }}" class="btn btn-primary7">戻る</a>
                    <button type="submit" class="btn btn-secondary7">変更を保存</button>
                </div>
            </div>
        </div>
    </form>
    <!-- 削除ボタン用のフォーム -->
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger7">
            <img src="{{ asset('images/赤いゴミ箱.png') }}" alt="ゴミ箱アイコン" class="delete-icon">
        </button>
   
