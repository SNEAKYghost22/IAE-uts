<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transfer(Request $request, $senderAccountId, $receiverAccountId)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $senderAccount = Account::findOrFail($senderAccountId);
        $receiverAccount = Account::findOrFail($receiverAccountId);

        if ($senderAccount->balance < $validated['amount']) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        $senderAccount->balance -= $validated['amount'];
        $receiverAccount->balance += $validated['amount'];

        $senderAccount->save();
        $receiverAccount->save();

        // Make sure Transaction model is properly imported and namespace is correct
        $transaction = new Transaction();
        $transaction->sender_account_id = $senderAccount->id;
        $transaction->receiver_account_id = $receiverAccount->id;
        $transaction->amount = $validated['amount'];
        $transaction->status = 'completed';
        $transaction->save();

        return response()->json($transaction, 201);
    }
}
