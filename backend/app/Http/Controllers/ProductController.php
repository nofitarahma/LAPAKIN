<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('productName', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'Semua Kategori') {
            $query->where('category', $request->category);
        }

        $sort = $request->get('sort');
        $query = match ($sort) {
            'Harga Terendah'   => $query->orderBy('price', 'asc'),
            'Harga Tertinggi'  => $query->orderBy('price', 'desc'),
            'Rating Tertinggi' => $query->orderBy('rating', 'desc'),
            default            => $query->latest(),
        };

        $products = $query->paginate(15);

        return response()->json($products);
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
}
