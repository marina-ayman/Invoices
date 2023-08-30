<?php

namespace App\Http\Controllers;

use App\Http\Requests\invocesRequest;
use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\products;
use App\Models\section;
use App\Models\User;
use App\Notifications\add_invoice_new;
use App\Notifications\addInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;



class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
        $invoices_details = invoices_details::all();
        $invoices_attachments = invoices_attachments::all();
        return view('invoices.invoices', compact('invoices', 'invoices_details', 'invoices_attachments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = section::all();
        $products = products::all();
        return view('invoices.add_invoices', compact('sections', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validateData = $request->validate([

            'invoice_number' => 'required',
            'invoice_Date' => 'required',
            'Due_date' => 'required',
            'product' => 'required',
            'section_id' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'required',
            'Value_VAT' => 'required',
            'Rate_VAT' => 'required',
            'Total' => 'required',
            'Status' => 'required',
            'Value_Status' => 'required',
        ], [
            'invoice_number.required' => 'رقم الفاتوره مطلوب',
            'invoice_Date.required' => 'تاريخ الفاتوره مطلوب',
            'Due_date.required' => 'تاريخ الاستحقاق مطلوب',
            'product.required' => ' اسم المنتج مطلوب',
            'section_id.required' => 'القسم مطلوب',
            'Amount_collection.required' => 'مبلغ التحصيل مطلوب',
            'Amount_Commission.required' => 'مبلغ العموله  مطلوب',
            'Discount.required' => 'الخصم مطلوب',
            'Value_VAT.required' => '  قممة ضريبة القيمة المضافة مطلوب',
            'Rate_VAT.required' => 'نسبة ضريبة القيمة المضافة مطلوب',
            'Total.required' => ' الاجمالي شامل الضريبة مطلوب',
            'Status.required' => 'حالة الفاتوره  مطلوب',
            'Value_Status.required' => 'قيمة حالة الفاتوره مطلوب',

        ]);


        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->section_id,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => $request->Status,
            'Value_Status' => $request->Value_Status,
            'note' => $request->note,
        ]);
        $invoice_id = invoices::latest()->first()->id;

        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->section_id,
            'Status' => $request->Status,
            'Value_Status' => $request->Value_Status,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {


            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        //  to mail or mail trap 
        // $user = User::find();
        // $invoices_id = invoices::latest()->first();
        // Notification::send($user, new addInvoice($invoices_id));

//in main header
        $invoice = invoices::latest()->first();
        $user = User::get();
        Notification::send($user, new add_invoice_new($invoice));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return redirect('/invoices');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = section::all();
        return view('invoices.edit_invoices', compact('sections', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);

        // $validateData = $request->validate([

        //     'invoice_number' => 'required',
        //     'invoice_Date' => 'required',
        //     'Due_date' => 'required',
        //     'product' => 'required',
        //     'section_id' => 'required',
        //     'Amount_collection' => 'required',
        //     'Amount_Commission' => 'required',
        //     'Discount' => 'required',
        //     'Value_VAT' => 'required',
        //     'Rate_VAT' => 'required',
        //     'Total' => 'required',
        //     'Status' => 'required',
        //     'Value_Status' => 'required',
        // ], [
        //     'invoice_number.required' => 'رقم الفاتوره مطلوب',
        //     'invoice_Date.required' => 'تاريخ الفاتوره مطلوب',
        //     'Due_date.required' => 'تاريخ الاستحقاق مطلوب',
        //     'product.required' => ' اسم المنتج مطلوب',
        //     'section_id.required' => 'القسم مطلوب',
        //     'Amount_collection.required' => 'مبلغ التحصيل مطلوب',
        //     'Amount_Commission.required' => 'مبلغ العموله  مطلوب',
        //     'Discount.required' => 'الخصم مطلوب',
        //     'Value_VAT.required' => '  قممة ضريبة القيمة المضافة مطلوب',
        //     'Rate_VAT.required' => 'نسبة ضريبة القيمة المضافة مطلوب',
        //     'Total.required' => ' الاجمالي شامل الضريبة مطلوب',
        //     'Status.required' => 'حالة الفاتوره  مطلوب',
        //     'Value_Status.required' => 'قيمة حالة الفاتوره مطلوب',

        // ]);

        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $invoices = invoices::findOrFail($request->id);
        //    foriegnKeyهو كده مسحه بالجداول الي معاه ب 
        $Details = invoices_attachments::where('invoice_id', $request->id)->first();
        //لاكن هنا همسح الصوره بالفولدر الي نزل عندي في البروجكت )(server)


        if ($request->page_id == 2) {

            $invoices->Delete();  //هيمسحها لاكن هتكون موجوده ف الداتا بيز
            session()->flash('Archive_invoices');
        } else {

            if (!empty($Details->invoice_number)) {

                Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
            }


            $invoices->forceDelete(); //مينفعش ارجعها dbهيمسح الداتا من ال 
            // $invoices->Delete();  هيمسحها لاكن هتكون موجوده ف الداتا بيز
            session()->flash('delete_invoices');
        }
        return redirect('/invoices');
    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    public function Status_show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_invoice', compact('invoices'));
    }


    public function Status_Update(Request $request, $id)
    {
        $status_invoice = invoices::where('id', $request->id)->first();



        if ($request->Status == 'مدفوعة') {
            $status_invoice->update([
                'payment_Date' => $request->payment_Date,
                'Status' => $request->Status,
                'Value_Status' => 1
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        } elseif ($request->Status == 'مدفوعة جزئيا') {
            $status_invoice->update([
                'payment_Date' => $request->payment_Date,
                'Status' => $request->Status,
                'Value_Status' =>  3
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }



    public function invoice_paid()
    {

        $invoices = invoices::where('Value_Status', "=", 1)->get();

        return view('invoices.invoice_paid', compact('invoices'));
    }


    public function invoice_unpaid()
    {
        $invoices = invoices::where('Value_Status', "=", 2)->get();

        return view('invoices.invoice_unpaid', compact('invoices'));
    }


    public function invoice_partial()
    {
        $invoices = invoices::where('Value_Status', "=", 3)->get();

        return view('invoices.invoice_partial', compact('invoices'));
    }


    public function Print_invoice($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.Print_invoices', compact('invoices'));
    }




    public function MarkAsRead_all(Request $request)
    {

        $userUnreadNotification = auth()->user()->unreadNotifications;

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }
    }


    public function unreadNotifications_count()

    {
        return auth()->user()->unreadNotifications->count();
    }

    public function unreadNotifications()

    {
        foreach (auth()->user()->unreadNotifications as $notification) {

            return $notification->data['title'];
        }
    }
}
