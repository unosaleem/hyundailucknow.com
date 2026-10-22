<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.cars.index', ['items' => Car::orderBy('sort_order')->latest()->paginate(12)->withQueryString()]);
    }

    public function create()
    {
        return view('admin.cars.form', ['item' => new Car(['category' => 'SUV'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['category'] = $data['category'] ?: 'SUV';
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['image'] = $this->storeImage($request);
        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Car created.');
    }

    public function edit(Car $car)
    {
        return view('admin.cars.form', ['item' => $car]);
    }

    public function update(Request $request, Car $car)
    {
        $data = $this->validated($request, $car);
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $this->deleteImage($car->image);
            $data['image'] = $this->storeImage($request);
        } else {
            unset($data['image']);
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Car updated.');
    }

    public function destroy(Car $car)
    {
        $this->deleteImage($car->image);
        $car->delete();

        return back()->with('success', 'Car deleted.');
    }

    public function toggle(Request $request, Car $car)
    {
        $data = $request->validate(['is_active' => ['required', 'boolean']]);
        $car->update(['is_active' => $data['is_active']]);
        return redirect()->route('admin.cars.index', $request->query())->with('success', 'Car status updated.');
    }

    private function validated(Request $request, ?Car $car = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('cars', 'slug')->ignore($car?->id)],
            'category' => ['nullable', 'string', 'max:50'],
            'engine_details' => ['nullable', 'string', 'max:120'],
            'price' => ['nullable', 'string', 'max:50'],
            'ex_showroom_price' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:99999'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'mimetypes:image/jpeg,image/png,image/webp,image/avif', 'max:5120'],
        ]);
    }

    private function storeImage(Request $request): ?string
    {
        return $request->hasFile('image')
            ? $request->file('image')->store('cars', 'public')
            : null;
    }

    private function deleteImage(?string $image): void
    {
        if ($image && ! Str::startsWith($image, ['http://', 'https://'])) {
            Storage::disk('public')->delete($image);
        }
    }
}
