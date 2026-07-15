<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        // Fetch counts
        $accountsCount = Account::count();
        $contactsCount = Contact::count();
        $usersCount = User::count(); 

        // Fetch recent data
        $contacts = Contact::latest()->take(5)->get(); 
        $users = User::latest()->take(10)->get(); // Recent 10 users
        $account = Account::first(); // Admin account info

        // Pass usersCount to the view
        return view('backend.index', compact(
            'accountsCount',
            'contacts',
            'contactsCount',
            'users',
            'account',
            'usersCount' 
        ));
    }
}