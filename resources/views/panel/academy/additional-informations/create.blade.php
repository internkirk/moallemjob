@extends('panel.layouts.master')


@section('title' , 'ایجاد اطلاعات تکمیلی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد اطلاعات تکمیلی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.academy.index')}}">
                    لیست آموزشگاه ها
                </a>
            </li>
            <li class="breadcrumb-item"> <a href="{{route('panel.academy.additional.informations.show',$academy->id)}}">
                اطلاعات تکمیلی
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">

                
                ایجاد اطلاعات تکمیلی
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.academy.additional.informations.show',$academy->id)}}" type="button"
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
            <div class="card-body">
                <form action="{{route('panel.academy.additional.informations.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="academy_id" value="{{$academy->id}}">
                    <div class="form-group">
                        <p class="mg-b-10">سال تاسیس</p>
                        <input type="number" class="form-control" name="establishment_year">
                        @error('establishment_year')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">تصویر مجوز تاسیس</p>
                        <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                            <input type="file" class="dropify" name="establishment_license_image" >
                        </div>
                        @error('establishment_license_image	')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">تصویر مجوز راه اندازی</p>
                        <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                            <input type="file" class="dropify" name="startup_license_image" >
                        </div>
                        @error('startup_license_image')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">تصویر نمایه</p>
                        <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                            <input type="file" class="dropify" name="profile_image" >
                        </div>
                        @error('profile_image')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">تصاویر مدرسه</p>
                        <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                            <input type="file" class="dropify" name="school_image[]" multiple>
                        </div>
                        @error('school_image[]')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <p class="mg-b-10">مزایا و تسهیلات سازمانی </p>
                        <textarea class="form-control" name="benefits" rows="10"></textarea>
                        @error('benefits')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn ripple btn-main-primary btn-block" type="submit">ایجاد</button>
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