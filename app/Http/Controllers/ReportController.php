<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // income
        $incomeByCategory = DB::table('transactions')
        ->select('category', DB::raw('SUM(amount) as total'))
        ->where('type', 'in')
        ->groupBy('category')
        ->get();

        // Pisah label dan data buat chart
        $categories = $incomeByCategory->pluck('category')->toArray();
        $values = $incomeByCategory->pluck('total')->toArray();

        // Outcome
        $outcomeByCategory = DB::table('transactions')
        ->select('category', DB::raw('SUM(amount) as total'))
        ->where('type', 'out')
        ->groupBy('category')
        ->get();
        
        // Pisah label dan data buat chart
        $categoriesOut = $outcomeByCategory->pluck('category')->toArray();
        $valuesOut = $outcomeByCategory->pluck('total')->toArray();
        
        // LineChart

        return view('reports', compact(
        'categories', 'values', 'categoriesOut', 'valuesOut',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
