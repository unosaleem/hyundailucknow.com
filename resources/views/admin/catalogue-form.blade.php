@extends('layouts.admin')
@section('title', ($item->exists ? 'Edit ' : 'Add ') . rtrim(ucfirst($type), 's'))
@section('page_heading', ($item->exists ? 'Edit ' : 'Add ') . rtrim(ucfirst($type), 's'))
@section('content')
@php($isCar = $type === 'cars')
@php($isOffer = $type === 'offers')
@php($isVideo = $type === 'videos')
<div class="mb-6"><a class="text-sm font-bold text-cyan-600" href="{{ route('admin.'.$type.'.index') }}">← Back to {{ ucfirst($type) }}</a><h2 class="mt-3 text-3xl font-black">{{ $item->exists ? 'Edit' : 'Add' }} {{ rtrim(ucfirst($type), 's') }}</h2></div>
<form class="max-w-3xl space-y-6 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-8" method="POST" enctype="{{ ($isCar || $isOffer) ? 'multipart/form-data' : 'application/x-www-form-urlencoded' }}" action="{{ $item->exists ? route('admin.'.$type.'.update', $item) : route('admin.'.$type.'.store') }}">
@csrf @if($item->exists) @method('PUT') @endif
<div class="grid gap-5 sm:grid-cols-2">
<label class="text-sm font-bold">{{ $isCar ? 'Car name' : ($isOffer ? 'Offer title' : 'Video title') }}<span class="required-marker" aria-hidden="true">*</span><span class="sr-only">(required)</span><input class="admin-input" required name="{{ $isCar ? 'name' : 'title' }}" value="{{ old($isCar ? 'name' : 'title', $item->{$isCar ? 'name' : 'title'}) }}"></label>
@if($isCar)
<label class="text-sm font-bold">Category
  @php($category = old('category', $item->exists ? $item->category : 'SUV'))
  <select class="admin-input" name="category">
    @foreach(['SUV', 'Sedan', 'Hatchback', 'Electric', 'MPV', 'Other'] as $option)
      <option value="{{ $option }}" @selected($category === $option)>{{ $option }}</option>
    @endforeach
    @if($item->exists && $item->category && !in_array($item->category, ['SUV', 'Sedan', 'Hatchback', 'Electric', 'MPV', 'Other'], true))
      <option value="{{ $item->category }}" selected>{{ $item->category }}</option>
    @endif
  </select>
</label>
<label class="text-sm font-bold">Engine details<input class="admin-input" name="engine_details" value="{{ old('engine_details', $item->engine_details) }}" placeholder="1.5L Petrol / Diesel"></label>
<label class="text-sm font-bold">Ex-showroom price<input class="admin-input" name="ex_showroom_price" value="{{ old('ex_showroom_price', $item->ex_showroom_price ?: $item->price) }}" placeholder="₹11.11 Lakh*"></label>
<label class="text-sm font-bold">Display order<input class="admin-input" type="number" min="0" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}"></label>
<label class="text-sm font-bold sm:col-span-2">Slug<input class="admin-input" name="slug" value="{{ old('slug', $item->slug) }}"></label>
<div class="sm:col-span-2">
  <label class="text-sm font-bold">Car image <span class="font-normal text-slate-500">(JPG, PNG, WebP or AVIF, max 5 MB)</span><input id="car-image" class="admin-input" type="file" name="image" accept="image/jpeg,image/png,image/webp,image/avif"></label>
  <div class="mt-3 flex items-center gap-4"><img id="image-preview" class="h-28 w-44 rounded-xl border border-slate-200 object-cover {{ $item->image_url ? '' : 'hidden' }}" src="{{ $item->image_url ?? '' }}" alt="Car image preview"><span id="image-placeholder" class="text-sm text-slate-400 {{ $item->image_url ? 'hidden' : '' }}">Choose an image to preview it here.</span></div>
</div>
@elseif($isOffer)<label class="text-sm font-bold">Badge<input class="admin-input" name="badge" placeholder="Limited time" value="{{ old('badge', $item->badge) }}"></label><div><label class="text-sm font-bold">Offer image <span class="font-normal text-slate-500">(JPG, PNG, WebP or AVIF, max 5 MB)</span><input id="offer-image" class="admin-input" type="file" name="image" accept="image/jpeg,image/png,image/webp,image/avif"></label><img id="offer-preview" class="mt-3 h-20 w-32 rounded-lg object-cover {{ $item->image_url ? '' : 'hidden' }}" src="{{ $item->image_url ?? '' }}" alt="Offer image preview"><span id="offer-placeholder" class="mt-3 hidden text-sm text-slate-400">Preview unavailable in this browser; image will still be uploaded.</span></div><label class="text-sm font-bold">Starts at<input class="admin-input" type="date" name="starts_at" value="{{ old('starts_at', optional($item->starts_at)->format('Y-m-d')) }}"><span class="mt-1 block text-xs font-normal text-slate-500">Leave blank to start immediately.</span></label><label class="text-sm font-bold">Ends at<input class="admin-input" type="date" name="ends_at" value="{{ old('ends_at', optional($item->ends_at)->format('Y-m-d')) }}"><span class="mt-1 block text-xs font-normal text-slate-500">Leave blank for no expiry. The end date is inclusive.</span></label>
@else<label class="text-sm font-bold sm:col-span-2">Video URL <span class="required-marker" aria-hidden="true">*</span><span class="sr-only">(required)</span><span class="font-normal text-slate-500">(YouTube watch, youtu.be, Shorts or embed URL)</span><input class="admin-input" type="url" required name="url" value="{{ old('url', $item->url) }}"><span class="mt-1 block text-xs font-normal text-slate-500">Example: https://www.youtube.com/shorts/VIDEO_ID</span></label>
@endif
</div>
@if(!$isVideo)<label class="block text-sm font-bold">Description<textarea class="admin-input" rows="5" name="description">{{ old('description', $item->description) }}</textarea></label>@endif
<label class="flex items-center gap-3 text-sm font-bold"><input class="h-5 w-5 rounded text-cyan-600" type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Publish this {{ rtrim($type, 's') }}</label>
@if($isOffer && $item->exists)<p class="text-sm text-slate-500">Current schedule status: <strong>{{ $item->schedule_status_label }}</strong></p>@endif
<button class="rounded-xl bg-slate-950 px-6 py-3 font-bold text-white hover:bg-cyan-600">Save {{ rtrim($type, 's') }}</button>
</form>
<style>.admin-input{margin-top:.5rem;display:block;width:100%;border-radius:.75rem;border:1px solid #cbd5e1;padding:.7rem .85rem;font-weight:400;outline:none}.admin-input:focus{border-color:#06b6d4;box-shadow:0 0 0 3px #cffafe}</style>
@if($isCar)<script>
document.getElementById('car-image')?.addEventListener('change', function (event) {
  const file = event.target.files[0], preview = document.getElementById('image-preview'), placeholder = document.getElementById('image-placeholder');
  if (!file) return;
  const url = URL.createObjectURL(file);
  preview.onload = () => URL.revokeObjectURL(url);
  preview.onerror = () => { URL.revokeObjectURL(url); preview.removeAttribute('src'); preview.classList.add('hidden'); placeholder.classList.remove('hidden'); placeholder.textContent = 'Preview unavailable in this browser; image will still be uploaded.'; };
  preview.src = url; preview.classList.remove('hidden'); placeholder.classList.add('hidden');
});
</script>@endif
@if($isOffer)<script>
document.getElementById('offer-image')?.addEventListener('change', function (event) {
  const file = event.target.files[0], preview = document.getElementById('offer-preview'), placeholder = document.getElementById('offer-placeholder');
  if (file) {
    const url = URL.createObjectURL(file);
    preview.onload = () => URL.revokeObjectURL(url);
    preview.onerror = () => { URL.revokeObjectURL(url); preview.removeAttribute('src'); preview.classList.add('hidden'); placeholder.classList.remove('hidden'); };
    preview.src = url; preview.classList.remove('hidden'); placeholder.classList.add('hidden');
  }
});
</script>@endif
@endsection
