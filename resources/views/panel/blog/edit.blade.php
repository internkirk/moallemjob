@extends('panel.layouts.master')


@section('title' , 'ویرایش مقاله')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش مقاله</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش مقاله
            </li>
        </ol>
    </div>
    <div class="d-flex">
      <div class="justify-content-center">
          <a href="{{route('panel.blog.index')}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.blog.update',$blog->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-5">
                        <p class="mg-b-10">عنوان </p>
                        <input type="text" class="form-control" name="title" value="{{$blog->title}}">
                        @error('title')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group d-flex">
                        <div class="col-sm-6 col-md-6 mt-lg-0 mt-3">
                            <p class="mg-b-10"> تصویر شاخص</p>
                            <input type="file" class="dropify" name="thumbnail">
                        </div>
                        <div>
                            <img src="{{json_decode($blog->thumbnail,true)[0]}}" width="250px" height="250px" alt="">
                        </div>
                        @error('thumbnail')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>

                    <div class="form-group mb-5">
                        <p class="mg-b-10">متن مقاله</p>
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
                            <div id="quillEditor"></div>
                            <textarea name="description" hidden
                                id="description_textarea_description_for_edit">{{$blog->description}}</textarea>
                        </div>
                        @error('description')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <p class="mg-b-10">توضیحات کوتاه</p>
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
                            <div id="quillEditor2"></div>
                            <textarea name="short_description" hidden
                                id="description_textarea_short_description_for_edit">{{$blog->short_description}}</textarea>
                        </div>
                        @error('short_description')
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
	// 	['bold', 'italic', 'underline', 'strike'],
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
		},
		theme: 'snow'
	});

    quill.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("description_textarea_description_for_edit").value = quill.root.innerHTML;
    });

	if (document.getElementById("description_textarea_description_for_edit").value) {	
		quill.root.innerHTML = document.getElementById("description_textarea_description_for_edit").value;
	}

    var toolbarOptions = [
		[{
			'header': [1, 2, 3, 4, 5, 6, false]
		}],
		['bold', 'italic', 'underline', 'strike'],
		[{
			'list': 'ordered'
		}, {
			'list': 'bullet'
		}],
	];


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


@endsection