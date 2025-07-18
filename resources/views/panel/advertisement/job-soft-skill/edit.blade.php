@extends('panel.layouts.master')


@section('title' , 'ویرایش  مهارت')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش  مهارت</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.advertisement.index')}}">
                    لیست آگهی ها
                </a>
            </li>
            <li class="breadcrumb-item"> <a href="{{route('panel.advertisement.job.soft.skill.show',$advertisement->id)}}">
                     سابقه مهارت ها
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش  مهارت
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.soft.skill.show',$advertisement->id)}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.advertisement.job.soft.skill.update',$skill->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="advertisement_id" value="{{$advertisement->id}}">
                    <div id="form">
                        <div class="col-lg-12 mg-t-20 ">
                            <p class="mg-b-10">مهارت</p>
                            <select class="form-control select2-with-search" name="skill">
                                <option label="Choose one">
                                </option>
                                <option value="ورد" @if ($skill->skill == 'ورد') selected @endif>
                                    ورد
                                </option>
                                <option value="پاورپوینت"  @if ($skill->skill == 'پاورپوینت') selected @endif>
                                    پاورپوینت
                                </option>
                                <option value="اکسل"  @if ($skill->skill == 'اکسل') selected @endif>
                                    اکسل
                                </option>
                                <option value="اکسس"  @if ($skill->skill == 'اکسس') selected @endif>
                                    اکسس
                                </option>
                                <option value="فناوری اطلاعات"  @if ($skill->skill == 'فناوری اطلاعات') selected @endif>
                                    فناوری اطلاعات
                                </option>
                                <option value="فتوشاپ"  @if ($skill->skill == 'فتوشاپ') selected @endif>
                                    فتوشاپ
                                </option>
                                <option value="برنامه نویسی"  @if ($skill->skill == 'برنامه نویسی') selected @endif>
                                    برنامه نویسی
                                </option>
                                <option value="مطلب"  @if ($skill->skill == 'مطلب') selected @endif>
                                    مطلب
                                </option>
                            </select>
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