<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('sort_order')->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create', ['product' => new Product()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['tag'] = $data['tag'] ?? '';
        $data['image'] = $this->handleImage($request) ?? 'assets/img/services/card-local.png';

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product->id);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['tag'] = $data['tag'] ?? '';

        if ($newImage = $this->handleImage($request)) {
            $data['image'] = $newImage;
        } else {
            unset($data['image']);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:120|unique:products,slug' . ($ignoreId ? ',' . $ignoreId : ''),
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:40',
            'tag' => 'nullable|string|max:40',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|max:4096',
        ]);
    }

    private function handleImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $path = $request->file('image')->store('products', 'public');

        return 'storage/' . $path;
    }
}
