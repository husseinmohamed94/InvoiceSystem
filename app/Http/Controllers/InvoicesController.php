<?php

namespace App\Http\Controllers;

use App\invoice_attachments;
use App\invoices;
use App\invoices_details;
use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    return view('invoices.invoices');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections =sections::all();
        return view('invoices.create',compact('sections'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        invoices::create([
           'invoice_number'             => $request->invoice_number,
           'invoice_Date'               => $request->invoice_Date,
           'Due_date'                   => $request->Due_date,
           'product'                    => $request->product,
           'section_id'                 => $request->Section,
           'Amount_collection'          => $request->Amount_collection,
           'Amount_Commission'          => $request->Amount_Commission,
           'Discount'                   => $request->Discount,
           'Value_VAT'                  => $request->Value_VAT,
           'Rate_VAT'                   => $request->Rate_VAT,
           'Total'                      => $request->Total,
           'Status'                     => 'غير مدفوع',
           'Value_Status'               =>  2,
           'note'                       => $request->note,

        ]);


            $invoice_id = invoices::latest()->first()->id;
            invoices_details::create([

                'id_Invoices'           => $invoice_id,
                'invoice_number'        => $request->invoice_number,
                'Product'               => $request->product,
                'Section'               => $request->Section,
                'Status'               => 'غير مدفوع',
              'Value_Status'           =>  2,
                'note'                => $request->note,
                'user'                => (Auth::user()->name),
            ]);

            if($request->hasFile('pic')){
                //$this->validate($request,['pic'=>'required|mimes:pdf|max:1000'],['pic.mimes'=>'تم حفظ :خطالم يتم حفظ الفاتوره لابد ان يكون المرفق pdf']);
                $invoice_id = invoices::latest()->first()->id;
                $image =$request->file('pic');
                $file_name = $image->getClientOriginalName();
                $invoice_number= $request->invoice_number;

                $attachments =new invoice_attachments();
                $attachments->file_name =$file_name;
                $attachments->invoice_number =$invoice_number;
                $attachments->created_by = Auth::user()->name;
                $attachments->invoice_id = $invoice_id;
                $attachments->save();
                $imageName = $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachments/'.$invoice_number).$imageName);
            }



        session()->flash('Add','تم الحفظ بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices $invoices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices $invoices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices $invoices)
    {
        //
    }

    public  function getprouducts($id){
        $prouducts = DB::table('products')->where('section_id',$id)->pluck("product_name","id");
        return json_encode($prouducts);
    }
}
