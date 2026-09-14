<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FeatureController extends Controller
{
    /**
     * Display a listing of features.
     */
    public function index(): View
    {
        $features = Feature::orderBy('sort_order')->get();

        return view('admin.features.index', compact('features'));
    }

    /**
     * Store a newly created feature in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'icon' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'badge' => ['nullable', 'string', 'max:50'],
            'highlight_metric' => ['nullable', 'string', 'max:100'],
            'is_highlight' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Feature::create([
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'description' => $validated['description'],
            'badge' => $validated['badge'],
            'highlight_metric' => $validated['highlight_metric'],
            'is_highlight' => $request->boolean('is_highlight'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        Cache::forget('homepage_data');

        return redirect()->route('admin.features.index')->with('success', 'Feature created successfully.');
    }

    /**
     * Update the specified feature in storage.
     */
    public function update(Request $request, Feature $feature): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'icon' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'badge' => ['nullable', 'string', 'max:50'],
            'highlight_metric' => ['nullable', 'string', 'max:100'],
            'is_highlight' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $feature->update([
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'description' => $validated['description'],
            'badge' => $validated['badge'],
            'highlight_metric' => $validated['highlight_metric'],
            'is_highlight' => $request->boolean('is_highlight'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        Cache::forget('homepage_data');

        return redirect()->route('admin.features.index')->with('success', 'Feature updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Feature $feature): RedirectResponse
    {
        $feature->update(['is_active' => ! $feature->is_active]);
        Cache::forget('homepage_data');

        return back()->with('success', 'Feature status updated.');
    }

    /**
     * Remove the specified feature from storage.
     */
    public function destroy(Feature $feature): RedirectResponse
    {
        $feature->delete();
        Cache::forget('homepage_data');

        return redirect()->route('admin.features.index')->with('success', 'Feature deleted successfully.');
    }
}
