<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;


class BudgetController extends Controller
{
    // Menampilkan semua data budget
    public function index()
    {
        $request = request(); 
        $budgets = Budget::latest()->get();


        $income = Transaction::where('type', 'in')->sum('amount');
        $outcome = Transaction::where('type', 'out')->sum('amount');
        $balance = $income - $outcome;

        $currentDate = now()->translatedFormat('l, d F Y');

        // Anggaran
        $anggaran = Budget::sum('amount');

        $persenSisa = $anggaran > 0 ? round((($anggaran - $outcome) / $anggaran) * 100) : 100;
        $persenPakai = 100 - $persenSisa;

         

        return view('budgets', compact(
            'budgets', 'balance',  
            'income', 'outcome', 'persenSisa', 'persenPakai'
        ));
    }

    // Menampilkan form create
    public function create()
    {
        return view('budgets.create');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'category'   => 'required|string|max:255',
            'amount'     => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        Budget::create($request->all());

        return redirect()->route('budgets')->with('success', 'Budget created successfully.');
    }

    // Menampilkan form edit
    public function edit(Budget $budget)
    {
        return view('budgets.edit', compact('budget'));
    }

    // Menyimpan update
    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'category'   => 'required|string|max:255',
            'amount'     => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $budget->update($request->all());

        return redirect()->route('budgets')->with('success', 'Budget updated successfully.');
    }

    // Menghapus data
    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets')->with('success', 'Budget deleted successfully.');
    }
}
