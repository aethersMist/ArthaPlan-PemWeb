<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->input('filter', 'bulan');
        $selectedDate = $request->input('date', now()->format('Y-m-d'));
        
        // Set default ke 1 Juni jika tidak ada parameter date
        if (!$request->has('date')) {
            $selectedDate = now()->month(6)->day(1)->format('Y-m-d');
        }

        $date = Carbon::parse($selectedDate);
        list($labels, $dataOut, $dataIn) = $this->getChartData($filter, $date);

        // Hitung total dan rata-rata
        $totalPengeluaran = array_sum($dataOut);
        $jumlahData = count($dataOut) ?: 1;
        $rataRata = $totalPengeluaran / $jumlahData;

        $income = Transaction::where('type', 'in')->sum('amount');
        $outcome = Transaction::where('type', 'out')->sum('amount');
        $balance = $income - $outcome;
        $transactions = Transaction::latest()->take(5)->get();

        return view('dashboard', compact(
            'transactions', 'balance', 'rataRata', 
            'income', 'outcome', 'labels', 
            'dataOut', 'dataIn', 'filter', 'date'
        ));
    }

    public function getChartDataApi(Request $request)
    {
        $filter = $request->input('filter', 'bulan');
        $selectedDate = $request->input('date', now()->format('Y-m-d'));
        $date = Carbon::parse($selectedDate);

        list($labels, $dataOut, $dataIn) = $this->getChartData($filter, $date);

        return response()->json([
            'labels' => $labels,
            'dataOut' => $dataOut,
            'dataIn' => $dataIn,
            'income' => Transaction::where('type', 'in')->sum('amount'),
            'outcome' => Transaction::where('type', 'out')->sum('amount'),
            'balance' => Transaction::where('type', 'in')->sum('amount') - Transaction::where('type', 'out')->sum('amount')
        ]);
    }

    private function getChartData($filter, Carbon $date)
    {
        $queryOut = Transaction::where('type', 'out');
        $queryIn = Transaction::where('type', 'in');

        $labels = [];
        $dataOut = [];
        $dataIn = [];

        switch ($filter) {
            case 'tahun':
                // Query outcome
                $transactionsOut = $queryOut->select(
                        DB::raw('YEAR(transaction_date) as year'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->groupBy('year')
                    ->orderBy('year')
                    ->get();
                
                // Query income
                $transactionsIn = $queryIn->select(
                        DB::raw('YEAR(transaction_date) as year'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->groupBy('year')
                    ->orderBy('year')
                    ->get();
                
                $labels = $transactionsOut->pluck('year')->toArray();
                $dataOut = $transactionsOut->pluck('total')->toArray();
                $dataIn = $transactionsIn->pluck('total')->toArray();
                break;

            case 'bulan':
                // Query outcome
                $transactionsOut = $queryOut->select(
                        DB::raw('YEAR(transaction_date) as year'),
                        DB::raw('MONTH(transaction_date) as month'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->whereYear('transaction_date', $date->year)
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get();
                
                // Query income
                $transactionsIn = $queryIn->select(
                        DB::raw('YEAR(transaction_date) as year'),
                        DB::raw('MONTH(transaction_date) as month'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->whereYear('transaction_date', $date->year)
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get();
                
                $labels = $transactionsOut->map(function($item) {
                    return Carbon::create($item->year, $item->month)->translatedFormat('F Y');
                })->toArray();
                
                $dataOut = $transactionsOut->pluck('total')->toArray();
                $dataIn = $transactionsIn->pluck('total')->toArray();
                break;

            case 'minggu':
                // Ambil semua minggu di bulan ini
                $startOfMonth = $date->copy()->startOfMonth();
                $endOfMonth = $date->copy()->endOfMonth();
                
                // Query outcome per minggu
                $transactionsOut = $queryOut->select(
                        DB::raw('WEEK(transaction_date, 1) - WEEK(DATE_SUB(transaction_date, INTERVAL DAYOFMONTH(transaction_date)-1 DAY), 1) + 1 as week_of_month'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                    ->groupBy('week_of_month')
                    ->orderBy('week_of_month')
                    ->get();
                
                // Query income per minggu
                $transactionsIn = $queryIn->select(
                        DB::raw('WEEK(transaction_date, 1) - WEEK(DATE_SUB(transaction_date, INTERVAL DAYOFMONTH(transaction_date)-1 DAY), 1) + 1 as week_of_month'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                    ->groupBy('week_of_month')
                    ->orderBy('week_of_month')
                    ->get();
                
                // Generate labels (Minggu 1, Minggu 2, dst)
                $totalWeeks = ceil($date->daysInMonth / 7);
                for ($i = 1; $i <= $totalWeeks; $i++) {
                    $labels[] = 'Minggu ' . $i;
                    $dataOut[$i-1] = 0;
                    $dataIn[$i-1] = 0;
                }
                
                // Isi data
                foreach ($transactionsOut as $transaction) {
                    $index = $transaction->week_of_month - 1;
                    if (isset($dataOut[$index])) {
                        $dataOut[$index] = $transaction->total;
                    }
                }
                
                foreach ($transactionsIn as $transaction) {
                    $index = $transaction->week_of_month - 1;
                    if (isset($dataIn[$index])) {
                        $dataIn[$index] = $transaction->total;
                    }
                }
                break;

            case 'hari':
                // Ambil hari dalam minggu ini
                $startOfWeek = $date->copy()->startOfWeek(); // Minggu
                $endOfWeek = $date->copy()->endOfWeek();    // Sabtu
                
                // Query outcome per hari
                $transactionsOut = $queryOut->select(
                        DB::raw('DAYOFWEEK(transaction_date) as day_of_week'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->whereBetween('transaction_date', [$startOfWeek, $endOfWeek])
                    ->groupBy('day_of_week')
                    ->orderBy('day_of_week')
                    ->get();
                
                // Query income per hari
                $transactionsIn = $queryIn->select(
                        DB::raw('DAYOFWEEK(transaction_date) as day_of_week'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->whereBetween('transaction_date', [$startOfWeek, $endOfWeek])
                    ->groupBy('day_of_week')
                    ->orderBy('day_of_week')
                    ->get();
                
                // Generate labels (Minggu-Sabtu)
                $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                $labels = $dayNames;
                $dataOut = array_fill(0, 7, 0);
                $dataIn = array_fill(0, 7, 0);
                
                // Isi data
                foreach ($transactionsOut as $transaction) {
                    $index = $transaction->day_of_week - 1;
                    if (isset($dataOut[$index])) {
                        $dataOut[$index] = $transaction->total;
                    }
                }
                
                foreach ($transactionsIn as $transaction) {
                    $index = $transaction->day_of_week - 1;
                    if (isset($dataIn[$index])) {
                        $dataIn[$index] = $transaction->total;
                    }
                }
                break;
        }

        return [$labels, $dataOut, $dataIn];
    }




}