@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="products-form">
    <h2 class="product-form__heading">商品一覧</h2>
    <a href="/products/register" class="add__btn btn">+ 商品を追加</a>
</div>

<div class="products-layout">

    <div class="search-form">
        <form action="/products" method="GET">
            <div class="search-input">
                <input type="text" name="keyword" placeholder="商品名で検索">
            </div>
            <div>
                <button class="search-btn">検索</button>
            </div>

            <div class="sort-title">価格順で表示</div>
            <div class="sort-select">
                <select name="sort" onchange="this.form.submit()">
                    <option value="">価格で並び替え</option>
                    <option value="high">高い順に表示</option>
                    <option value="low">低い順で表示</option>
                </select>
            </div>
            @if (!empty($sortText))
                <div class="sort-result">
                    <span>{{ $sortText }}</span>

                    <a href="/products" class="sort-reset">×</a>
                </div>
            @endif
        </form>
    </div>

    <div class="products-container">
    @foreach ($products as $product)
        <div class="product-card">

            <a href="/products/detail/{{ $product->id }}">
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
            </a>
            <div class="product-info">
                <p class="name">{{ $product->name }}</p>
                <p class="price">¥{{ $product->price }}</p>
            </div>
        </div>
    @endforeach
    </div>
</div>

<div class="pagination">
    {{ $products->links() }}
</div>


@endsection