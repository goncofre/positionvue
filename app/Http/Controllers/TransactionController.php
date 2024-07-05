<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Store a newly created transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        $existingTransaction = Transaction::where('user_id', Auth::id())
            ->where('date', $request->input('date'))
            ->first();

        if ($existingTransaction) {
            return response()->json([
                'message' => 'Ya existe una transacción para esta fecha.',
            ], 422);
        }

        $transaction = new Transaction([
            'user_id' => Auth::id(),
            'date' => $request->input('date'),
            'amount' => $request->input('amount'),
        ]);

        $transaction->save();

        return response()->json([
            'message' => 'Transacción creada exitosamente!',
            'transaction' => $transaction,
        ], 201);
    }

    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->orderBy('date', 'asc')->get();

        return response()->json($transactions);
    }
}
