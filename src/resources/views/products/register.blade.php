@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css')}}">
@endsection

@section('content')
<div class="register-container">
    <h2 class="register-title">商品登録</h2>

    <form action="/products/register" method="post" enctype="multipart/form-data" class="register-form">
        @csrf
        {{-- 商品名 --}}
        <div class="register-form__group">
            <label class="register-label">商品名<span class="required-badge">必須</span></label>
            <input type="text" name="name" class="register-input" placeholder="商品名を入力" value="{{ old('name') }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 値段 --}}
        <div>
            <label class="register-label">値段<span class="required-badge">必須</span></label>
            <input type="number" name="price" class="register-input" placeholder="値段を入力" value="{{ old('price') }}">
            @error('price')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品画像 --}}
        <div>
            <label class="register-label">商品画像<span class="required-badge">必須</span></label>
            <div>
                <input type="file" name="image" class="register-image-input">
            </div>
            @error('image')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 季節 --}}
        <div>
            <label class="register-label">季節<span class="required-badge">必須</span></label>
            <div class="season-checkboxes">
                <label><input type="checkbox" name="season[]" value="1" {{ in_array(1, $selectedSeasons ?? []) ? 'checked' : '' }}> 春</label>
                <label><input type="checkbox" name="season[]" value="2" {{ in_array(2, $selectedSeasons ?? []) ? 'checked' : '' }}> 夏</label>
                <label><input type="checkbox" name="season[]" value="3" {{ in_array(3, $selectedSeasons ?? []) ? 'checked' : '' }}> 秋</label>
                <label><input type="checkbox" name="season[]" value="4" {{ in_array(4, $selectedSeasons ?? []) ? 'checked' : '' }}> 冬</label>
            </div>
            @error('season')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品説明 --}}
        <div>
            <label class="register-label">商品説明<span class="required-badge">必須</span></label>
            <textarea name="detail" class="register-textarea" placeholder="商品の説明を入力" value="{{ old('detail') }}"></textarea>
            @error('detail')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- ボタン --}}
        <div class="register-buttons">
            <a href="/products" class="btn--back">戻る</a>
            <button type="submit" class="btn--submit">登録</button>
        </div>
    </form>
</div>

@endsection