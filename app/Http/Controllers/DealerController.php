<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DealerController extends Controller
{
    public function register()
    {
        return view('wholesale.register');
    }

    public function storeRegistration(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'business_name' => 'required|string|max:255',
            'business_license' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'tax_id' => 'nullable|string|max:100',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'language_preference' => 'en',
            'is_active' => true,
        ]);

        $user->assignRole('dealer');

        // Handle file upload
        $businessLicensePath = null;
        if ($request->hasFile('business_license')) {
            $businessLicensePath = $request->file('business_license')->store('dealer-documents', 'public');
        }

        // Create dealer
        Dealer::create([
            'user_id' => $user->id,
            'business_name' => $validated['business_name'],
            'business_license' => $businessLicensePath,
            'tax_id' => $validated['tax_id'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'postal_code' => $validated['postal_code'],
            'approval_status' => 'pending',
            'dealer_tier' => 'bronze',
        ]);

        return redirect()->route('home')->with('success', __('Dealer registration submitted! We will review and contact you soon.'));
    }

    public function dashboard()
    {
        if (!auth()->user()->isDealer()) {
            return redirect()->route('home')->with('error', __('Unauthorized access'));
        }

        $dealer = auth()->user()->dealer;
        $orders = auth()->user()->orders()->where('order_type', 'wholesale')->latest()->paginate(10);

        return view('wholesale.dashboard', compact('dealer', 'orders'));
    }
}
