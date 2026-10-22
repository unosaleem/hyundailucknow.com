@extends('layouts.admin')
@section('title', ($item->exists ? 'Edit ' : 'Add ') . 'Slider Banner')
@section('page_heading', ($item->exists ? 'Edit ' : 'Add ') . 'Slider Banner')
@section('content')
<div class="mb-6">
    <a class="text-sm font-bold text-cyan-600 hover:text-cyan-800" href="{{ route('admin.sliders.index') }}">← Back to Hero Sliders</a>
    <h2 class="mt-3 text-3xl font-black">{{ $item->exists ? 'Edit' : 'Add' }} Slider Banner</h2>
</div>

<form class="max-w-3xl space-y-6 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-8"
      method="POST"
      enctype="multipart/form-data"
      action="{{ $item->exists ? route('admin.sliders.update', $item) : route('admin.sliders.store') }}">
    @csrf
    @if($item->exists) @method('PUT') @endif

    <div class="grid gap-5 sm:grid-cols-2">
        <label class="text-sm font-bold sm:col-span-2">
            Banner Title
            <input class="admin-input" name="title" value="{{ old('title', $item->title) }}" placeholder="e.g. Hyundai Bayon - Find Your Drive">
        </label>

        <label class="text-sm font-bold">
            Badge
            <input class="admin-input" name="badge" value="{{ old('badge', $item->badge) }}" placeholder="e.g. Special Edition, New Launch">
        </label>

        <label class="text-sm font-bold">
            Display Order
            <input class="admin-input" type="number" min="0" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
            <span class="mt-1 block text-xs font-normal text-slate-500">Lower numbers appear first (0, 1, 2...).</span>
        </label>

        <label class="text-sm font-bold sm:col-span-2">
            Click Action / Link
            <input class="admin-input" name="link" value="{{ old('link', $item->link) }}" placeholder="e.g. #models, #offers, or custom URL">
            <span class="mt-1 block text-xs font-normal text-slate-500">Leave blank if the banner is not clickable, or enter a section hash (e.g. #models).</span>
        </label>

        <div class="sm:col-span-2">
            <label class="text-sm font-bold">
                Desktop Banner Image
                @if(!$item->exists)
                    <span class="required-marker" aria-hidden="true">*</span><span class="sr-only">(required)</span>
                @endif
                <span class="font-normal text-slate-500">(Recommended ratio ~16:9 or ~21:9, max 5 MB)</span>
                <input id="slider-image" class="admin-input" type="file" name="image" accept="image/jpeg,image/png,image/webp,image/avif" {{ $item->exists ? '' : 'required' }}>
            </label>
            <div class="mt-3 flex items-center gap-4">
                <img id="slider-preview" class="h-28 w-56 rounded-xl border border-slate-200 object-cover shadow-sm {{ $item->image_url ? '' : 'hidden' }}" src="{{ $item->image_url ?? '' }}" alt="Desktop banner preview">
                <span id="slider-placeholder" class="text-sm text-slate-400 {{ $item->image_url ? 'hidden' : '' }}">Choose a desktop banner image to preview here.</span>
            </div>
        </div>

        <div class="sm:col-span-2">
            <label class="text-sm font-bold">
                Mobile Banner Image
                <span class="font-normal text-slate-500">(Optional: tailored for mobile screens e.g. ~3:4 or vertical, max 5 MB)</span>
                <input id="slider-mobile-image" class="admin-input" type="file" name="mobile_image" accept="image/jpeg,image/png,image/webp,image/avif">
            </label>
            <div class="mt-3 flex items-center gap-4">
                <img id="mobile-preview" class="h-28 w-20 rounded-xl border border-slate-200 object-cover shadow-sm {{ $item->mobile_image ? '' : 'hidden' }}" src="{{ $item->mobile_image ? $item->mobile_image_url : '' }}" alt="Mobile banner preview">
                <span id="mobile-placeholder" class="text-sm text-slate-400 {{ $item->mobile_image ? 'hidden' : '' }}">If not provided, desktop image will be used on mobile.</span>
            </div>
        </div>

        <label class="text-sm font-bold">
            Starts At
            <input class="admin-input" type="date" name="starts_at" value="{{ old('starts_at', optional($item->starts_at)->format('Y-m-d')) }}">
            <span class="mt-1 block text-xs font-normal text-slate-500">Leave blank to activate immediately.</span>
        </label>

        <label class="text-sm font-bold">
            Ends At
            <input class="admin-input" type="date" name="ends_at" value="{{ old('ends_at', optional($item->ends_at)->format('Y-m-d')) }}">
            <span class="mt-1 block text-xs font-normal text-slate-500">Leave blank for no expiration date.</span>
        </label>
    </div>

    <label class="flex items-center gap-3 text-sm font-bold">
        <input class="h-5 w-5 rounded text-cyan-600 focus:ring-cyan-500" type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))>
        Publish this slider banner on the website
    </label>

    @if($item->exists)
        <p class="text-sm text-slate-500">Current schedule status: <strong>{{ $item->schedule_status_label }}</strong></p>
    @endif

    <button class="rounded-xl bg-slate-950 px-6 py-3 font-bold text-white transition hover:bg-cyan-600">
        Save Slider Banner
    </button>
</form>

<style>
.admin-input {
    margin-top: .5rem;
    display: block;
    width: 100%;
    border-radius: .75rem;
    border: 1px solid #cbd5e1;
    padding: .7rem .85rem;
    font-weight: 400;
    outline: none;
}
.admin-input:focus {
    border-color: #06b6d4;
    box-shadow: 0 0 0 3px #cffafe;
}
</style>

<script>
document.getElementById('slider-image')?.addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('slider-preview');
    const placeholder = document.getElementById('slider-placeholder');
    if (!file) return;
    const url = URL.createObjectURL(file);
    preview.onload = () => URL.revokeObjectURL(url);
    preview.onerror = () => {
        URL.revokeObjectURL(url);
        preview.removeAttribute('src');
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    };
    preview.src = url;
    preview.classList.remove('hidden');
    placeholder.classList.add('hidden');
});

document.getElementById('slider-mobile-image')?.addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('mobile-preview');
    const placeholder = document.getElementById('mobile-placeholder');
    if (!file) return;
    const url = URL.createObjectURL(file);
    preview.onload = () => URL.revokeObjectURL(url);
    preview.onerror = () => {
        URL.revokeObjectURL(url);
        preview.removeAttribute('src');
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    };
    preview.src = url;
    preview.classList.remove('hidden');
    placeholder.classList.add('hidden');
});
</script>
@endsection
