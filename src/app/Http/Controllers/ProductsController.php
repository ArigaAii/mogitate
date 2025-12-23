<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $sort = $request->input('sort');

        $query = Product::query();

        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $sortText = null;
        if ($sort === 'high') {
            $query->orderBy('price', 'desc');
            $sortText = "高い順に表示";
        } elseif ($sort === 'low') {
            $query->orderBy('price', 'asc');
            $sortText = "低い順で表示";
        } else {
            $sortText = '';
        }
        
        $products = $query->Paginate(6)->appends($request->query());
        return view('products.index', compact('products', 'keyword', 'sort', 'sortText'));
    }

    public function create()
    {
        return view('products.register');
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        
        // public/images に画像保存 → ファイル名だけ取得
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
        }

        $seasonArray = $request->input('season');
        $seasonString = implode(',', $seasonArray);

        //DBへ保存
        Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'image'       => $imageName, // ファイル名だけ DB に保存
            'season'      => $seasonString,
            'description' => $validated['detail'],
        ]);

        return redirect('/products');
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);
        $selectedSeasons = explode(',', $product->season);

        return view('products.detail', compact('product', 'selectedSeasons'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $image =$request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $fileName);
            //既存画像を上書き
            $product->image = $fileName;
        }

        $seasonArray = $request->input('season', []);
        $seasonString = implode(',', $seasonArray);

        //画像以外の更新
        $product->name   = $validated['name'];
        $product->price  = $validated['price'];
        $product->season = $seasonString;
        $product->detail = $validated['detail'];
        $product->save();

        return redirect('/products')->with('success', '商品情報を更新しました');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect('/products')->with('success', '商品を削除しました');
    }

}
