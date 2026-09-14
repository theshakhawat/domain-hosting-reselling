<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index(): View
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:100'],
            'role' => ['nullable', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:100'],
            'avatar' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Testimonial::create([
            'client_name' => $validated['client_name'],
            'role' => $validated['role'],
            'company' => $validated['company'],
            'avatar' => $validated['avatar'],
            'rating' => $validated['rating'],
            'review_text' => $validated['review_text'],
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        Cache::forget('homepage_data');

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added successfully.');
    }

    /**
     * Update the specified testimonial in storage.
     */
    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:100'],
            'role' => ['nullable', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:100'],
            'avatar' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $testimonial->update([
            'client_name' => $validated['client_name'],
            'role' => $validated['role'],
            'company' => $validated['company'],
            'avatar' => $validated['avatar'],
            'rating' => $validated['rating'],
            'review_text' => $validated['review_text'],
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        Cache::forget('homepage_data');

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['is_active' => ! $testimonial->is_active]);
        Cache::forget('homepage_data');

        return back()->with('success', 'Testimonial status updated.');
    }

    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();
        Cache::forget('homepage_data');

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
