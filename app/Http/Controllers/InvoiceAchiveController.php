<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class InvoiceAchiveController extends Controller
{
    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();

        return view('invoices.Arctive_Invoices', compact('invoices'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($request->page_id == 1) {
       
          $invoices = invoices::withTrashed()->where('id', $id)->first();
          $invoices->forceDelete();

         session()->flash('delete_invoice');
        }

        elseif($request->page_id == 2){
   
            $invoices = invoices::withTrashed()->where('id', $id)->first()->restore();
       
        // dd( $invoices);
            session()->flash('archive_invoice');
         
        }
    

    return redirect('/Arctive_Invoices');
} }
