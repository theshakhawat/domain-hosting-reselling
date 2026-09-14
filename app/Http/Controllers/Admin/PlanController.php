<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostingPlan;
use App\Models\PlanCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Display a listing of hosting plans.
     */
    public function index(Request $request): View
    {
        $category = $request->query('category');

        $categories = PlanCategory::orderBy('sort_order')->get();

        $query = HostingPlan::query();

        if (! empty($category)) {
            $query->where('category', $category);
        }

        $plans = $query
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get();

        return view('admin.plans.index', compact(
            'plans',
            'category',
            'categories'
        ));
    }

    /**
     * Show the form for creating a new hosting plan.
     */
    public function create(): View
    {
        $categories = PlanCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.plans.form', [
            'plan' => new HostingPlan([
                'category' => $categories->first()?->slug ?? 'shared',
                'is_active' => true,
                'sort_order' => 0,
            ]),
            'categories' => $categories,
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created hosting plan in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:50'],
            'new_category_name' => ['nullable', 'string', 'max:100'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'monthly_price' => ['required', 'numeric', 'min:0'],
            'yearly_price' => ['nullable', 'numeric', 'min:0'],
            'badge' => ['nullable', 'string', 'max:50'],
            'features_raw' => ['nullable', 'string'],
            'storage' => ['nullable', 'string', 'max:50'],
            'bandwidth' => ['nullable', 'string', 'max:50'],
            'cpu' => ['nullable', 'string', 'max:50'],
            'ram' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $finalCategory = $this->resolveCategorySlug($request);

        $features = $this->parseFeatures(
            $request->input('features_raw')
        );

        HostingPlan::create([
            'name' => $validated['name'],
            'category' => $finalCategory,
            'tagline' => $validated['tagline'] ?? null,
            'monthly_price' => $validated['monthly_price'],
            'yearly_price' => $validated['yearly_price']
                ?? ($validated['monthly_price'] * 10),
            'badge' => $validated['badge'] ?? null,
            'features' => $features,
            'storage' => $validated['storage'] ?? null,
            'bandwidth' => $validated['bandwidth'] ?? null,
            'cpu' => $validated['cpu'] ?? null,
            'ram' => $validated['ram'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        Cache::forget('homepage_data');

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Hosting plan created successfully.');
    }

    /**
     * Show form for editing the specified hosting plan.
     */
    public function edit(HostingPlan $plan): View
    {
        $categories = PlanCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.plans.form', [
            'plan' => $plan,
            'categories' => $categories,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified hosting plan in storage.
     */
    public function update(
        Request $request,
        HostingPlan $plan
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:50'],
            'new_category_name' => ['nullable', 'string', 'max:100'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'monthly_price' => ['required', 'numeric', 'min:0'],
            'yearly_price' => ['nullable', 'numeric', 'min:0'],
            'badge' => ['nullable', 'string', 'max:50'],
            'features_raw' => ['nullable', 'string'],
            'storage' => ['nullable', 'string', 'max:50'],
            'bandwidth' => ['nullable', 'string', 'max:50'],
            'cpu' => ['nullable', 'string', 'max:50'],
            'ram' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $finalCategory = $this->resolveCategorySlug($request);

        $features = $this->parseFeatures(
            $request->input('features_raw')
        );

        $plan->update([
            'name' => $validated['name'],
            'category' => $finalCategory,
            'tagline' => $validated['tagline'] ?? null,
            'monthly_price' => $validated['monthly_price'],
            'yearly_price' => $validated['yearly_price']
                ?? ($validated['monthly_price'] * 10),
            'badge' => $validated['badge'] ?? null,
            'features' => $features,
            'storage' => $validated['storage'] ?? null,
            'bandwidth' => $validated['bandwidth'] ?? null,
            'cpu' => $validated['cpu'] ?? null,
            'ram' => $validated['ram'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active'),
        ]);

        Cache::forget('homepage_data');

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Hosting plan updated successfully.');
    }

    /**
     * Resolve and ensure category exists in plan_categories.
     */
    protected function resolveCategorySlug(Request $request): string
    {
        $catInput = $request->input('category');

        $newName = trim(
            $request->input('new_category_name') ?? ''
        );

        if ($catInput === 'custom' || ! empty($newName)) {
            $nameToUse = ! empty($newName)
                ? $newName
                : 'Custom Hosting';

            $slug = Str::slug($nameToUse);

            PlanCategory::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $nameToUse,
                    'is_active' => true,
                    'sort_order' => (PlanCategory::max('sort_order') ?? 0) + 1,
                ]
            );

            return $slug;
        }

        $slug = Str::slug($catInput);

        PlanCategory::firstOrCreate(
            ['slug' => $slug],
            [
                'name' => Str::headline($slug),
                'is_active' => true,
                'sort_order' => (PlanCategory::max('sort_order') ?? 0) + 1,
            ]
        );

        return $slug;
    }

    /**
     * Toggle the active status of the plan.
     */
    public function toggleStatus(
        HostingPlan $plan
    ): RedirectResponse {
        $plan->update([
            'is_active' => ! $plan->is_active,
        ]);

        Cache::forget('homepage_data');

        return back()->with(
            'success',
            'Plan status updated.'
        );
    }

    /**
     * Remove the specified hosting plan from storage.
     */
    public function destroy(
        HostingPlan $plan
    ): RedirectResponse {
        $plan->delete();

        Cache::forget('homepage_data');

        return redirect()
            ->route('admin.plans.index')
            ->with(
                'success',
                'Hosting plan removed successfully.'
            );
    }

    /**
     * Parse multiline features input.
     *
     * @return array<int, string>
     */
    private function parseFeatures(?string $raw): array
    {
        if (! $raw) {
            return [];
        }

        $lines = preg_split(
            "/\r\n|\r|\n/",
            $raw
        );

        return array_values(
            array_filter(
                array_map('trim', $lines)
            )
        );
    }
}
