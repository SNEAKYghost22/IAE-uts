<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function createAccount(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        $account = new Account();
        $account->user_id = $user->id;
        $account->account_number = 'ACC' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $account->balance = 0;
        $account->save();

        return response()->json($account, 201);
    }

    public function getAccountBalance($accountId)
    {
        $account = Account::findOrFail($accountId);
        return response()->json(['balance' => $account->balance]);
    }
    
    public function dashboard()
    {
        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->get();
        
        $accountIds = $accounts->pluck('id')->toArray();
        
        $recentTransactions = Transaction::where(function($query) use ($accountIds) {
                $query->whereIn('sender_account_id', $accountIds)
                      ->orWhereIn('receiver_account_id', $accountIds);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $totalBalance = $accounts->sum('balance');
        
        return view('dashboard', [
            'user' => $user,
            'accounts' => $accounts,
            'recentTransactions' => $recentTransactions,
            'totalBalance' => $totalBalance
        ]);
    }
}
