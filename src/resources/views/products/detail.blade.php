@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')

<div class="breadcrumb">
    <a href="/products" class="breadcrumb__link">商品一覧</a>
    <span> ＞ </span>
    <span>{{ $product->name }}</span>
</div>

{{-- ★ form 全体 ★ --}}
<form action="/products/{{ $product->id }}/update" method="POST" enctype="multipart/form-data" class="product-detail-form">
    @csrf
    @method('PUT')

    {{-- ★ 上段：画像 + 入力フォーム 横並び ★ --}}
    <div class="product-detail__top">

        {{-- 左：画像 --}}
        <div class="product-detail__image-box">
            <img src="{{ asset('images/' . $product->image) }}" class="product-detail__image">
            <input type="file" name="image" class="product-detail__file">
            @error('image') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        {{-- 右：商品名／値段／季節 --}}
        <div class="product-detail__info">

            {{-- 商品名 --}}
            <div class="product-detail__block">
                <label class="product-detail__label">商品名</label>
                <input class="product-detail__text" type="text" name="name" value="{{ old('name', $product->name) }}">
                @error('name') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            {{-- 値段 --}}
            <div class="product-detail__block">
                <label class="product-detail__label">値段</label>
                <input class="product-detail__text" type="number" name="price" value="{{ old('price', $product->price) }}">
                @error('price') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            {{-- 季節（複数選択） --}}
            <div class="product-detail__block">
                <label class="product-detail__label">季節</label>
                <div class="season-checkboxes">
                    <label><input type="checkbox" name="season[]" value="1" {{ in_array(1, $selectedSeasons ?? []) ? 'checked' : '' }}> 春</label>
                    <label><input type="checkbox" name="season[]" value="2" {{ in_array(2, $selectedSeasons ?? []) ? 'checked' : '' }}> 夏</label>
                    <label><input type="checkbox" name="season[]" value="3" {{ in_array(3, $selectedSeasons ?? []) ? 'checked' : '' }}> 秋</label>
                    <label><input type="checkbox" name="season[]" value="4" {{ in_array(4, $selectedSeasons ?? []) ? 'checked' : '' }}> 冬</label>
                </div>
                @error('season') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>
    </div> {{-- /product-detail__top --}}

    {{-- ★ 商品説明（横幅いっぱい） ★ --}}
    <div class="product-detail__block full-width">
        <label class="product-detail__label">商品説明</label>
        <textarea class="product-detail__textarea" name="detail" rows="6">{{ old('detail', $product->detail) }}</textarea>
        @error('detail') <p class="error-message">{{ $message }}</p> @enderror
    </div>

    {{-- ★ ボタン（中央寄せ） ★ --}}
    <div class="product-detail__buttons">
        <a href="/products" class="btn btn--back">戻る</a>
        <button type="submit" class="btn btn--update">変更を保存</button>
    </div>

</form>

{{-- ゴミ箱ボタン（右下） --}}
<form action="/products/{{ $product->id }}/delete" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn--delete" onclick="return confirm('削除しますか？')">🗑</button>
</form>

@endsection
