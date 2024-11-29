<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $categoryId = $request->input('category');

        $products = Product::when($query, function ($q) use ($query) {
            return $q->where('name', 'LIKE', '%' . $query . '%');
        })->when($categoryId, function ($q) use ($categoryId) {
            return $q->where('category_id', $categoryId);
        })->paginate(12);

        $categories = Category::all();
        return view('welcome', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Обновление товара
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url',
        ]);

        $product->update($request->only(['name', 'description', 'price', 'category_id', 'image']));

        return redirect()->route('products.index')->with('success', 'Товар успешно обновлен');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Товар успешно создан');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', '%$query%')
            ->orWhere('description', 'LIKE', '%$query%')
            ->get();
        return view('products.search', compact('products', 'query'));
    }
}
