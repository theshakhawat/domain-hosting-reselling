<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DomainPricing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DomainController extends Controller
{
    /**
     * Display a listing of domain TLDs and their pricing.
     */
    public function index(): View
    {
        $domains = DomainPricing::orderBy('sort_order')->orderBy('tld')->get();

        return view('admin.domains.index', compact('domains'));
    }

    /**
     * Store a newly created domain TLD in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tld' => ['required', 'string', 'max:20', 'unique:domain_pricings,tld'],
            'price' => ['required', 'numeric', 'min:0'],
            'renewal_price' => ['nullable', 'numeric', 'min:0'],
            'badge' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        DomainPricing::create([
            'tld' => str_starts_with($validated['tld'], '.') ? $validated['tld'] : '.'.$validated['tld'],
            'price' => $validated['price'],
            'renewal_price' => $validated['renewal_price'] ?? $validated['price'],
            'badge' => $validated['badge'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        Cache::forget('homepage_data');

        return redirect()->route('admin.domains.index')->with('success', 'Domain TLD added successfully.');
    }

    /**
     * Update the specified domain TLD in storage.
     */
    public function update(Request $request, DomainPricing $domain): RedirectResponse
    {
        $validated = $request->validate([
            'tld' => ['required', 'string', 'max:20', 'unique:domain_pricings,tld,'.$domain->id],
            'price' => ['required', 'numeric', 'min:0'],
            'renewal_price' => ['nullable', 'numeric', 'min:0'],
            'badge' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $domain->update([
            'tld' => str_starts_with($validated['tld'], '.') ? $validated['tld'] : '.'.$validated['tld'],
            'price' => $validated['price'],
            'renewal_price' => $validated['renewal_price'] ?? $validated['price'],
            'badge' => $validated['badge'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active'),
        ]);

        Cache::forget('homepage_data');

        return redirect()->route('admin.domains.index')->with('success', 'Domain TLD updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(DomainPricing $domain): RedirectResponse
    {
        $domain->update(['is_active' => ! $domain->is_active]);
        Cache::forget('homepage_data');

        return back()->with('success', 'Domain status updated.');
    }

    /**
     * Remove the specified domain TLD from storage.
     */
    public function destroy(DomainPricing $domain): RedirectResponse
    {
        $domain->delete();
        Cache::forget('homepage_data');

        return redirect()->route('admin.domains.index')->with('success', 'Domain TLD deleted successfully.');
    }
}
