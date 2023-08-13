<?php

namespace App\Http\Controllers;

use App\Imports\SampleImport;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home');
    }

    public function import_excel(): View
    {
        return view('import_excel');
    }

    public function import_run(Request $request)
    {
        $rows = Excel::toCollection(new SampleImport, $request->file('file_excel'));

        $data = $rows->flatten(1);
        //$data2 = $data->values()->all();

        //return response();

        //dd($data->values()->all());
        $vendor = $data->pluck('vendor')->unique();
        $po_no = $data->pluck('po_no')->unique();
        $order_date = $data->pluck('order_date')->unique();
        //$vendor = $plucked->unique();

        //dd($vendor);

        return view('import_result', ['rows' => $data, 'vendor' => $vendor, 'po_no' => $po_no, 'order_date' => $order_date]);
    }
}
