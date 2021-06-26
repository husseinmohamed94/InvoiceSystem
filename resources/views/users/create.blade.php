@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">ٌقائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة مستخدم</span>
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
                                <form action="{{ route('users.store','test') }}" method="post" enctype="multipart/form-data"
                                      autocomplete="">
                                    {{ csrf_field() }}
                                    {{-- 1 --}}

                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">اسم المستخدم </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   title="يرجي ادخال الاسم" required>
                                        </div>

                                        <div class="col">
                                            <label>   :البريد الكتروني <span class="tx-danger">*</span> </label>
                                            <input class="form-control " name="email" placeholder="email"
                                                   type="email" value="" required>
                                        </div>

                                    </div>

                                    {{-- 2 --}}
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label"> كلمة المروة </label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   title="يرجي ادخال باسورد" required>
                                        </div>

                                        <div class="col">
                                            <label>تاكيد كلمة المرو </label>
                                            <input class="form-control " id="" name="confirm-password" placeholder="email"
                                                   type="password" value="" required>
                                        </div>

                                    </div>

                                    {{-- 3 --}}
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">حالة المستخدم </label>
                                            <select  class="form-control SlectBox" name="Status">
                                                <option value="مفعل"> مفعل</option>
                                                <option value="غير مفعل">غير مفعل</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- 4 --}}
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">صلاحيات المستخدم </label>
                                           <select  class="form-control SlectBox" name="roles_name[]" multiple>
                                                @foreach($roles as $role)
                                                  <option>{{$role}}</option>
                                                @endforeach
                                            </select>
                                            {{--    {!! Form::select('roles_name[]',$roles,[],array('class' => 'form-control','multiple')) !!}
                                                --}}
                                                  </div>

                                              </div>


                                              {{-- 5 --}}


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
