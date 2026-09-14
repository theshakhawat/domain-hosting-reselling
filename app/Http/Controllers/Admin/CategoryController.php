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
     * Remove the specified category from storage.
     */
    public function destroy(PlanCategory $category): RedirectResponse
    {
        // Check if any plans are using this category
        $hasPlans = HostingPlan::where('category', $category->slug)->exists();

        if ($hasPlans) {
            return redirect()->back()->with('error', "Cannot delete category '{$category->name}' because hosting plans are currently assigned to it. Please reassign or delete the plans first.");
        }

        $category->delete();

        Cache::forget('homepage_data');

        return redirect()->back()->with('success', "Category '{$category->name}' deleted successfully.");
    }
}
