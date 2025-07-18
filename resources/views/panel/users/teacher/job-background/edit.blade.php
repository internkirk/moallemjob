@extends('panel.layouts.master')


@section('title' , 'ویرایش سابقه شغلی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش سابقه شغلی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.teacher.index')}}">
                    لیست معلمان
                </a>
            </li>
            <li class="breadcrumb-item"> <a href="{{route('panel.teacher.job.background.show',$teacher->id)}}">
                    سابقه شغلی
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش سابقه شغلی
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.job.background.show',$teacher->id)}}" type="button"
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
                <form action="{{route('panel.teacher.job.background.update',$jobBackground->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                    <div class="form-group">
                        <p class="mg-b-10">رشته(پایه)تحصیلی</p>
                        <input type="text" class="form-control" name="major" value="{{$jobBackground->major}}">
                        @error('major')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <p class="mg-b-10">آموزشگاه</p>
                        <input type="text" class="form-control" name="school" value="{{$jobBackground->school}}">
                        @error('school')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">سال شروع</p>
                        <input type="number" class="form-control" name="start_year"
                            value="{{$jobBackground->start_year}}">
                        @error('start_year')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">سال پایان</p>
                        <input type="number" class="form-control" name="end_year" value="{{$jobBackground->end_year}}">
                        @error('end_year')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <p class="mg-b-10">شهر</p>
                        <input type="text" class="form-control" name="city" value="{{$jobBackground->city}}">
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
                            <label class="ckbox"><input name="is_pre_school" @if($jobBackground->is_pre_school) checked
                                @endif type="checkbox"> <span>پیش دبستانی </span></label>
                        </div>
                        @error('is_pre_school')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_elementary" @if($jobBackground->is_elementary) checked
                                @endif type="checkbox"> <span>ابتدایی</span></label>
                        </div>
                        @error('is_elementary')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_middle_school" @if($jobBackground->is_middle_school)
                                checked @endif type="checkbox"> <span> متوسطه اول </span></label>
                        </div>
                        @error('is_middle_school')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_high_school" @if($jobBackground->is_high_school)
                                checked @endif type="checkbox"> <span>متوسطه نظری</span></label>
                        </div>
                        @error('is_high_school')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_techinical_college"
                                    @if($jobBackground->is_techinical_college) checked @endif type="checkbox">
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
                            <label class="ckbox"><input name="is_foreign_lan_teacher"
                                    @if($jobBackground->is_foreign_lan_teacher) checked @endif type="checkbox">
                                <span>مدرس زبان خارجی</span></label>
                        </div>
                        @error('is_foreign_lan_teacher')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_entrance_exam_teacher"
                                    @if($jobBackground->is_entrance_exam_teacher) checked @endif type="checkbox">
                                <span>مدرس کنکور</span></label>
                        </div>
                        @error('is_entrance_exam_teacher')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_academic_counsellor"
                                    @if($jobBackground->is_academic_counsellor) checked @endif type="checkbox">
                                <span>مشاور تحصیلی و تربیتی</span></label>
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
                            <label class="ckbox"><input name="is_manager" @if($jobBackground->is_manager) checked @endif
                                type="checkbox"> <span>مدیر</span></label>
                        </div>
                        @error('is_manager')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_deputy" @if($jobBackground->is_deputy) checked @endif
                                type="checkbox"> <span>معاون</span></label>
                        </div>
                        @error('is_deputy')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_couch" @if($jobBackground->is_couch) checked @endif
                                type="checkbox"> <span>مربی</span></label>
                        </div>
                        @error('is_couch')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_teacher" @if($jobBackground->is_teacher) checked @endif
                                type="checkbox"> <span>آموزگار</span></label>
                        </div>
                        @error('is_teacher')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_dabir" @if($jobBackground->is_dabir) checked @endif
                                type="checkbox"> <span>دبیر</span></label>
                        </div>
                        @error('is_dabir')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_honar_amouz" @if($jobBackground->is_honar_amouz)
                                checked @endif type="checkbox"> <span>هنرآموزگار</span></label>
                        </div>
                        @error('is_honar_amouz')
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
<!-- INTERNAL QUILL JS -->
<script src="{{asset('assets/plugins/quill/quill.min.js')}}"></script>

<!-- INTERNAL FORM-EDITOR JS -->
<script src="{{asset('assets/js/form-editor.js')}}"></script>

<!-- INTERNAL FILEUPLOADERS JS -->
<script src="{{asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

<!-- INTERNALFANCY UPLOADER JS -->
{{-- <script src="{{asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script> --}}

<!-- INTERNAL FORM-ELEMENTS JS -->
<script src="{{asset('assets/js/advanced-form-elements.js')}}"></script>



@endsection