<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;


class ExpenseController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

     public static function middleware(){
        return [
            new Middleware('auth:sanctum',except:['index', 'show'])
        ];
     }

    public function index()
    {
        $expenses = Expense::with(['user', 'category'])
            ->get();
        return response()->json([
            'expenses' => $expenses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',

        ]);

        if (!$validated) {
            return response()->json([
                'message' => 'Invalid data provided',
            ], 422);
        }

        $expense = $request->user()->expenses()->create($validated);

        return response()->json([
            'message' => 'Expense created successfully',
            'expense' => $expense,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $expens = Expense::findOrFail($expense->id);
        return response()->json([
            'expense' => $expens,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->json([
            'message' => 'Expense deleted successfully',
        ], 200);
    }
}
