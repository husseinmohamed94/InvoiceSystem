<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Notifications\Add_invoice_new;
use Illuminate\Support\Facades\Notification;
use App\invoice_attachments;
use App\invoices;
use App\invoices_details;
use App\Notifications\AddInvoice;
use App\sections;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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

    return view('invoices.invoices',compact('invoices'));
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
              //  $this->validate($request,['pic'=>'required|'mimes:pdf|max:1000],['pic.mimes'=>'تم حفظ :خطالم يتم حفظ الفاتوره لابد ان يكون المرفق pdf']);



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
                $request->pic->move(public_path('Attachments/'.$invoice_number),$imageName);
            }

       // $user->notify(new AddInvoice($invoice_id));

    //    $user = User::first();
       //  Notification::send($user, new AddInvoice($invoice_id));
        $user = User::get();

        $invoices = invoices::latest()->first();

      //  $user->notify(new Add_invoice_new($invoices));
         Notification::send($user, new Add_invoice_new($invoices));



        session()->flash('Add');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::where('id',$id)->first();
        $sections= sections::all();
        return view('invoices.status_update',compact('sections','invoices'));
    }

    public  function  status_update(Request $request,$id){

        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoices' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoices' => $request->invoice_id,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, invoices $invoices,$id)
    {
        $invoices = invoices::where('id',$id)->first();
        $sections= sections::all();
        return view('invoices.edit_invoice',compact('sections','invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoices = invoices::findOrFail($request->invoice_id);


        $invoices->update([
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

        session()->flash('edit');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request, $id )
    {
        $id =   $request->invoice_id;
        $invvoices = invoices::where('id',$id)->first();
        $Datails = invoice_attachments::where('invoice_id',$id)->first();
        $id_page = $request->id_page;

        if (!$id_page == 2 ) {
            if (!empty($Datails->invoice_number)){
                Storage::disk('public_uploads')->deleteDirectory($Datails->invoice_number);
                //Storage::disk('public_uploads')->delete($Datails->invoice_number.'/'.$Datails->file_name);
            }
            $invvoices->forceDelete();
            session()->flash('delete');
            return redirect('/invoices');



        }else{
            $invvoices->delete();
            session()->flash('delete');
            return redirect('/invoices');
        }

    }

    public  function getprouducts($id){
        $prouducts = DB::table('products')->where('section_id',$id)->pluck("product_name","id");
        return json_encode($prouducts);
    }

    public  function invoices_paid( Request $request){


        $invoices = invoices::where('Value_Status',1)->get();

        return view('invoices.invoices_paid',compact('invoices'));
    }
    public function invoices_Unpaid(){
        $invoices = invoices::where('Value_Status',2)->get();

        return view('invoices.invoices_Unpaid',compact('invoices'));

    }
    public function invoices_Partial(){
        $invoices = invoices::where('Value_Status',3)->get();

        return view('invoices.invoices_Partial',compact('invoices'));

    }

    public function print_invoice($id ){

        $invoices = invoices::where('id',$id)->first();
        return view('invoices.print_invoice',compact('invoices'));
    }

    public function export()
    {

        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }


    public function MarkAsRead_all(Request $request){
        $userUnreadNotifcation = auth()->user()->unreadNotifications;

        if ($userUnreadNotifcation){
            $userUnreadNotifcation->markAsRead();
            return back();
        }
    }

}
