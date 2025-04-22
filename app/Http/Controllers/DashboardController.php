<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data dari service lain
        $users = Http::get('http://127.0.0.1:8000/api/users')->json();
        $accounts = Http::get('http://127.0.0.1:8001/api/accounts')->json();
        $transactions = Http::get('http://127.0.0.1:8002/api/transactions')->json();

        return view('dashboard', compact('users', 'accounts', 'transactions'));
    }
}
