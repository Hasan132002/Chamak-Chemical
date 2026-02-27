<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactLead;
use Illuminate\Http\Request;

class ContactLeadAdminController extends Controller
{
    public function index()
    {
        $leads = ContactLead::latest()->paginate(20);
        return view('admin.contact-leads.index', compact('leads'));
    }

    public function show(ContactLead $lead)
    {
        if ($lead->status === 'new') {
            $lead->update(['status' => 'read']);
        }
        return view('admin.contact-leads.show', compact('lead'));
    }

    public function updateStatus(Request $request, ContactLead $lead)
    {
        $request->validate(['status' => 'required|in:new,read,replied']);
        $lead->update(['status' => $request->status]);
        return back()->with('success', 'Lead status updated!');
    }

    public function destroy(ContactLead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.contact-leads.index')->with('success', 'Lead deleted!');
    }
}
