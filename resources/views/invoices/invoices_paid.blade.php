@extends('layouts.master')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection

@section('title')
 الفواتيرالمدفوعة
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">

    </div>

</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if(session()->has('delete'))
<script>
    window.onload = function (){
        notif({
            msg: "تم الحذف بنجاح",
            type: 'success'
        })
    }
</script>

@endif


@if(session()->has('Status_Update'))
<script>
    window.onload = function (){
        notif({
            msg: "تم التحديث بنجاح",
            type: 'success'
        })
    }
</script>

@endif
<!-- row -->
<div class="row">



    <!--div-->
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <a class=" btn btn-primary btn-sm" S href="invoices/create"><i class="fa fa-plus"></i>اضافة فاتورة</a>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">رقم الفاتوره</th>
                            <th class="border-bottom-0">تاريخ الفاتوره</th>
                            <th class="border-bottom-0">تاريخ الاستحقاق</th>
                            <th class="border-bottom-0">المنتج </th>
                            <th class="border-bottom-0">القسم</th>
                            <th class="border-bottom-0">الخصم</th>
                            <th class="border-bottom-0">نسبة الضريبة </th>
                            <th class="border-bottom-0">  قيمة الضريبة </th>
                            <th class="border-bottom-0"> الاجمالي </th>
                            <th class="border-bottom-0">الحالة  </th>
                            <th class="border-bottom-0">ملاحظات  </th>
                            <th class="border-bottom-0">العمليات  </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i=0 @endphp
                        @foreach($invoices as $invoice)
                        @php $i++ @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$invoice->invoice_number}}</td>
                            <td>{{$invoice->invoice_Date}}</td>
                            <td>{{$invoice->Due_date}}</td>
                            <td>{{$invoice->product}}</td>
                            <td>
                                <a href="{{url('InvoicesDetails')}}/{{$invoice->id}}">
                                    {{$invoice->section->section_name}}</a></td>
                            <td>{{$invoice->Discount}}</td>
                            <td>{{$invoice->Rate_VAT}}</td>
                            <td>{{$invoice->Value_VAT}}</td>
                            <td>{{$invoice->Total}}</td>
                            @if ($invoice->Value_Status == 1)
                            <td><span
                                    class="badge badge-pill badge-success">{{ $invoice->Status }}</span>
                            </td>
                            @elseif($invoice->Value_Status ==2)
                            <td><span
                                    class="badge badge-pill badge-danger">{{ $invoice->Status }}</span>
                            </td>
                            @else
                            <td><span
                                    class="badge badge-pill badge-warning">{{ $invoice->Status }}</span>
                            </td>
                            @endif
                            <td>{{$invoice->note}}</td>
                            <td>
                                <div class="dropdown">
                                    <button aria-expanded="false" aria-haspopup="true"
                                            class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                            type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                    <div class="dropdown-menu tx-13">

                                        <a class="dropdown-item" href=" {{ url('edit_invoice') }}/{{ $invoice->id }}">تعديل  الفاتورة</a>
                                        <a class="dropdown-item" href="#" data-invoice_id =" {{$invoice->id}}"
                                           data-invoice_number =" {{$invoice->invoice_number}}"
                                           data-toggle="modal" data-target="#delete_invoice">  <i class="fas fa-trash"></i>
                                            &nbsp;&nbsp; حذف الفاتورة</a>
                                        <a class="dropdown-item" href="{{ URL::route('Status_show', [$invoice->id]) }} "><i class="fa-money-bill"></i>تعديل  حاله الدفع </a>


                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->

    <!-- delete -->
    <div class="modal" id="delete_invoice">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف الفاتوره</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                     type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('invoices.destroy','test')}}" method="post">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
<script>
    $('#delete_invoice').on('show.bs.modal',function (event){
        //   var button = $(event.relatedTarget)
        //  var invoice_id = button.data('invoice_id')
        //   var invoice_number = button.data('invoice_number')
        //   var modal = $(this)
        //   modal.find('.modal-body #invoice_id').val(invoice_id);
        //    modal.find('.modal-body #invoice_number').val(invoice_number);

        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body  #invoice_id').val(invoice_id);
    })

</script>
@endsection
