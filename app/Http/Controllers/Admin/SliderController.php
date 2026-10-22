<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\CarbonImmutable;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $today = CarbonImmutable::now(config('app.timezone'))->toDateString();
        $query = Slider::orderBy('sort_order')->latest();

        if ($status === 'inactive') {
            $query->where('is_active', false);
        } elseif ($status === 'upcoming') {
            $query->where('is_active', true)->whereDate('starts_at', '>', $today);
        } elseif ($status === 'expired') {
            $query->where('is_active', true)->whereDate('ends_at', '<', $today);
        } elseif ($status === 'active') {
            $query->where('is_active', true)
                ->where(function ($q) use ($today) {
                    $q->whereNull('starts_at')->orWhereDate('starts_at', '<=', $today);
                })
                ->where(function ($q) use ($today) {
                    $q->whereNull('ends_at')->orWhereDate('ends_at', '>=', $today);
                });
        }

        return view('admin.sliders.index', [
            'items' => $query->paginate(12)->withQueryString(),
            'status' => $status,
        ]);
    }

    public function create()
    {
        return view('admin.sliders.form', ['item' => new Slider]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, false);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
            $this->syncToRootStorage($data['image']);
        }

        if ($request->hasFile('mobile_image')) {
            $data['mobile_image'] = $request->file('mobile_image')->store('sliders', 'public');
            $this->syncToRootStorage($data['mobile_image']);
        }

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', ['item' => $slider]);
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $this->validated($request, true);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                $this->deleteFromBothStorages($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
            $this->syncToRootStorage($data['image']);
        } else {
            unset($data['image']);
        }

        if ($request->hasFile('mobile_image')) {
            if ($slider->mobile_image) {
                $this->deleteFromBothStorages($slider->mobile_image);
            }
            $data['mobile_image'] = $request->file('mobile_image')->store('sliders', 'public');
            $this->syncToRootStorage($data['mobile_image']);
        } else {
            unset($data['mobile_image']);
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            $this->deleteFromBothStorages($slider->image);
        }
        if ($slider->mobile_image) {
            $this->deleteFromBothStorages($slider->mobile_image);
        }

        $slider->delete();

        return back()->with('success', 'Slider deleted successfully.');
    }

    public function toggle(Request $request, Slider $slider)
    {
        $data = $request->validate(['is_active' => ['required', 'boolean']]);
        $slider->update(['is_active' => $data['is_active']]);

        return redirect()->route('admin.sliders.index', $request->query())->with('success', 'Slider status updated.');
    }

    private function syncToRootStorage(string $path): void
    {
        $source = storage_path('app/public/' . $path);
        $target = base_path('storage/' . $path);
        if (file_exists($source)) {
            @mkdir(dirname($target), 0777, true);
            @copy($source, $target);
        }
    }

    private function deleteFromBothStorages(string $path): void
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }
        Storage::disk('public')->delete($path);
        $target = base_path('storage/' . $path);
        if (file_exists($target)) {
            @unlink($target);
        }
    }

    private function validated(Request $request, bool $isUpdate): array
    {
        return $request->validate([
            'title' => ['nullable', 'string', 'max:150'],
            'badge' => ['nullable', 'string', 'max:50'],
            'link' => ['nullable', 'string', 'max:255'],
            'image' => [$isUpdate ? 'nullable' : 'required', 'file', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'mimetypes:image/jpeg,image/png,image/webp,image/avif', 'max:5120'],
            'mobile_image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'mimetypes:image/jpeg,image/png,image/webp,image/avif', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
