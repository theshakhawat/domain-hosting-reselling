<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostingPlan;
use App\Models\PlanCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //
    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:50'],
            'badge' => ['nullable', 'string', 'max:50'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = Str::slug($validated['slug'] ?: $validated['name']);

        // Prevent empty slug
        if (empty($slug)) {
            $slug = 'cat-'.time();
        }

        // Check if slug exists, append counter if needed
        $originalSlug = $slug;
        $counter = 1;
        while (PlanCategory::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $category = PlanCategory::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'badge' => $validated['badge'] ?? null,
            'tagline' => $validated['tagline'] ?? null,
            'sort_order' => $validated['sort_order'] ?? (PlanCategory::max('sort_order') + 1),
            'is_active' => true,
        ]);

        Cache::forget('homepage_data');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'category' => $category,
            ]);
        }

        return redirect()->back()->with('success', "Category '{$category->name}' created successfully.");
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, PlanCategory $category): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:50'],
            'badge' => ['nullable', 'string', 'max:50'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $newSlug = Str::slug($validated['slug'] ?: $validated['name']);
        if (empty($newSlug)) {
            $newSlug = $category->slug;
        }

        // Ensure uniqueness excluding current category
        $originalSlug = $newSlug;
        $counter = 1;
        while (PlanCategory::where('slug', $newSlug)->where('id', '!=', $category->id)->exists()) {
            $newSlug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $oldSlug = $category->slug;

        $category->update([
            'name' => $validated['name'],
            'slug' => $newSlug,
            'badge' => $validated['badge'] ?? null,
            'tagline' => $validated['tagline'] ?? null,
            'sort_order' => $validated['sort_order'] ?? $category->sort_order,
        ]);

        // If slug changed, cascade update to hosting plans
        if ($oldSlug !== $newSlug) {
            HostingPlan::where('category', $oldSlug)->update(['category' => $newSlug]);
        }

        Cache::forget('homepage_data');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'category' => $category,
            ]);
        }

        return redirect()->back()->with('success', "Category '{$category->name}' updated successfully.");
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(PlanCategory $category): RedirectResponse
    {
        $catName = $category->name;
        $oldSlug = $category->slug;

        // Reassign any hosting plans in this category to fallback to avoid orphan plans
        $fallback = PlanCategory::where('id', '!=', $category->id)->orderBy('sort_order')->first();
        $fallbackSlug = $fallback ? $fallback->slug : 'shared';

        $reassignedCount = HostingPlan::where('category', $oldSlug)->update(['category' => $fallbackSlug]);

        $category->delete();

        Cache::forget('homepage_data');

        $msg = "Category '{$catName}' deleted successfully.";
        if ($reassignedCount > 0) {
            $msg .= " ({$reassignedCount} plan(s) were reassigned to '{$fallbackSlug}').";
        }

        return redirect()->back()->with('success', $msg);
    }
}
