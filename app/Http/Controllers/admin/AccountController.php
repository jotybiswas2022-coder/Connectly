<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Account;

class AccountController extends Controller
{
    public function index()
    {
        $account = Account::first();
        return view('backend.account.index', compact('account'));
    }

    public function edit()
    {
        $account = Account::first();
        return view('backend.account.edit', compact('account'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:255',
            'website'  => 'nullable|url|max:255',
            'image'    => 'nullable|image|max:2048',
        ]);

        $account = Account::first();

        if (!$account) {
            $account = new Account();
        }

        // Basic Info
        $account->name    = $request->name;
        $account->phone   = $request->phone;
        $account->email   = $request->email;
        $account->website = $request->website;

        // Image upload
        if ($request->hasFile('image')) {

            // Delete old image
            if ($account->image && Storage::disk('public')->exists($account->image)) {
                Storage::disk('public')->delete($account->image);
            }

            $account->image = $request->file('image')->store('profile', 'public');
        }

        $account->save();

        return redirect()->back()->with('success', 'Account updated successfully!');
    }
}