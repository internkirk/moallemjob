@extends('panel.layouts.master')


@section('title' , 'نمایش فایل های ارسالی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">نمایش فایل های ارسالی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.prime.teacher.requests.index')}}">
                    لیست درخواست ها
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                نمایش فایل های ارسالی
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.prime.teacher.requests.index')}}" type="button"
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
                    <div class="form-group">
                        <p class="mg-b-10">تصاویر ارسالی</p>
                        @if (is_array(json_decode($request->files,true)))
                        <!--<ul id="lightgallery" class="list-unstyled row mb-0 mt-3" lg-event-uid>-->
                            @foreach (json_decode($request->files,true) as $key => $image )
                           {{-- <li class="col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3" data-responsive="{{$image}}"
                                data-src="{{$image}}" lg-event-uid="&amp;1">
                                <a href="javascript:void(0);" class="wd-100p">
                                    <img class="img-responsive" src="{{$image}}" alt="Thumb-1">
                                </a>
                            </li> --}}
                            
                            <a class="btn btn-warning" href="{{ json_decode($request->files,true)[0] }}">دانلود</a>
                            @endforeach
                        <!--</ul>-->
                        @endif
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

<!-- INTERNAL GALLERY JS -->
<script src="{{asset('assets/plugins/gallery/picturefill.js')}}"></script>
<script src="{{asset('assets/plugins/gallery/lightgallery.js')}}"></script>
<script src="{{asset('assets/plugins/gallery/lightgallery-1.js')}}"></script>
<script src="{{asset('assets/plugins/gallery/lg-pager.js')}}"></script>
<script src="{{asset('assets/plugins/gallery/lg-autoplay.js')}}"></script>
<script src="{{asset('assets/plugins/gallery/lg-fullscreen.js')}}"></script>
<script src="{{asset('assets/plugins/gallery/lg-zoom.js')}}"></script>
<script src="{{asset('assets/plugins/gallery/lg-hash.js')}}"></script>
<script src="{{asset('assets/plugins/gallery/lg-share.js')}}"></script>
@endsection