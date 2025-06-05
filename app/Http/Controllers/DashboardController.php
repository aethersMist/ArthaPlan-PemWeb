<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        $request = request(); 
        $filter = $request->input('filter', 'bulan');
        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        // Set default ke 1 Juni jika tidak ada parameter date
        if (!$request->has('date')) {
            $selectedDate = now()->format('Y-m-d');
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
        $transactions = Transaction::latest()->take(3)->get();

            $currentDate = now()->translatedFormat('l, d F Y');

        // Anggaran
        $anggaran = Budget::sum('amount');

        $persenSisa = $anggaran > 0 ? round((($anggaran - $outcome) / $anggaran) * 100) : 100;
        $persenPakai = 100 - $persenSisa;

        // Laporan
        $incomeByCategory = DB::table('transactions')
        ->select('category', DB::raw('SUM(amount) as total'))
        ->where('type', 'in')
        ->groupBy('category')
        ->get();

// Pisah label dan data buat chart
$categories = $incomeByCategory->pluck('category')->toArray();
$values = $incomeByCategory->pluck('total')->toArray();

        return view('dashboard', compact(
            'transactions', 'balance', 'rataRata',
            'income', 'outcome', 'labels',
            'dataOut', 'dataIn', 'filter', 'date', 'currentDate', 'persenSisa', 'persenPakai','categories', 'values'
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
                // Get data for current year and previous 4 years
                $startYear = $currentYear = now()->year - 4;
                $endYear = $currentYear = now()->year;

                // Generate labels for all years in range
                for ($year = $startYear; $year <= $endYear; $year++) {
                    $labels[] = $year;
                    $dataOut[] = 0;
                    $dataIn[] = 0;
                }

                // Query outcome
                $transactionsOut = $queryOut->select(
                        DB::raw('YEAR(transaction_date) as year'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->whereBetween('transaction_date', [
                        Carbon::create($startYear, 1, 1)->startOfYear(),
                        Carbon::create($endYear, 12, 31)->endOfYear()
                    ])
                    ->groupBy('year')
                    ->orderBy('year')
                    ->get();

                // Query income
                $transactionsIn = $queryIn->select(
                        DB::raw('YEAR(transaction_date) as year'),
                        DB::raw('SUM(amount) as total')
                    )
                    ->whereBetween('transaction_date', [
                        Carbon::create($startYear, 1, 1)->startOfYear(),
                        Carbon::create($endYear, 12, 31)->endOfYear()
                    ])
                    ->groupBy('year')
                    ->orderBy('year')
                    ->get();

                // Fill data
                foreach ($transactionsOut as $transaction) {
                    $index = array_search($transaction->year, $labels);
                    if ($index !== false) {
                        $dataOut[$index] = $transaction->total;
                    }
                }

                foreach ($transactionsIn as $transaction) {
                    $index = array_search($transaction->year, $labels);
                    if ($index !== false) {
                        $dataIn[$index] = $transaction->total;
                    }
                }
                break;

                case 'bulan':
    // Get current year
    $currentYear = now()->year;

    // Query outcome for current year
    $transactionsOut = $queryOut->select(
            DB::raw('MONTH(transaction_date) as month'),
            DB::raw('SUM(amount) as total')
        )
        ->whereYear('transaction_date', $currentYear)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Query income for current year
    $transactionsIn = $queryIn->select(
            DB::raw('MONTH(transaction_date) as month'),
            DB::raw('SUM(amount) as total')
        )
        ->whereYear('transaction_date', $currentYear)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Create labels for all months in current year
    $labels = [];
    $dataOut = array_fill(0, 12, 0);
    $dataIn = array_fill(0, 12, 0);

    for ($month = 1; $month <= 12; $month++) {
        $labels[] = Carbon::create($currentYear, $month, 1)->translatedFormat('F');
    }

    // Fill data
    foreach ($transactionsOut as $transaction) {
        $index = $transaction->month - 1;
        if (isset($dataOut[$index])) {
            $dataOut[$index] = $transaction->total;
        }
    }

    foreach ($transactionsIn as $transaction) {
        $index = $transaction->month - 1;
        if (isset($dataIn[$index])) {
            $dataIn[$index] = $transaction->total;
        }
    }
    break;

            case 'minggu':
                // Get current week data (week of month)
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();

            $transactionsOut = $queryOut->select(
                    DB::raw('WEEK(transaction_date, 1) - WEEK(DATE_SUB(transaction_date, INTERVAL DAYOFMONTH(transaction_date)-1 DAY), 1) + 1 as week_of_month'),
                    DB::raw('SUM(amount) as total')
                )
                ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                ->groupBy('week_of_month')
                ->orderBy('week_of_month')
                ->get();

            $transactionsIn = $queryIn->select(
                    DB::raw('WEEK(transaction_date, 1) - WEEK(DATE_SUB(transaction_date, INTERVAL DAYOFMONTH(transaction_date)-1 DAY), 1) + 1 as week_of_month'),
                    DB::raw('SUM(amount) as total')
                )
                ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                ->groupBy('week_of_month')
                ->orderBy('week_of_month')
                ->get();

            // Generate labels for all weeks in current month
            $totalWeeks = ceil(now()->daysInMonth / 7);
            for ($i = 1; $i <= $totalWeeks; $i++) {
                $labels[] = 'Minggu ' . $i;
                $dataOut[$i-1] = 0;
                $dataIn[$i-1] = 0;
            }

            // Fill data
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
                // Get current week days data
            $startOfWeek = now()->startOfWeek(); // Sunday
            $endOfWeek = now()->endOfWeek();   // Saturday

            $transactionsOut = $queryOut->select(
                    DB::raw('DAYOFWEEK(transaction_date) as day_of_week'),
                    DB::raw('SUM(amount) as total')
                )
                ->whereBetween('transaction_date', [$startOfWeek, $endOfWeek])
                ->groupBy('day_of_week')
                ->orderBy('day_of_week')
                ->get();

            $transactionsIn = $queryIn->select(
                    DB::raw('DAYOFWEEK(transaction_date) as day_of_week'),
                    DB::raw('SUM(amount) as total')
                )
                ->whereBetween('transaction_date', [$startOfWeek, $endOfWeek])
                ->groupBy('day_of_week')
                ->orderBy('day_of_week')
                ->get();

            // Generate labels for all days in current week
            $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $labels = $dayNames;
            $dataOut = array_fill(0, 7, 0);
            $dataIn = array_fill(0, 7, 0);

            // Fill data
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
