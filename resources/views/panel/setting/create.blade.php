@extends('panel.layouts.master')


@section('title' , 'ایجاد تنظیمات')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد تنظیمات</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                تنظیمات
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

            </div>
            <div class="card-body">
                <form action="{{route('panel.setting.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-5">
                        <p class="mg-b-10">عنوان سایت</p>
                        <input type="text" class="form-control" name="site_title">
                        @error('site_title')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <p class="mg-b-10">لینک اینماد</p>
                        <textarea type="text" class="form-control" name="enamad" rows="6"></textarea>
                        @error('enamad')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group d-flex">
                        <div class="col-sm-6 col-md-6 mt-lg-0 mt-3">
                            <p class="mg-b-10"> لوگو</p>
                            <input type="file" class="dropify" name="logo">
                        </div>
                        @error('logo')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>

                    <div class="form-group mb-5">
                        <p class="mg-b-10">تماس با ما</p>
                        <div id="toolbar-container-2">
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-script" value="sub"></button>
                                <button class="ql-script" value="super"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-header" value="1"></button>
                                <button class="ql-header" value="2"></button>
                                <button class="ql-blockquote"></button>
                                <button class="ql-code-block"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-indent" value="-1"></button>
                                <button class="ql-indent" value="+1"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-direction" value="rtl"></button>
                                <select class="ql-align"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-video"></button>
                                <button class="ql-formula"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-clean"></button>
                            </span>
                        </div>
                        <div class="ql-wrapper ql-wrapper-demo">
                            <div name="contact_us" id="quillEditor2"></div>
                            <textarea name="contact_us" hidden id="description_textarea_contact_us_for_edit"></textarea>
                        </div>
                        @error('contact_us')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <p class="mg-b-10">درباره ما</p>
                        <div id="toolbar-container">
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-script" value="sub"></button>
                                <button class="ql-script" value="super"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-header" value="1"></button>
                                <button class="ql-header" value="2"></button>
                                <button class="ql-blockquote"></button>
                                <button class="ql-code-block"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-indent" value="-1"></button>
                                <button class="ql-indent" value="+1"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-direction" value="rtl"></button>
                                <select class="ql-align"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-video"></button>
                                <button class="ql-formula"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-clean"></button>
                            </span>
                        </div>
                        <div class="ql-wrapper ql-wrapper-demo">
                            <div name="about_us" id="quillEditor"></div>
                            <textarea name="about_us" hidden id="description_textarea_about_us_for_edit"></textarea>
                        </div>
                        @error('about_us')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <p class="mg-b-10">سوالات متداول</p>
                        <div class="card-header border-bottom-0 pb-0">
                            <button class="btn btn-primary" type="button" id="addRow">افزودن ردیف</button>
                        </div>
                        <div id="questions">
                            <hr>
                            <div class="form-group">
                                <p class="mg-b-10">عنوان سوال</p>
                                <input type="text" class="form-control" name="question_title[]" value="">
                                @error('question_title[]')
                                <ui>
                                    <li class="alert alert-danger">{{$message}}</li>
                                </ui>
                                @enderror
                            </div>
                            <div class="form-group">
                                <p class="mg-b-10"> جواب سوال</p>
                                <textarea class="form-control" cols="10" rows="10" name="question_answer[]"></textarea>
                                @error('question_answer[]')
                                <ui>
                                    <li class="alert alert-danger">{{$message}}</li>
                                </ui>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
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


<script>
    var quill2 = new Quill('#quillEditor2', {
		modules: {
			toolbar: '#toolbar-container-2'
		},
		theme: 'snow'
	});

    quill2.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("description_textarea_contact_us_for_edit").value = quill2.root.innerHTML;
    });

	if (document.getElementById("description_textarea_contact_us_for_edit").value) {	
		quill2.root.innerHTML = document.getElementById("description_textarea_contact_us_for_edit").value;
	}


    var quill = new Quill('#quillEditor', {
		modules: {
			toolbar: '#toolbar-container'
		},
		theme: 'snow'
	});

    quill.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("description_textarea_about_us_for_edit").value = quill.root.innerHTML;
    });

	if (document.getElementById("description_textarea_about_us_for_edit").value) {	
		quill.root.innerHTML = document.getElementById("description_textarea_about_us_for_edit").value;
	}
</script>

<script>
    $(document).ready(function(){
        $('#addRow').click(function(){
            $('#questions').append(
                `
                <hr>
                <div class="form-group">
                            <p class="mg-b-10">عنوان سوال</p>
                            <input type="text" class="form-control" name="question_title[]">
                            @error('question_title[]')
                            <ui>
                                <li class="alert alert-danger">{{$message}}</li>
                            </ui>
                            @enderror
                </div>
                <div class="form-group">
                            <p class="mg-b-10"> جواب سوال</p>
                            <textarea class="form-control" cols="10" rows="10" name="question_answer[]"></textarea>
                            @error('question_answer[]')
                            <ui>
                                <li class="alert alert-danger">{{$message}}</li>
                            </ui>
                            @enderror
                </div>
                `
            )
        })
    })
</script>

@endsection