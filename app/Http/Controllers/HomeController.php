<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Income;
use App\Models\expense;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BillReminderNotification;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Total
        $totalIncome = Income::where('user_id', $user->id)->sum('amount');
        $totalExpense = Expense::where('user_id', $user->id)->sum('amount');
        $jumlahAnggota = Anggota::count();
        $jumlahBarang = Item::count();

        // Tentukan rentang bulan (misalnya 12 bulan terakhir)
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $period = CarbonPeriod::create($start, '1 month', $end);

        // Buat label bulan yang lengkap
        $months = [];
        foreach ($period as $date) {
            $months[] = $date->format('F Y');
        }

        // Fungsi untuk mengisi data berdasarkan bulan
        $fillData = function ($data, $months) {
            $result = [];
            foreach ($months as $month) {
                $result[$month] = $data->get($month, 0);
            }
            return $result;
        };

        // Income
        $incomes = Income::where('user_id', $user->id)->get();
        $incomeData = $incomes->groupBy(function ($income) {
            return Carbon::parse($income->date)->format('F Y');
        })->map(function ($groupedIncomes) {
            return $groupedIncomes->sum('amount');
        });
        $incomeData = $fillData($incomeData, $months);

        // Expense
        $expenses = Expense::where('user_id', $user->id)->get();
        $expenseData = $expenses->groupBy(function ($expense) {
            return Carbon::parse($expense->date)->format('F Y');
        })->map(function ($groupedExpenses) {
            return $groupedExpenses->sum('amount');
        });
        $expenseData = $fillData($expenseData, $months);

        //saldo
        $saldo = \App\Models\Saldo::first();

        return view('home', compact('saldo','totalIncome', 'totalExpense', 'incomeData', 'expenseData', 'months', 'jumlahAnggota','jumlahBarang'));
    }
}
