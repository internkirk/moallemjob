@extends('panel.layouts.master')


@section('title' , 'ایجاد مهارت')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد مهارت</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.advertisement.index')}}">
                    لیست آگهی ها
                </a>
            </li>
            <li class="breadcrumb-item"> <a
                    href="{{route('panel.advertisement.job.soft.skill.show',$advertisement->id)}}">
                    مهارت
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ایجاد مهارت
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.soft.skill.show',$advertisement->id)}}" type="button"
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
                <button class="btn btn-primary" id="addRow">افزودن ردیف</button>
            </div>
            <div class="card-body">
                <form action="{{route('panel.advertisement.job.soft.skill.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="advertisement_id" value="{{$advertisement->id}}">
                    <div id="form">
                        <div class="col-lg-12 mg-t-20 ">
                            <p class="mg-b-10">مهارت</p>
                            <select class="form-control select2-with-search" name="skill[]">
                                <option label="Choose one">
                                </option>
                                <option value="ورد">
                                    ورد
                                </option>
                                <option value="پاورپوینت">
                                    پاورپوینت
                                </option>
                                <option value="اکسل">
                                    اکسل
                                </option>
                                <option value="اکسس">
                                    اکسس
                                </option>
                                <option value="فناوری اطلاعات">
                                    فناوری اطلاعات
                                </option>
                                <option value="فتوشاپ">
                                    فتوشاپ
                                </option>
                                <option value="برنامه نویسی">
                                    برنامه نویسی
                                </option>
                                <option value="مطلب">
                                    مطلب
                                </option>
                            </select>
                        </div>
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

<script>
    $(document).ready(function(){
        $('#addRow').click(function(){
            $('#form').append(
                `
                <hr>
                <div class="col-lg-12 mg-t-20 ">
                            <p class="mg-b-10">مهارت</p>
                            <select class="form-control select2-with-search" name="skill[]">
                                <option label="Choose one">
                                </option>
                                <option value="ورد">
                                    ورد
                                </option>
                                <option value="پاورپوینت">
                                    پاورپوینت
                                </option>
                                <option value="اکسل">
                                    اکسل
                                </option>
                                <option value="اکسس">
                                    اکسس
                                </option>
                                <option value="فناوری اطلاعات">
                                    فناوری اطلاعات
                                </option>
                                <option value="فتوشاپ">
                                    فتوشاپ
                                </option>
                                <option value="برنامه نویسی">
                                    برنامه نویسی
                                </option>
                                <option value="مطلب">
                                    مطلب
                                </option>
                            </select>
                        </div>
                `
            )
        })
    })
</script>
@endsection