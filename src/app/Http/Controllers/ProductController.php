<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // 商品一覧表示
public function index(Request $request)
{
    $query = Product::query();

    // 検索機能
    if ($search = $request->search) {
        $query->where('name', 'LIKE', '%' . $search . '%');
    }

    // 並び替え機能
    $sort = $request->input('sort');
    switch ($sort) {
        case 'price_desc':
            $query->orderBy('price', 'desc');
            break;
        case 'price_asc':
            $query->orderBy('price', 'asc');
            break;
        default:
            $query->orderBy('id'); // デフォルトの並び順
            break;
    }

    $products = $query->paginate(6);

    // 並び替え条件をビューに渡す
    return view('products.index', compact('products', 'search', 'sort'));
}


    // 商品作成フォームの表示
    public function create()
    {
        $allSeasons = Season::all(); // 季節データを取得
        return view('products.create', compact('allSeasons'));
    }

    // 商品登録処理
public function store(StoreProductRequest $request)
{
    // フォーム送信後の二重登録防止
    if ($request->session()->has('processing')) {
        return redirect()->route('products.index')->with('error', 'すでに登録処理が進行中です。');
    }
    $request->session()->put('processing', true);

    try {
        $validated = $request->validated();

        // 商品の保存処理
        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $request->file('image')->store('images', 'public'),
        ]);

        // 季節データの関連付け
        if (!empty($validated['season'])) {
            $seasonIds = Season::whereIn('name', $validated['season'])
                ->pluck('id')
                ->toArray();
            $product->seasons()->sync($seasonIds);
        }

        $request->session()->forget('processing'); // セッションフラグを削除
        return redirect()->route('products.index')->with('success', '商品が登録されました。');
    } catch (\Exception $e) {
        $request->session()->forget('processing'); // セッションフラグを削除
        return redirect()->back()->withErrors('登録処理に失敗しました。')->withInput();
    }
}


    // 商品詳細表示
    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id);
        $allSeasons = Season::all();

        return view('products.show', compact('product', 'allSeasons'));
    }

    // 商品更新処理
    public function update(UpdateProductRequest $request, $id)
{
    DB::beginTransaction();
    try {
        $product = Product::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            Storage::disk('public')->delete($product->image);
            $path = $request->file('image')->store('images', 'public');
            $product->update(['image' => $path]);
        }

        $product->update($validated);

        if (!empty($validated['season'])) {
            $seasonIds = Season::whereIn('name', $validated['season'])->pluck('id')->toArray();
            $product->seasons()->sync($seasonIds);
        } else {
            $product->seasons()->detach();
        }

        DB::commit();
        return redirect()->route('products.show', $id)->with('success', '商品情報が更新されました。');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors('更新処理に失敗しました。')->withInput();
    }
}


    public function edit($id)
{
    $product = Product::findOrFail($id);
    return view('products.edit', compact('product'));
}


    // 商品削除処理
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品が削除されました。');
    }
}
