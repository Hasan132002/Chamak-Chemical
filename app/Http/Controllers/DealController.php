<?php

namespace App\Http\Controllers;

use App\Models\Deal;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::active()
            ->with('translations')
            ->orderBy('sort_order')
            ->get();

        return view('deals.index', compact('deals'));
    }
}
