@extends('layouts.admin')
@section('title', 'Website Settings')
@section('page_heading', 'Website Settings')
@section('content')
<div class="mb-6">
    <p class="text-sm text-slate-500">Configure global website metadata, SEO tags, phone numbers, and WhatsApp contact</p>
    <h2 class="mt-1 text-3xl font-black">Website Settings</h2>
</div>

<form class="max-w-4xl space-y-8" method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('PUT')

    <!-- Section 1: SEO & Meta Configuration -->
    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-cyan-50 text-cyan-600">
                <svg aria-hidden="true" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
            </span>
            <div>
                <h3 class="text-lg font-black text-slate-900">SEO & Meta Configuration</h3>
                <p class="text-xs text-slate-500">Controls search engine appearance and browser tab titles</p>
            </div>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-800">
                    Meta Title <span class="text-xs font-normal text-slate-400">(Recommended: 50–65 characters)</span>
                    <input id="meta_title_input" class="admin-input" name="meta_title" value="{{ old('meta_title', $setting->meta_title) }}" placeholder="e.g. BR Hyundai | Find Your Hyundai - Best Deals & Offers in Lucknow">
                </label>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-800">
                    Meta Description <span class="text-xs font-normal text-slate-400">(Recommended: 150–160 characters)</span>
                    <textarea id="meta_desc_input" rows="3" class="admin-input" name="meta_description" placeholder="Short compelling description of your dealership and Hyundai car offers...">{{ old('meta_description', $setting->meta_description) }}</textarea>
                </label>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-800">
                    Meta Keywords <span class="text-xs font-normal text-slate-400">(Comma separated)</span>
                    <input class="admin-input" name="meta_keywords" value="{{ old('meta_keywords', $setting->meta_keywords) }}" placeholder="e.g. BR Hyundai, Hyundai Lucknow, Creta Offer, Venue price, Car Dealer Lucknow">
                </label>
            </div>

            <!-- Live Google Preview -->
            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Search Engine Live Preview</p>
                <div class="mt-2 text-left font-sans">
                    <p class="text-xs text-slate-600">https://project.digitalnawab.com/brhyundai</p>
                    <h4 id="preview_title" class="truncate text-base font-medium text-blue-700 hover:underline">
                        {{ $setting->meta_title ?: 'BR Hyundai | Find Your Hyundai' }}
                    </h4>
                    <p id="preview_desc" class="line-clamp-2 text-xs text-slate-600">
                        {{ $setting->meta_description ?: 'Explore the newest Hyundai models and unlock tailored dealer benefits from BR Hyundai.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Contact Numbers & WhatsApp -->
    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg aria-hidden="true" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3.1 5.18 2 2 0 0 1 5.1 3h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L9 10.73a16 16 0 0 0 4.27 4.27l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92Z"/>
                </svg>
            </span>
            <div>
                <h3 class="text-lg font-black text-slate-900">Direct Contact & WhatsApp</h3>
                <p class="text-xs text-slate-500">Connected to all Call, WhatsApp and contact buttons on desktop and mobile</p>
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="block text-sm font-bold text-slate-800">
                    Phone / Call Number
                    <input class="admin-input" name="phone" value="{{ old('phone', $setting->phone) }}" placeholder="e.g. +91 9724 777 048">
                    <span class="mt-1 block text-xs font-normal text-slate-400">Used for tel: links and visible call text</span>
                </label>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-800">
                    WhatsApp Number
                    <input class="admin-input" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" placeholder="e.g. 919724777048">
                    <span class="mt-1 block text-xs font-normal text-slate-400">Numbers with country code (e.g. 91... for India, no + or spaces)</span>
                </label>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-800">
                    Official Email Address
                    <input class="admin-input" type="email" name="email" value="{{ old('email', $setting->email) }}" placeholder="sales@hyundailucknow.com">
                </label>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-800">
                    Working Hours
                    <input class="admin-input" name="working_hours" value="{{ old('working_hours', $setting->working_hours) }}" placeholder="e.g. Mon – Sun · 9am – 7pm">
                </label>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-bold text-slate-800">
                    Dealership Address / Bio
                    <textarea rows="2" class="admin-input" name="address" placeholder="Dealership address in Lucknow...">{{ old('address', $setting->address) }}</textarea>
                </label>
            </div>
        </div>
    </div>

    <div>
        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-8 py-4 font-bold text-white shadow-lg shadow-slate-950/20 transition hover:bg-cyan-600">
            <svg aria-hidden="true" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save All Settings
        </button>
    </div>
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
const titleInput = document.getElementById('meta_title_input');
const descInput = document.getElementById('meta_desc_input');
const prevTitle = document.getElementById('preview_title');
const prevDesc = document.getElementById('preview_desc');

titleInput?.addEventListener('input', () => {
    prevTitle.textContent = titleInput.value.trim() || 'BR Hyundai | Find Your Hyundai';
});

descInput?.addEventListener('input', () => {
    prevDesc.textContent = descInput.value.trim() || 'Explore the newest Hyundai models and unlock tailored dealer benefits from BR Hyundai.';
});
</script>
@endsection
