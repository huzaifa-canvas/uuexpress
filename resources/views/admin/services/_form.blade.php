@csrf
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4">
            <h2 class="h6 fw-bold mb-3">Service details</h2>
            <div class="mb-3">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $service->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="row">
                <div class="col-md-7 mb-3">
                    <label class="form-label">Slug <span class="text-muted small">(blank = auto from name)</span></label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $service->slug) }}">
                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label">Tint</label>
                    <input type="text" name="tint" class="form-control" value="{{ old('tint', $service->tint ?: 'green') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Short description (card) <span class="text-danger">*</span></label>
                <input type="text" name="desc" class="form-control @error('desc') is-invalid @enderror" value="{{ old('desc', $service->desc) }}" required>
                @error('desc') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Intro <span class="text-muted small">(long paragraph on the Services page)</span></label>
                <textarea name="intro" rows="3" class="form-control">{{ old('intro', $service->intro) }}</textarea>
            </div>
            <hr>
            <h2 class="h6 fw-bold mb-3">Detail page</h2>
            <div class="mb-3">
                <label class="form-label">Detail heading</label>
                <input type="text" name="detail_heading" class="form-control" value="{{ old('detail_heading', $service->detail_heading) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Detail body</label>
                <textarea name="detail_body" rows="3" class="form-control">{{ old('detail_body', $service->detail_body) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Feature list <span class="text-muted small">(one per line)</span></label>
                <textarea name="features" rows="4" class="form-control">{{ old('features', implode("\n", $service->features ?? [])) }}</textarea>
            </div>
            <div class="mb-0">
                <label class="form-label">CTA heading</label>
                <input type="text" name="cta_heading" class="form-control" value="{{ old('cta_heading', $service->cta_heading) }}">
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4 mb-3">
            <h2 class="h6 fw-bold mb-3">Image</h2>
            @if($service->image)
                <img src="{{ asset($service->image) }}" alt="" class="img-fluid rounded mb-2" style="max-height:150px;object-fit:cover;width:100%;">
            @endif
            <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Leave empty to keep the current image.</div>
        </div>
        <div class="card p-4 mb-3">
            <h2 class="h6 fw-bold mb-3">Settings</h2>
            <div class="mb-3">
                <label class="form-label">Price (USD)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $service->price ?? 0) }}">
                </div>
                <div class="form-text">Charged at booking. Set 0 for no online payment.</div>
                @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Sort order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order ?? 0) }}">
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="isActive">Active (visible on site)</label>
            </div>
        </div>
        <button type="submit" class="btn btn-brand w-100"><i class="bi bi-check-lg"></i> Save Service</button>
        <a href="{{ route('admin.services.index') }}" class="btn btn-link w-100 text-muted">Cancel</a>
    </div>
</div>
