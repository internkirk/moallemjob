@extends('panel.layouts.master')


@section('title' , 'ویرایش ویژگی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش ویژگی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش ویژگی
            </li>
        </ol>
    </div>
</div>
<!-- End Page Header -->


<!--Row-->
<div class="row row-sm">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
        <div class="card custom-card">
            <div class="card-header border-bottom-0 pb-0">
                <ul>
                    <li class="alert alert-danger">
                         به هیچ عنوان فیلد "عنوان" را تغییر ندهید ، صرفا ویژگی را فعال یا غیر فعال کنید
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form action="{{route('panel.feature.management.update',$feature->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-5">
                        <p class="mg-b-10">عنوان </p>
                        <input type="text" class="form-control" name="feature" readonly value="{{$feature->feature}}">
                        @error('feature')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <p class="mg-b-10">عنوان فارسی </p>
                        <input type="text" class="form-control" name="fa_title" readonly value="{{$feature->fa_title}}">
                        @error('fa_title')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">وضعیت</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="status" @if($feature->status) checked @endif type="radio" value="true">
                                    <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="status" @if(!$feature->status) checked @endif type="radio" value="false">
                                    <span>غیرفعال</span></label>
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
{{-- <script src="{{asset('assets/js/form-editor.js')}}"></script> --}}

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