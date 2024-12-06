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
        $priceFrom = $request->input('price_from');
        $priceTo = $request->input('price_to');

        $products = Product::when($query, function ($q) use ($query) {
            return $q->where('name', 'LIKE', '%' . $query . '%');
        })->when($categoryId, function ($q) use ($categoryId) {
            return $q->where('category_id', $categoryId);
        })->when($priceFrom, function ($q) use ($priceFrom) {
            return $q->where('price', '>=', $priceFrom);
        })->when($priceTo, function ($q) use ($priceTo) {
            return $q->where('price', '<=', $priceTo);
        })->paginate(12);

        $categories = Category::all();
        return view('welcome', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
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
