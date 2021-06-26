@extends('layouts.master')
@section('css')
@endsection
@section('page-header')

@endsection
@section('content')

 @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

				<!-- row -->
				<div class="row">

                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
                                    <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع </a></li>
                                    <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab4">
                                    <table class="table table-striped" style="text-align: center">
                                        <tr>
                                        <th scope="row">رقم الفاتورة</th>
                                        <td>{{$invoice->invoice_number}}</td>
                                          <th scope="row">تاريخ الاصدار</th>
                                        <td>{{$invoice->invoice_Date}}</td>
                                         <th scope="row">تاريخ الاستحقاق </th>
                                        <td>{{$invoice->Due_date}}</td>
                                         <th scope="row">القسم </th>
                                            <td>{{$invoice->section->section_name}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">المنتج </th>
                                            <td>{{$invoice->product}}</td>
                                            <th scope="row"> مبلغ التحصيل</th>
                                            <td>{{$invoice->Amount_collection}}</td>
                                            <th scope="row">مبلغ العموله  </th>
                                            <td>{{$invoice->Amount_Commission}}</td>
                                            <th scope="row">الخصم </th>
                                            <td>{{$invoice->Discount}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">نسبة الضريبة </th>
                                            <td>{{$invoice->Rate_VAT}}</td>
                                            <th scope="row">  قيمة الضريبة</th>
                                            <td>{{$invoice->Value_VAT}}</td>
                                            <th scope="row"> الاجمالي  </th>
                                            <td>{{$invoice->Total}}</td>
                                            <th scope="row">الحالة الحالية </th>
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
                                        </tr>
                                        <tr>
                                            <th scope="row">ملاحظات </th>
                                            <td>{{$invoice->note}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab5">
                                    <table class="table table-striped" style="text-align: center">
                                        <tr class="text-danger">
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">رقم الفاتوره</th>
                                            <th class="border-bottom-0"> نوع المتتج</th>
                                            <th class="border-bottom-0">القسم </th>
                                            <th class="border-bottom-0">الحاله </th>
                                            <th class="border-bottom-0">تاريخ الدفع</th>
                                            <th class="border-bottom-0">ملاحظات </th>
                                            <th class="border-bottom-0">تاريخ الاضافه</th>
                                            <th class="border-bottom-0"> النستخدم</th>
                                        </tr>
                                        @php $i =0 @endphp
                                        @foreach($details as $x)
                                            @php $i++ @endphp
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$x->invoice_number}}</td>
                                                <td>{{$x->Product }}</td>
                                                <td>{{$invoice->section->section_name}}</td>

                                                @if ($x->Value_Status == 1)
                                                    <td><span
                                                            class="badge badge-pill badge-success">{{ $x->Status }}</span>
                                                    </td>
                                                @elseif($x->Value_Status == 2)
                                                    <td><span
                                                            class="badge badge-pill badge-danger">{{ $x->Status }}</span>
                                                    </td>
                                                @else
                                                    <td><span
                                                            class="badge badge-pill badge-warning">{{ $x->Status }}</span>
                                                    </td>
                                                @endif
                                                <td>{{$x->Payment_Date}}</td>
                                                <td>{{$x->note}}</td>
                                                <td>{{$x->created_at}}</td>
                                                <td>{{$x->user}}</td>


                                            </tr>
                                        @endforeach
                                    </table>

                                </div>
                                <div class="tab-pane" id="tab6">
                                    <!--المرفقات-->
                                    <div class="card card-statistics">

                                            <div class="card-body">
                                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                @can('اضافة مرفق')
                                                <h5 class="card-title">اضافة مرفقات</h5>
                                                @endcan
                                                <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                      enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile"
                                                               name="file_name" required>
                                                        <input type="hidden" id="customFile" name="invoice_number"
                                                               value="{{ $invoice->invoice_number }}">
                                                        <input type="hidden" id="invoice_id" name="invoice_id"
                                                               value="{{ $invoice->id }}">
                                                        <label class="custom-file-label" for="customFile">حدد
                                                            المرفق</label>
                                                    </div><br><br>
                                                    <button type="submit" class="btn btn-primary btn-sm "
                                                            name="uploadedFile">تاكيد</button>
                                                </form>
                                            </div>
                                    </div>
                                        <br>

                                        <table class="table table-striped" style="text-align: center">
                                        <tr class="text-danger">
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0"> اسم الملف</th>
                                            <th class="border-bottom-0">قام بالاضافه </th>
                                            <th class="border-bottom-0">تاريخ الاضافه</th>
                                            <th class="border-bottom-0"> العمليات</th>
                                        </tr>
                                        @php $i =0 @endphp
                                        @foreach($attachenents as $attachenent)
                                            @php $i++ @endphp
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$attachenent->file_name}}</td>
                                                <td>{{$attachenent->Created_by}}</td>
                                                <td>{{$attachenent->created_at}}</td>
                                                <td colspan="2">

                                                    <a class=" btn btn-sm btn-outline-success"
                                                        href="{{url('view_file')}}/{{ $invoice->invoice_number }}/{{$attachenent->file_name}}"><i class="fas fa-eye"></i>&nbsp; عرض</a>

                                                    <a class=" btn btn-sm btn-outline-info"
                                                       href="{{url('download')}}/{{ $invoice->invoice_number }}/{{$attachenent->file_name}}"><i class="fas fa-eye"></i>&nbsp; تحميل </a>

                                                    <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-file_name="{{ $attachenent->file_name }}"
                                                                                data-invoice_number="{{ $attachenent->invoice_number }}"
                                                                                data-id_file="{{ $attachenent->id }}"
                                                                                data-target="#delete_file">حذف</button>

                                                </td>


                                            </tr>
                                        @endforeach
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
				<!-- row closed -->


    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @can('حذف المرفق')
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @endcan
                </div>
                <form action="{{ route('delete_file') }}" method="post">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
 <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>

@endsection
