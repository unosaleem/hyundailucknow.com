<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public const STATUSES = ['new', 'contacted', 'qualified', 'closed', 'spam'];

    public function index(Request $request)
    {
        $filters = $this->validatedFilters($request);
        $query = $this->filteredQuery($filters);

        return view('admin.leads.index', [
            'items' => $query->latest()->paginate(20)->withQueryString(),
            'filteredCount' => (clone $query)->count(),
            'totalCount' => Lead::count(),
            'models' => Lead::query()->select('model')->whereNotNull('model')->distinct()->orderBy('model')->pluck('model'),
            'enquiryTypes' => Lead::query()->select('enquiry_type')->whereNotNull('enquiry_type')->distinct()->orderBy('enquiry_type')->pluck('enquiry_type'),
            'statuses' => self::STATUSES,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $filters = $this->validatedFilters($request);
        $query = $this->filteredQuery($filters)->latest();
        $filename = 'leads-report-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Created at', 'Customer', 'Model', 'Offer', 'City', 'Mobile', 'Email', 'Enquiry type', 'Source', 'Spam status', 'Status', 'Notes']);
            $query->chunk(500, function ($leads) use ($handle): void {
                foreach ($leads as $lead) {
                    fputcsv($handle, [$lead->id, $lead->created_at?->toDateTimeString(), $lead->name, $lead->model, $lead->offer?->title, $lead->city, $lead->mobile, $lead->email, $lead->enquiry_type, $lead->source, $lead->status === 'spam' ? 'Spam' : 'Not spam', $lead->status, $lead->notes]);
                }
            });
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate(['status' => ['required', 'in:'.implode(',', self::STATUSES)], 'notes' => ['nullable', 'string', 'max:5000']]);
        $lead->update($data);
        return back()->with('success', 'Lead updated.');
    }

    public function toggleSpam(Lead $lead)
    {
        $lead->update(['status' => $lead->status === 'spam' ? 'new' : 'spam']);

        return back()->with('success', $lead->status === 'spam' ? 'Lead marked as spam.' : 'Lead restored from spam.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return back()->with('success', 'Lead deleted.');
    }

    private function validatedFilters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:'.implode(',', self::STATUSES)],
            'enquiry_type' => ['nullable', 'string', 'max:100'],
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'],
            'month' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
        ]);
    }

    private function filteredQuery(array $filters): Builder
    {
        return Lead::query()->with('offer')
            ->when($filters['search'] ?? null, fn (Builder $q, string $value) => $q->where(function (Builder $search) use ($value): void {
                $search->where('name', 'like', "%{$value}%")->orWhere('mobile', 'like', "%{$value}%")->orWhere('email', 'like', "%{$value}%")->orWhere('city', 'like', "%{$value}%");
            }))
            ->when($filters['model'] ?? null, fn (Builder $q, string $value) => $q->where('model', $value))
            ->when($filters['status'] ?? null, fn (Builder $q, string $value) => $q->where('status', $value))
            ->when($filters['enquiry_type'] ?? null, fn (Builder $q, string $value) => $q->where('enquiry_type', $value))
            ->when($filters['from_date'] ?? null, fn (Builder $q, string $value) => $q->whereDate('created_at', '>=', $value))
            ->when($filters['to_date'] ?? null, fn (Builder $q, string $value) => $q->whereDate('created_at', '<=', $value))
            ->when($filters['month'] ?? null, fn (Builder $q, int $value) => $q->whereMonth('created_at', $value))
            ->when($filters['year'] ?? null, fn (Builder $q, int $value) => $q->whereYear('created_at', $value));
    }
}
