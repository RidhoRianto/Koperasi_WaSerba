<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Income;
use App\Models\Saldo;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $sortField = $request->query('field', 'date');
        $sortDirection = $request->query('sort', 'asc') == 'asc' ? 'asc' : 'desc';

        $validSortFields = ['date', 'amount'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'date';
        }

        $incomes = Income::where('user_id', $user->id)
            ->orderBy($sortField, $sortDirection)
            ->paginate(5);

        $totalIncome = Income::where('user_id', $user->id)->sum('amount');

        $title = 'Delete Data!';
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        // Logika untuk Diagram Bulanan
        $currentYear = Carbon::now()->year;
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::createFromDate($currentYear, $i, 1)->format('F Y');
        }

        // Ambil data pemasukan manual
        $manualIncomeData = Income::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->get()
            ->groupBy(function ($income) {
                return Carbon::parse($income->date)->format('F Y');
            })
            ->map(function ($groupedIncomes) {
                return $groupedIncomes->sum('amount');
            });

        // Ambil data total penjualan kasir
        $kasirIncomeData = Transaksi::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as total_amount')
        )
        ->whereYear('created_at', $currentYear)
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get()
        ->mapWithKeys(function ($item) {
            $monthYear = Carbon::createFromDate($item->year, $item->month, 1)->format('F Y');
            return [$monthYear => $item->total_amount];
        });

        // Gabungkan kedua data pemasukan (manual dan kasir)
        $combinedKeys = array_unique(array_merge($manualIncomeData->keys()->all(), $kasirIncomeData->keys()->all()));
        $combinedIncomeData = collect();
        foreach ($combinedKeys as $key) {
            $manualAmount = $manualIncomeData->get($key, 0);
            $kasirAmount = $kasirIncomeData->get($key, 0);
            $combinedIncomeData->put($key, $manualAmount + $kasirAmount);
        }

        // Isi data diagram untuk semua bulan
        $chartData = [];
        foreach ($months as $month) {
            $chartData[] = $combinedIncomeData->get($month, 0);
        }

        $incomeDataForChart = collect($chartData);

        return view('income.index', compact('incomes', 'totalIncome', 'incomeDataForChart', 'sortField', 'sortDirection', "months"));
    }
    
    public function create()
    {
        return view('income.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $income = new Income();
        $income->user_id = auth()->id();
        $income->date = $request->input('date');
        $income->category = $request->input('category');
        $income->amount = $request->input('amount');
        $income->description = $request->input('description');
        $income->save();

        // Tambahkan ke saldo
        $saldo = Saldo::first();
        if ($saldo) {
            $saldo->jumlah += $income->amount;
            $saldo->save();
        }

        alert()->success('Berhasil!', 'Data Berhasil Ditambah');
        return redirect()->route('index.income');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $income = Income::findOrFail($id);
        return view('income.edit', compact('income'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $income = Income::findOrFail($id);

        // Hitung selisih
        $oldAmount = $income->amount;
        $newAmount = $request->amount;
        $difference = $newAmount - $oldAmount;

        // Update income
        $income->date = $request->date;
        $income->category = $request->category;
        $income->amount = $newAmount;
        $income->description = $request->description;
        $income->save();

        // Update saldo (jika selisih != 0)
        if ($difference != 0) {
            $saldo = Saldo::first();
            if ($saldo) {
                $saldo->jumlah += $difference;
                $saldo->save();
            }
        }

        alert()->success('Berhasil!', 'Data Berhasil Diperbarui');
        return redirect()->route('index.income');
    }

    public function destroy(string $id)
    {
        $income = Income::findOrFail($id);

        // Hapus income tanpa mengurangi saldo
        $income->delete();

        alert()->success('Berhasil', 'Data Berhasil Dihapus');
        return redirect()->route('index.income');
    }

    public function dailyIncomeChart(Request $request)
    {
        $userId = auth()->id();
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $dailyIncomes = DB::table('incomes')
            ->select(DB::raw('DATE(date) as date'), DB::raw('SUM(amount) as total_amount'))
            ->where('user_id', $userId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = $dailyIncomes->pluck('date');
        $amounts = $dailyIncomes->pluck('total_amount');

        return view('daily_chart', compact('dates', 'amounts', 'month', 'year'));
    }
}