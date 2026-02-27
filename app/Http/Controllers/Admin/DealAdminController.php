<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\DealTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DealAdminController extends Controller
{
    public function index()
    {
        $deals = Deal::with('translations')->orderBy('sort_order')->get();
        return view('admin.deals.index', compact('deals'));
    }

    public function create()
    {
        return view('admin.deals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ur' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ur' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'nullable|string|max:255',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'sort_order' => 'nullable|integer',
        ]);

        $deal = Deal::create([
            'url' => $validated['url'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? null,
            'starts_at' => $validated['starts_at'] ?? null,
            'ends_at' => $validated['ends_at'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->hasFile('image')) {
            $deal->update(['image' => $request->file('image')->store('deals', 'public')]);
        }

        DealTranslation::create([
            'deal_id' => $deal->id,
            'locale' => 'en',
            'title' => $validated['title_en'],
            'description' => $validated['description_en'] ?? '',
        ]);

        DealTranslation::create([
            'deal_id' => $deal->id,
            'locale' => 'ur',
            'title' => $validated['title_ur'],
            'description' => $validated['description_ur'] ?? '',
        ]);

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal created successfully!');
    }

    public function edit(Deal $deal)
    {
        $deal->load('translations');
        return view('admin.deals.edit', compact('deal'));
    }

    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ur' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ur' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'nullable|string|max:255',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'sort_order' => 'nullable|integer',
        ]);

        $deal->update([
            'url' => $validated['url'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? null,
            'starts_at' => $validated['starts_at'] ?? null,
            'ends_at' => $validated['ends_at'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->hasFile('image')) {
            if ($deal->image) {
                Storage::disk('public')->delete($deal->image);
            }
            $deal->update(['image' => $request->file('image')->store('deals', 'public')]);
        }

        $deal->translations()->where('locale', 'en')->update([
            'title' => $validated['title_en'],
            'description' => $validated['description_en'] ?? '',
        ]);

        $deal->translations()->where('locale', 'ur')->update([
            'title' => $validated['title_ur'],
            'description' => $validated['description_ur'] ?? '',
        ]);

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal updated successfully!');
    }

    public function destroy(Deal $deal)
    {
        if ($deal->image) {
            Storage::disk('public')->delete($deal->image);
        }
        $deal->delete();

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal deleted successfully!');
    }
}
