<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\CarbonImmutable;

class OfferController extends Controller
{
    public function index(Request $request) {
        $status = $request->query('status', 'all');
        $today = CarbonImmutable::now(config('app.timezone'))->toDateString();
        $query = Offer::latest();
        if ($status === 'inactive') $query->where('is_active', false);
        elseif ($status === 'upcoming') $query->where('is_active', true)->whereDate('starts_at', '>', $today);
        elseif ($status === 'expired') $query->where('is_active', true)->whereDate('ends_at', '<', $today);
        elseif ($status === 'active') $query->where('is_active', true)
            ->where(function ($q) use ($today) { $q->whereNull('starts_at')->orWhereDate('starts_at', '<=', $today); })
            ->where(function ($q) use ($today) { $q->whereNull('ends_at')->orWhereDate('ends_at', '>=', $today); });
        return view('admin.offers.index', ['items' => $query->paginate(12)->withQueryString(), 'status' => $status]);
    }
    public function create() { return view('admin.offers.form', ['item' => new Offer]); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('offers', 'public');
        Offer::create($data);
        return redirect()->route('admin.offers.index')->with('success', 'Offer created.');
    }

    public function edit(Offer $offer) { return view('admin.offers.form', ['item' => $offer]); }

    public function update(Request $request, Offer $offer)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($offer->image && ! filter_var($offer->image, FILTER_VALIDATE_URL)) Storage::disk('public')->delete($offer->image);
            $data['image'] = $request->file('image')->store('offers', 'public');
        } else unset($data['image']);
        $offer->update($data);
        return redirect()->route('admin.offers.index')->with('success', 'Offer updated.');
    }

    public function destroy(Offer $offer)
    {
        if ($offer->image && ! filter_var($offer->image, FILTER_VALIDATE_URL)) Storage::disk('public')->delete($offer->image);
        $offer->delete();
        return back()->with('success', 'Offer deleted.');
    }

    public function toggle(Request $request, Offer $offer)
    {
        $data = $request->validate(['is_active' => ['required', 'boolean']]);
        $offer->update(['is_active' => $data['is_active']]);
        return redirect()->route('admin.offers.index', $request->query())->with('success', 'Offer status updated.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'mimetypes:image/jpeg,image/png,image/webp,image/avif', 'max:5120'],
            'badge' => ['nullable', 'string', 'max:50'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
