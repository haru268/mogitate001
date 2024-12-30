@extends('layouts.app')

@section('extra-css')
<link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="register-container">
    <h1 class="register-product-title2">商品登録</h1>
    <form id="register-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <label class="register-label">商品名 <span class="required-badge">必須</span></label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力" class="register-form-control">
        @if($errors->has('name'))
            <div class="register-alert-danger">{{ $errors->first('name') }}</div>
        @endif

        <label class="register-label">値段 <span class="required-badge">必須</span></label>
        <input type="number" name="price" value="{{ old('price') }}" placeholder="値段を入力" class="register-form-control">
        @if($errors->has('price'))
            <div class="register-alert-danger">{{ $errors->first('price') }}</div>
        @endif

        <label class="register-label">商品画像 <span class="required-badge">必須</span></label>
        <img id="preview" style="max-width: 300px; height: auto; display: none; margin-bottom: 10px;">
        <div style="display: flex; align-items: center;">
            <input type="file" name="image" onchange="previewImage();" class="register-form-control" style="margin-right: 10px;">
            <span id="file-name"></span>
        </div>
        @if($errors->has('image'))
            <div class="register-alert-danger">{{ $errors->first('image') }}</div>
        @endif

        <label class="register-label">季節 <span class="required-badge">必須</span></label>
        <div class="register-checkbox-group">
            @foreach(['spring' => '春', 'summer' => '夏', 'autumn' => '秋', 'winter' => '冬'] as $seasonKey => $seasonName)
                <label class="register-checkbox-label">
                    <input type="checkbox" name="season[]" value="{{ $seasonKey }}" class="register-checkbox-custom" {{ in_array($seasonKey, old('season', [])) ? 'checked' : '' }}>
                    <span class="register-season-text">{{ $seasonName }}</span>
                </label>
            @endforeach
        </div>
        @if($errors->has('season'))
            <div class="register-alert-danger">{{ $errors->first('season') }}</div>
        @endif

        <label class="register-label">商品説明 <span class="required-badge">必須</span></label>
        <textarea name="description" class="register-form-control register-form-control-textarea" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
        @if($errors->has('description'))
            <div class="register-alert-danger">{{ $errors->first('description') }}</div>
        @endif

        <div class="register-button-container">
            <a href="{{ url('/products') }}" class="register-btn-back">戻る</a>
            <button type="submit" class="register-btn-register">登録</button>
        </div>
    </form>
</div>

<script>
function previewImage() {
    var file = document.querySelector('input[type=file]').files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        var preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.style.display = 'block';
        document.getElementById('file-name').textContent = file.name; // ファイル名を表示
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
        preview.style.display = 'none';
        document.getElementById('file-name').textContent = ''; // ファイルがない場合はテキストをリセット
    }
}
</script>
@endsection
