@extends('panel.layouts.master')


@section('title' , 'ایجاد دوره')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد دوره</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                ایجاد دوره
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.shop.course.index')}}" type="button"
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
                <form action="{{route('panel.shop.course.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-5">
                        <p class="mg-b-10">عنوان </p>
                        <input type="text" class="form-control" name="title">
                        @error('title')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <p class="mg-b-10">مدرس</p>
                        <input type="text" class="form-control" name="teacher">
                        @error('teacher')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <p class="mg-b-10">قیمت</p>
                        <input type="number" class="form-control" name="price">
                        @error('price')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="d-flex gap-2 mb-3">
                            <span style="align-content: center;">کلید ها</span>
                            <button type="button" class="btn btn-sm btn-primary" id="add_btn">افزودن</button>
                            <input type="text" id="slug_input" class="form-control col-5"
                                placeholder="کلید را وارد کنید...">
                        </div>
                        <div class="col-lg-12 mg-t-20 mg-lg-t-0">

                            <select class="form-control select2" multiple name="slug[]" id="slug_select">

                            </select>
                        </div>
                        @error('slug[]')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="d-flex gap-2 mb-3">
                            <span style="align-content: center;">دسته بندی</span>
                        </div>
                        <div class="col-lg-12 mg-t-20 mg-lg-t-0">
                            <select class="form-control select2" name="category_id">
                                @foreach ($categories as $key => $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">وضعیت دوره</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="status" type="radio" value="true"> <span>قابل
                                        نمایش</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="status" checked type="radio" value="false">
                                    <span>پنهان</span></label>
                            </div>
                        </div>
                        @error('status')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group d-flex">
                        <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                            <p class="mg-b-10"> تصویر شاخص</p>
                            <input type="file" class="dropify" name="thumbnail">
                        </div>
                        @error('thumbnail')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>

                    <div class="form-group mb-5">
                        <p class="mg-b-10">توضیحات دوره</p>
                        <div class="ql-wrapper ql-wrapper-demo">
                            <div id="toolbar-container">
                                <span class="ql-formats">
                                    <select class="ql-font"></select>
                                    <select class="ql-size">
                                        <span tabindex="0" role="button" class="ql-picker-item" data-value="6"></span>
                                    </select>
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
                            <div id="quillEditor"></div>
                            <textarea name="description" hidden
                                id="description_textarea_description_for_edit"></textarea>
                        </div>
                        @error('description')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <!--<p class="mg-b-10">توضیحات کوتاه</p>-->
                        <!--<div class="ql-wrapper ql-wrapper-demo">-->
                        <!--    <div id="toolbar-container-2">-->
                        <!--        <span class="ql-formats">-->
                        <!--            <select class="ql-font"></select>-->
                        <!--            <select class="ql-size"></select>-->
                        <!--        </span>-->
                        <!--        <span class="ql-formats">-->
                        <!--            <button class="ql-bold"></button>-->
                        <!--            <button class="ql-italic"></button>-->
                        <!--            <button class="ql-underline"></button>-->
                        <!--            <button class="ql-strike"></button>-->
                        <!--        </span>-->
                        <!--        <span class="ql-formats">-->
                        <!--            <select class="ql-color"></select>-->
                        <!--            <select class="ql-background"></select>-->
                        <!--        </span>-->
                        <!--        <span class="ql-formats">-->
                        <!--            <button class="ql-script" value="sub"></button>-->
                        <!--            <button class="ql-script" value="super"></button>-->
                        <!--        </span>-->
                        <!--        <span class="ql-formats">-->
                        <!--            <button class="ql-header" value="1"></button>-->
                        <!--            <button class="ql-header" value="2"></button>-->
                        <!--            <button class="ql-blockquote"></button>-->
                        <!--            <button class="ql-code-block"></button>-->
                        <!--        </span>-->
                        <!--        <span class="ql-formats">-->
                        <!--            <button class="ql-list" value="ordered"></button>-->
                        <!--            <button class="ql-list" value="bullet"></button>-->
                        <!--            <button class="ql-indent" value="-1"></button>-->
                        <!--            <button class="ql-indent" value="+1"></button>-->
                        <!--        </span>-->
                        <!--        <span class="ql-formats">-->
                        <!--            <button class="ql-direction" value="rtl"></button>-->
                        <!--            <select class="ql-align"></select>-->
                        <!--        </span>-->
                        <!--        <span class="ql-formats">-->
                        <!--            <button class="ql-link"></button>-->
                        <!--            <button class="ql-image"></button>-->
                        <!--            <button class="ql-video"></button>-->
                        <!--            <button class="ql-formula"></button>-->
                        <!--        </span>-->
                        <!--        <span class="ql-formats">-->
                        <!--            <button class="ql-clean"></button>-->
                        <!--        </span>-->
                        <!--    </div>-->
                        <!--    <div id="quillEditor2"></div>-->
                            <textarea name="short_description"  class="form-control" rows="10" cols="10"
                                id="description_textarea_short_description_for_edit"></textarea>
                        </div>
                        @error('short_description')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
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
    // var toolbarOptions = [
	// 	[{
	// 		'header': [1, 2, 3, 4, 5, 6, false]
	// 	}],
	// 	['bold', 'italic', 'underline', 'strike','align'],
	// 	[{
	// 		'list': 'ordered'
	// 	}, {
	// 		'list': 'bullet'
	// 	}],
	// 	['image','background','color']
	// ];


    var quill = new Quill('#quillEditor', {
		modules: {
			toolbar: '#toolbar-container'
			// toolbar: toolbarOptions
		},
		theme: 'snow'
	});

    quill.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("description_textarea_description_for_edit").value = quill.root.innerHTML;
    });

	if (document.getElementById("description_textarea_description_for_edit").value) {	
		quill.root.innerHTML = document.getElementById("description_textarea_description_for_edit").value;
	}

  //   var toolbarOptions = [
	// 	[{
	// 		'header': [1, 2, 3, 4, 5, 6, false]
	// 	}],
	// 	['bold', 'italic', 'underline', 'strike'],
	// 	[{
	// 		'list': 'ordered'
	// 	}, {
	// 		'list': 'bullet'
	// 	}],
	// ];


    var quill2 = new Quill('#quillEditor2', {
		modules: {
			toolbar: '#toolbar-container-2'
		},
		theme: 'snow'
	});

	quill2.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("description_textarea_short_description_for_edit").value = quill2.root.innerHTML;
    });

	if (document.getElementById("description_textarea_short_description_for_edit").value) {	
		quill2.root.innerHTML = document.getElementById("description_textarea_short_description_for_edit").value;
	}
</script>

<script>
    $(document).ready(function(){


        $('#add_btn').click(function(){

             let value = $('#slug_input').val()
             $('#slug_select').append(`<option selected value="${value}">${value}</option>`)
             $('#slug_input').val('')
             
        })

    })
</script>
@endsection