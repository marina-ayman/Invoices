<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices as ModelsInvoices;
use App\Models\section;
use Illuminate\Http\Request;

class Customers_ReportController extends Controller
{
    public function index()
    {
        $sections = section::all();
        return view('reports.costum_reports', compact('sections'));
    }


    public function Search_customers(Request $request)
    {
        if ($request->Section && $request->product && $request->start_at == '' && $request->end_at == '') {
            if ($request->product == 'all') {
                $invoices = invoices::select('*')->where('section_id', '=', $request->Section)->get();
                $sections = section::all();
                return view('reports.costum_reports', compact('sections'))->withDetails($invoices);
            } else {
                $invoices = invoices::select('*')->where('section_id', '=', $request->Section)->where('product', '=', $request->product)->get();
                $sections = section::all();
                return view('reports.costum_reports', compact('sections'))->withDetails($invoices);
            }
        } else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            if ($request->product == 'all') {
                $invoices = invoices::select('*')->whereBetween('invoice_Date', [$start_at, $end_at])
                ->where('section_id', '=', $request->Section)->get();
                $sections = section::all();

                return view('reports.costum_reports', compact('sections'))->withDetails($invoices);
            }else{
                $invoices = invoices::select('*')->whereBetween('invoice_Date', [$start_at, $end_at])
                ->where('section_id', '=', $request->Section)
                ->where('product', '=', $request->product)->get();
                
                $sections = section::all();
                return view('reports.costum_reports', compact('sections'))->withDetails($invoices);
            }
           
        }
    }
}
