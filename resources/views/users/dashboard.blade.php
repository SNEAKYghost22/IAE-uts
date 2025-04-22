<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Banking Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 bg-gray-100">
    <h1 class="text-3xl font-bold mb-6">🏦 Banking Dashboard</h1>

    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">👤 Users</h2>
            <ul>
                @foreach($users as $user)
                    <li>{{ $user['name'] }} ({{ $user['email'] }})</li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">💳 Accounts</h2>
            <ul>
                @foreach($accounts as $account)
                    <li>Acc #{{ $account['id'] }} - Balance: ${{ $account['balance'] }}</li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">💸 Transactions</h2>
            <ul>
                @foreach($transactions as $tx)
                    <li>From {{ $tx['sender_account_id'] }} to {{ $tx['receiver_account_id'] }} - ${{ $tx['amount'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>