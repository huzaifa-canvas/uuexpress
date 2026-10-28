@extends('admin.layouts.app')
@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">Manage the products shown in the shop.</p>
    <a href="{{ route('admin.products.create') }}" class="btn btn-brand btn-sm"><i class="bi bi-plus-lg"></i> Add Product</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small">
                <tr><th style="width:64px;"></th><th>Name</th><th>Price</th><th>Unit</th><th>Tag</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td><img src="{{ asset($product->image) }}" alt="" style="width:46px;height:46px;object-fit:cover;border-radius:8px;"></td>
                    <td class="fw-semibold">{{ html_entity_decode($product->name) }}<div class="small text-muted">{{ $product->slug }}</div></td>
                    <td class="fw-semibold">${{ number_format((float) $product->price, 2) }}</td>
                    <td class="small text-muted">{{ $product->unit }}</td>
                    <td>@if($product->tag)<span class="badge bg-light text-dark border">{{ $product->tag }}</span>@endif</td>
                    <td>
                        @if($product->is_active)
                            <span class="badge bg-success-subtle text-success">Active</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Hidden</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('shop') }}" target="_blank" class="btn btn-sm btn-light" title="View shop"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Delete this product?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No products yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $products->links() }}</div>
@endsection
