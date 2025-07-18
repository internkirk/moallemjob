@extends('panel.layouts.master')


@section('title' , 'ویرایش درخواست سغلی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش درخواست</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.teacher.index')}}">
                    لیست معلمان
                </a>
            </li>
            <li class="breadcrumb-item"> <a href="{{route('panel.teacher.job.in.demand.show',$teacher->id)}}">
                    سابقه درخواست شغلی
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش درخواست
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.job.in.demand.show',$teacher->id)}}" type="button"
                class="btn btn-primary btn-icon-text my-2 me-2">
                بازگشت
            </a>
        </div>
    </div>
</div>
<!-- End Page Header -->


<!--Row-->
<div class="row row-sm">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
        <div class="card custom-card">
            <div class="card-header border-bottom-0 pb-0">

            </div>
            <div class="card-body">
                <form action="{{route('panel.teacher.job.in.demand.update',$jobInDemand->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                    <div class="form-group">
                        <p class="mg-b-10">رشته(پایه)تحصیلی</p>
                        <input type="text" class="form-control" name="major" value="{{$jobInDemand->major}}">
                        @error('major')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">حقوق درخواستی</p>
                        <input type="number" class="form-control" name="salary" value="{{$jobInDemand->salary}}">
                        @error('salary')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">استان</p>
                        <input type="text" class="form-control" name="province" value="{{$jobInDemand->province}}">
                        @error('province')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">شهر</p>
                        <input type="text" class="form-control" name="city" value="{{$jobInDemand->city}}">
                        @error('city')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="d-flex mt-5 p-3 align-items-center">
                        <div class="col-2 main-content-label">
                            مقطع تحصیلی
                        </div>
                        <div class="border-bottom col-10"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_pre_school" type="checkbox" @if($jobInDemand->is_pre_school) checked
                                @endif> <span>پیش دبستانی
                                </span></label>
                        </div>
                        @error('is_pre_school')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_elementary" type="checkbox" @if($jobInDemand->is_elementary) checked
                                @endif>
                                <span>ابتدایی</span></label>
                        </div>
                        @error('is_elementary')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_middle_school" type="checkbox" @if($jobInDemand->is_middle_school)
                                checked @endif> <span> متوسطه اول
                                </span></label>
                        </div>
                        @error('is_middle_school')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_high_school" type="checkbox" @if($jobInDemand->is_high_school) checked
                                @endif> <span>متوسطه
                                    نظری</span></label>
                        </div>
                        @error('is_high_school')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_techinical_college" type="checkbox"  @if($jobInDemand->is_techinical_college) checked @endif>
                                <span>هنرستان</span></label>
                        </div>
                        @error('is_techinical_college')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_foreign_lan_teacher" type="checkbox" @if($jobInDemand->is_foreign_lan_teacher) checked @endif> <span>مدرس زبان
                                    خارجی</span></label>
                        </div>
                        @error('is_foreign_lan_teacher')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_entrance_exam_teacher" type="checkbox"  @if($jobInDemand->is_entrance_exam_teacher) checked @endif> <span>مدرس
                                    کنکور</span></label>
                        </div>
                        @error('is_entrance_exam_teacher')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_academic_counsellor" type="checkbox" @if($jobInDemand->is_academic_counsellor) checked @endif> <span>مشاور
                                    تحصیلی و تربیتی</span></label>
                        </div>
                        @error('is_academic_counsellor')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="d-flex mt-5 p-3 align-items-center">
                        <div class="col-2 main-content-label">
                            سمت
                        </div>
                        <div class="border-bottom col-10"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_manager" type="checkbox" @if($jobInDemand->is_manager) checked @endif> <span>مدیر</span></label>
                        </div>
                        @error('is_manager')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_deputy" type="checkbox" @if($jobInDemand->is_deputy) checked @endif> <span>معاون</span></label>
                        </div>
                        @error('is_deputy')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_couch" type="checkbox" @if($jobInDemand->is_couch) checked @endif> <span>مربی</span></label>
                        </div>
                        @error('is_couch')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_teacher" type="checkbox" @if($jobInDemand->is_teacher) checked @endif> <span>آموزگار</span></label>
                        </div>
                        @error('is_teacher')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_dabir" type="checkbox" @if($jobInDemand->is_dabir) checked @endif> <span>دبیر</span></label>
                        </div>
                        @error('is_dabir')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_honar_amouz" type="checkbox" @if($jobInDemand->is_honar_amouz) checked
                                @endif>
                                <span>هنرآموزگار</span></label>
                        </div>
                        @error('is_honar_amouz')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="d-flex mt-5 p-3 align-items-center">
                        <div class="col-2 main-content-label">
                            نوع همکاری
                        </div>
                        <div class="border-bottom col-10"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_full_time" @if($jobInDemand->is_full_time) checked
                                @endif type="checkbox"> <span>تمام وقت</span></label>
                        </div>
                        @error('is_full_time')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_half_time" @if($jobInDemand->is_half_time) checked
                                @endif type="checkbox"> <span>نیمه وقت</span></label>
                        </div>
                        @error('is_half_time')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_part_time" @if($jobInDemand->is_part_time) checked
                                @endif type="checkbox"> <span>پاره وقت</span></label>
                        </div>
                        @error('is_part_time')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <button class="btn ripple btn-main-primary btn-block" type="submit">ویرایش</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<!-- row closed  -->

@endsection

@section('scripts')

<!-- INTERNAL FORM-ELEMENTS JS -->
<script src="{{asset('assets/js/advanced-form-elements.js')}}"></script>

@endsection