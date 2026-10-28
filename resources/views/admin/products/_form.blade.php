@csrf
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4">
            <h2 class="h6 fw-bold mb-3">Product details</h2>
            <div class="mb-3">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', html_entity_decode($product->name ?? '')) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Slug <span class="text-muted small">(blank = auto)</span></label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $product->slug) }}">
                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-0">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4 mb-3">
            <h2 class="h6 fw-bold mb-3">Image</h2>
            @if($product->image)
                <img src="{{ asset($product->image) }}" alt="" class="img-fluid rounded mb-2" style="max-height:150px;object-fit:cover;width:100%;">
            @endif
            <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Leave empty to keep the current image.</div>
        </div>
        <div class="card p-4 mb-3">
            <h2 class="h6 fw-bold mb-3">Pricing &amp; settings</h2>
            <div class="mb-3">
                <label class="form-label">Price (USD) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price ?? 0) }}" required>
                </div>
                @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Unit <span class="text-muted small">(e.g. "pack of 25")</span></label>
                <input type="text" name="unit" class="form-control" value="{{ old('unit', $product->unit) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tag <span class="text-muted small">(e.g. "Best seller")</span></label>
                <input type="text" name="tag" class="form-control" value="{{ old('tag', $product->tag) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Sort order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $product->sort_order ?? 0) }}">
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="isActive">Active (visible in shop)</label>
            </div>
        </div>
        <button type="submit" class="btn btn-brand w-100"><i class="bi bi-check-lg"></i> Save Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-link w-100 text-muted">Cancel</a>
    </div>
</div>
