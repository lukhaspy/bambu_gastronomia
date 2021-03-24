<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Inventory;

use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\PaymentMethod;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $monthlyBalanceByMethod = $this->getMethodBalance()->get('monthlyBalanceByMethod');
        $monthlyBalance = $this->getMethodBalance()->get('monthlyBalance');

        $anualsales = $this->getAnnualSales();
        $anualclients = $this->getAnnualClients();
        $anualinventories = $this->getAnnualInventories();

        return view('dashboard', [
            'monthlybalance'            => $monthlyBalance,
            'monthlybalancebymethod'    => $monthlyBalanceByMethod,
            'lasttransactions'          => Transaction::latest()->limit(20)->get(),
            'unfinishedsales'           => Sale::where('finalized_at', null)->get(),
            'anualsales'                => $anualsales,
            'anualclients'              => $anualclients,
            'anualinventories'              => $anualinventories,

            'lastmonths'                => array_reverse($this->getMonthlyTransactions()->get('lastmonths')),
            'lastincomes'               => $this->getMonthlyTransactions()->get('lastincomes'),
            'lastexpenses'              => $this->getMonthlyTransactions()->get('lastexpenses'),
            'semesterexpenses'          => $this->getMonthlyTransactions()->get('semesterexpenses'),
            'semesterincomes'           => $this->getMonthlyTransactions()->get('semesterincomes'),
            'lastinventory'             => $this->getMonthlyTransactions()->get('lastinventory')
        ]);
    }

    public function getMethodBalance()
    {
        $methods = PaymentMethod::all();
        $monthlyBalanceByMethod = [];
        $monthlyBalance = 0;

        foreach ($methods as $method) {
            $balance = Transaction::findByPaymentMethodId($method->id)->thisMonth()->sum('amount');
            $monthlyBalance += (float) $balance;
            $monthlyBalanceByMethod[$method->name] = $balance;
        }
        return collect(compact('monthlyBalanceByMethod', 'monthlyBalance'));
    }

    public function getAnnualSales()
    {
        $sales = [];
        foreach (range(1, 12) as $i) {
            $monthlySalesCount = Sale::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->count();

            array_push($sales, $monthlySalesCount);
        }
        return "[" . implode(',', $sales) . "]";
    }

    public function getAnnualClients()
    {
        $clients = [];
        foreach (range(1, 12) as $i) {
            $monthclients = Sale::selectRaw('count(distinct client_id) as total')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $i)
                ->first();

            array_push($clients, $monthclients->total);
        }
        return "[" . implode(',', $clients) . "]";
    }

    public function getAnnualInventories()
    {
        $inventories = [];
        foreach (range(1, 12) as $i) {
            $monthinventories = Inventory::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->count();

            array_push($inventories, $monthinventories);
        }


        return "[" . implode(',', $inventories) . "]";
    }

    public function getMonthlyTransactions()
    {
        $actualmonth = Carbon::now();

        $lastmonths = [];
        $lastincomes = '';
        $lastexpenses = '';
        $semesterincomes = 0;
        $semesterexpenses = 0;

        $lastinventory = [];
        foreach (range(1, 6) as $i) {
            array_push($lastmonths, $actualmonth->shortMonthName);

            $incomes = Transaction::where('type', 'income')
                ->whereYear('created_at', $actualmonth->year)
                ->WhereMonth('created_at', $actualmonth->month)
                ->sum('amount');

            $semesterincomes += $incomes;
            $lastincomes = round($incomes) . ',' . $lastincomes;

            $expenses = abs(Transaction::whereIn('type', ['expense', 'payment'])
                ->whereYear('created_at', $actualmonth->year)
                ->WhereMonth('created_at', $actualmonth->month)
                ->sum('amount'));

            $semesterexpenses += $expenses;
            $lastexpenses = round($expenses) . ',' . $lastexpenses;


            $inventory =  Inventory::with(['details' => function ($q) {
                $q->selectRaw('
                inventory_id,
               if(new_quantity > old_quantity,
               min_cost * (new_quantity - old_quantity),
               min_cost * (old_quantity - new_quantity) * -1)   as sumMin,
    
               if(new_quantity > old_quantity,
               max_cost * (new_quantity - old_quantity),
               max_cost * (old_quantity - new_quantity) * -1)   as sumMax,
    
               if(new_quantity > old_quantity,
               avg_cost * (new_quantity - old_quantity),
               avg_cost * (old_quantity - new_quantity) * -1)   as sumAvg
                ');
            }])->orderBy('id', 'desc')->latest()->first();

            if ($inventory) {
                $lastinventory['id'] = $inventory->id;
                $lastinventory['min'] = $inventory->details->sum('sumMin');
                $lastinventory['avg'] = $inventory->details->sum('sumAvg');
                $lastinventory['max'] = $inventory->details->sum('sumMax');
            } else {
                $lastinventory['id'] = 0;
                $lastinventory['min'] = 0;
                $lastinventory['avg'] = 0;
                $lastinventory['max'] = 0;
            }

            $actualmonth->subMonth(1);
        }

        $lastincomes = '[' . $lastincomes . ']';
        $lastexpenses = '[' . $lastexpenses . ']';

        return collect(compact('lastmonths', 'lastincomes', 'lastexpenses', 'semesterincomes', 'semesterexpenses', 'lastinventory'));
    }
}
