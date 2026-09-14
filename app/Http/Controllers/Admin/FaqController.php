<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * Display a listing of FAQs.
     */
    public function index(): View
    {
        $faqs = Faq::orderBy('sort_order')->get();

        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Faq::create([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        Cache::forget('homepage_data');

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ item created successfully.');
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $faq->update([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        Cache::forget('homepage_data');

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ item updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Faq $faq): RedirectResponse
    {
        $faq->update(['is_active' => ! $faq->is_active]);
        Cache::forget('homepage_data');

        return back()->with('success', 'FAQ status updated.');
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();
        Cache::forget('homepage_data');

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ item deleted successfully.');
    }
}
