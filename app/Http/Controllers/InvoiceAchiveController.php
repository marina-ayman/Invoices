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
        $invoices = invoices::withTrashed()->where('id', $id)->first();
        $invoices->forceDelete();

        session()->flash('delete_invoice');
        return redirect('/Arctive_Invoices');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $invoices = invoices::withTrashed()->where('id', $id)->first();
        $invoices->update([
            'deleted_at' => null,

        ]);
      
        session()->flash('archive_invoice');
        return redirect('/Arctive_Invoices');
    }
}
