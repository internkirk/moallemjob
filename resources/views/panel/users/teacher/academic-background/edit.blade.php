@extends('panel.layouts.master')


@section('title' , 'ویرایش سابقه تحصیلی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش سابقه تحصیلی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.teacher.index')}}">
                    لیست معلمان
                </a>
            </li>
            <li class="breadcrumb-item"> <a href="{{route('panel.teacher.academic.background.show',$teacher->id)}}">
                     سابقه تحصیلی
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش سابقه تحصیلی
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.academic.background.show',$teacher->id)}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.teacher.academic.background.update',$academicBackground->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                    <div class="form-group">
                        <p class="mg-b-10">مقطع تحصیلی</p>
                        <div class="col-lg-4 col-xl-3 my-3">
                            <label class="ckbox"><input name="is_high_school" @if($academicBackground->is_high_school) checked @endif type="checkbox"> <span>متوسطه </span></label>
                        </div>
                        <div class="col-lg-4 col-xl-3 my-3">
                            <label class="ckbox"><input name="is_associate" @if($academicBackground->is_associate) checked @endif type="checkbox"> <span>کاردانی </span></label>
                        </div>
                        <div class="col-lg-4 col-xl-3 my-3">
                            <label class="ckbox"><input name="is_bachelor" @if($academicBackground->is_bachelor) checked @endif type="checkbox"> <span>کارشناسی </span></label>
                        </div>
                        <div class="col-lg-4 col-xl-3 my-3">
                            <label class="ckbox"><input name="is_master" @if($academicBackground->is_master) checked @endif type="checkbox"> <span>کارشناسی ارشد </span></label>
                        </div>
                        <div class="col-lg-4 col-xl-3 my-3">
                            <label class="ckbox"><input name="is_phd" @if($academicBackground->is_phd) checked @endif type="checkbox"> <span>دکترا و بالاتر </span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">رشته تحصیلی</p>
                        <input type="text" class="form-control" name="major" value="{{$academicBackground->major}}">
                        @error('major')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">دانشگاه</p>
                        <input type="text" class="form-control" name="university" value="{{$academicBackground->university}}">
                        @error('university')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">معدل</p>
                        <input type="number" class="form-control" name="gpa" value="{{$academicBackground->gpa}}">
                        @error('gpa')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">سال فارغ التحصیلی</p>
                        <input type="number" class="form-control" name="year_of_graduation" value="{{$academicBackground->year_of_graduation}}">
                        @error('year_of_graduation')
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