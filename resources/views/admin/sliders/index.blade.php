@extends('layouts.admin')
@section('title', 'Hero Sliders')
@section('page_heading', 'Hero Sliders')
@section('content')
<div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="text-sm text-slate-500">Manage hero banners and top sliders on the website</p>
        <h2 class="text-3xl font-black">Hero Sliders</h2>
    </div>
    <a class="inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-600 px-5 py-3 text-center text-sm font-bold text-white shadow-lg shadow-cyan-600/20 hover:bg-cyan-700" href="{{ route('admin.sliders.create') }}">
        <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        Add Slider
    </a>
</div>

<form method="GET" class="mb-5 flex flex-wrap items-center gap-3">
    <label class="text-sm font-bold text-slate-600" for="slider-status">Filter status</label>
    <select id="slider-status" name="status" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium" onchange="this.form.submit()">
        @foreach(['all' => 'All statuses', 'active' => 'Active', 'inactive' => 'Inactive', 'upcoming' => 'Upcoming', 'expired' => 'Expired'] as $value => $label)
            <option value="{{ $value }}" @selected(($status ?? 'all') === $value)>{{ $label }}</option>
        @endforeach
    </select>
</form>

<div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[760px] text-left text-sm">
            <thead class="bg-slate-950 text-xs uppercase tracking-wider text-slate-300">
                <tr>
                    <th class="px-5 py-4">Desktop Banner</th>
                    <th class="px-5 py-4">Mobile Banner</th>
                    <th class="px-5 py-4">Title & Details</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t border-slate-100 hover:bg-slate-50">
                        <td class="px-5 py-4 font-bold">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title ?: 'Slider banner' }}" class="h-14 w-28 rounded-lg border border-slate-200 object-cover shadow-sm">
                            @else
                                <span class="text-slate-400">No desktop image</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @if($item->mobile_image)
                                <img src="{{ $item->mobile_image_url }}" alt="Mobile banner" class="h-14 w-12 rounded-lg border border-slate-200 object-cover shadow-sm">
                            @else
                                <span class="text-xs text-slate-400">Same as desktop</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-600">
                            <div class="font-bold text-slate-900">{{ $item->title ?: 'Untitled Banner' }}</div>
                            <div class="mt-1 flex flex-wrap items-center gap-2 text-xs">
                                @if($item->badge)
                                    <span class="rounded bg-cyan-100 px-2 py-0.5 font-bold text-cyan-800">{{ $item->badge }}</span>
                                @endif
                                <span class="rounded bg-slate-100 px-2 py-0.5 font-medium text-slate-600">Order: {{ $item->sort_order }}</span>
                                @if($item->link)
                                    <a href="{{ $item->link }}" target="_blank" class="text-cyan-600 underline">Link ↗</a>
                                @endif
                            </div>
                            <div class="mt-1 text-xs text-slate-400">
                                {{ $item->starts_at ? $item->starts_at->format('d M Y') : 'Now' }} – {{ $item->ends_at ? $item->ends_at->format('d M Y') : 'No end date' }}
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @php($statusLabel = $item->schedule_status_label)
                            <span class="mr-2 inline-block rounded-full px-3 py-1 text-xs font-bold {{ $statusLabel === 'Active' ? 'bg-emerald-50 text-emerald-700' : ($statusLabel === 'Upcoming' ? 'bg-blue-50 text-blue-700' : ($statusLabel === 'Expired' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-500')) }}">
                                {{ $statusLabel }}
                            </span>
                            <form class="mt-2 inline-block" method="POST" action="{{ route('admin.sliders.toggle', $item) }}{{ request()->getQueryString() ? '?'.request()->getQueryString() : '' }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_active" value="{{ $item->is_active ? 0 : 1 }}">
                                <button class="rounded-lg border border-slate-200 px-2 py-1 text-xs font-semibold text-slate-600 hover:border-cyan-400 hover:text-cyan-700">
                                    {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <a aria-label="Edit {{ $item->title }}" title="Edit" class="mr-4 inline-flex items-center gap-1 font-bold text-cyan-600 hover:text-cyan-800" href="{{ route('admin.sliders.edit', $item) }}">
                                <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m4 16 9.5-9.5a2.1 2.1 0 0 1 3 3L7 19H4v-3Z"/><path d="m13 7 3 3"/></svg>
                                Edit
                            </a>
                            <form class="inline" method="POST" action="{{ route('admin.sliders.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button aria-label="Delete {{ $item->title }}" title="Delete" class="inline-flex items-center gap-1 font-bold text-red-500 hover:text-red-700" onclick="return confirm('Delete this slider banner?')">
                                    <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4h8v2m-7 4v8m6-8v8M5 6l1 14h12l1-14"/></svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-slate-500">
                            No hero sliders found. Add your first slider banner above.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-5">
    {{ $items->links() }}
</div>
@endsection
