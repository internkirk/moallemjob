@extends('panel.layouts.master')


@section('title' , 'ویرایش درخواست')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش درخواست</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.pro.resume.request.index')}}">
                    لیست درخواست ها
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.pro.resume.request.index')}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.pro.resume.request.update',$request->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">در انتظار بررسی توسط ادمین</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="request_stage" @if ($request->request_stage == 'در انتظار بررسی توسط ادمین') checked @endif type="radio" value="در انتظار بررسی توسط ادمین"> <span>فعال</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">منتظر دریافت اطلاعات تکمیلی شما</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="request_stage" @if ($request->request_stage == 'منتظر دریافت اطلاعات تکمیلی شما') checked @endif type="radio" value="منتظر دریافت اطلاعات تکمیلی شما"> <span>فعال</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">طراحی رزومه درحال انجام است</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="request_stage" @if ($request->request_stage == 'طراحی رزومه درحال انجام است') checked @endif type="radio" value="طراحی رزومه درحال انجام است"> <span>فعال</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">رزومه نهایی آماده دانلود است</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="request_stage" @if ($request->request_stage == 'رزومه نهایی آماده دانلود است') checked @endif type="radio" value="رزومه نهایی آماده دانلود است"> <span>فعال</span></label>
                            </div>
                        </div>
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