<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create', ['service' => new Service()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['features'] = $this->parseFeatures($request->input('features'));
        $data['is_active'] = $request->boolean('is_active');
        $data['price'] = $data['price'] ?? 0;
        $data['image'] = $this->handleImage($request) ?? 'assets/img/services/card-local.png';

        Service::create($data);

        return redirect()->route('admin.services.index')->with('status', 'Service created.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validateData($request, $service->id);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['features'] = $this->parseFeatures($request->input('features'));
        $data['is_active'] = $request->boolean('is_active');
        $data['price'] = $data['price'] ?? 0;

        if ($newImage = $this->handleImage($request)) {
            $data['image'] = $newImage;
        } else {
            unset($data['image']);
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Service deleted.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:120|unique:services,slug' . ($ignoreId ? ',' . $ignoreId : ''),
            'desc' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'tint' => 'nullable|string|max:16',
            'intro' => 'nullable|string',
            'detail_heading' => 'nullable|string|max:255',
            'detail_body' => 'nullable|string',
            'cta_heading' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|max:4096',
        ]);
    }

    private function parseFeatures(?string $raw): array
    {
        if (! $raw) {
            return [];
        }

        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw))));
    }

    /** Store an uploaded image and return its public web path, or null. */
    private function handleImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $path = $request->file('image')->store('services', 'public');

        return 'storage/' . $path;
    }
}
