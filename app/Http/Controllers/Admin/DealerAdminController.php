<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerAdminController extends Controller
{
    public function index()
    {
        $dealers = Dealer::with('user')->latest()->paginate(20);
        return view('admin.dealers.index', compact('dealers'));
    }

    public function show(Dealer $dealer)
    {
        $dealer->load('user', 'approvedBy');
        return view('admin.dealers.show', compact('dealer'));
    }

    public function approve(Dealer $dealer)
    {
        $dealer->update([
            'approval_status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Dealer approved successfully!');
    }

    public function reject(Dealer $dealer)
    {
        $dealer->update([
            'approval_status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Dealer rejected successfully!');
    }
}
