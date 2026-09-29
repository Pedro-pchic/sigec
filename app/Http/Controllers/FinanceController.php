<?php

namespace App\Http\Controllers;

use App\Enums\FinancialCategory;
use App\Models\Expense;
use App\Models\Income;
use App\Support\Money;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FinanceController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from'],
        ]);
        $from = $filters['from'] ?? today()->startOfMonth()->toDateString();
        $to = $filters['to'] ?? today()->toDateString();

        $incomeTotalCents = Money::toCents((string) Income::query()
            ->whereBetween('date', [$from, $to])
            ->sum('amount'));
        $expenseTotalCents = Money::toCents((string) Expense::query()
            ->whereBetween('date', [$from, $to])
            ->sum('amount'));

        $incomeMovements = DB::table('incomes')
            ->leftJoin('payments', 'payments.id', '=', 'incomes.payment_id')
            ->whereBetween('incomes.date', [$from, $to])
            ->select([
                'incomes.id',
                'incomes.date',
                'incomes.category',
                'incomes.description',
                'incomes.amount',
                'incomes.created_at',
                'incomes.payment_id as source_id',
                'payments.number as reference',
            ])
            ->selectRaw("'income' as movement_type");

        $expenseMovements = DB::table('expenses')
            ->leftJoin('purchases', 'purchases.id', '=', 'expenses.purchase_id')
            ->whereBetween('expenses.date', [$from, $to])
            ->select([
                'expenses.id',
                'expenses.date',
                'expenses.category',
                'expenses.description',
                'expenses.amount',
                'expenses.created_at',
                'expenses.purchase_id as source_id',
                'purchases.number as reference',
            ])
            ->selectRaw("'expense' as movement_type");

        $movements = DB::query()
            ->fromSub($incomeMovements->unionAll($expenseMovements), 'financial_movements')
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString()
            ->through(function (object $movement): object {
                $movement->category_label = FinancialCategory::from($movement->category)->label();
                $movement->type_label = $movement->movement_type === 'income' ? 'Ingreso' : 'Gasto';
                $movement->origin_label = $movement->reference !== null
                    ? ($movement->movement_type === 'income' ? 'Payment' : 'Purchase')
                    : 'Manual';

                return $movement;
            });

        return view('finance.index', [
            'balance' => Money::fromCents($incomeTotalCents - $expenseTotalCents),
            'expenseTotal' => Money::fromCents($expenseTotalCents),
            'from' => $from,
            'incomeTotal' => Money::fromCents($incomeTotalCents),
            'movements' => $movements,
            'to' => $to,
        ]);
    }
}
