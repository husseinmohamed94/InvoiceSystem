@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اصافة صلاحية</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('roles.store','test') }}" method="post" enctype="multipart/form-data"
                                      autocomplete="">
                                    {{ csrf_field() }}
                                    {{-- 1 --}}

                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">اسم صلاحية </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   title="يرجي ادخال الاسم" required>
                                        </div>
                                    </div>


                                    {{-- 2 --}}


                                    <div class="row">
                                        <div class="col">
                                          <label for="inputName" class="control-label">صلاحيات المستخدم </label>
                                        </br>
                                            @foreach($permission as $value)
                                            <input type="checkbox" value="{{$value->id}}"  class="form-check-label" name="permission[]" >
                                                {{$value->name}}</br>
                                                @endforeach
                                        </div>
                                    </div>




                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary"> تاكيد</button>
                                    </div>


                                </form>
                            </div>
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
@endsection
