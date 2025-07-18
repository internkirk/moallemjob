@extends('panel.layouts.master')


@section('title' , 'ویرایش اطلاعات تکمیلی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش اطلاعات تکمیلی</h2>
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
                ویرایش اطلاعات تکمیلی
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
                <form action="{{route('panel.academy.additional.informations.update',$information->id)}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="academy_id" value="{{$academy->id}}">
                    <div class="form-group">
                        <p class="mg-b-10">سال تاسیس</p>
                        <input type="text" class="form-control" name="establishment_year"
                            value="{{$information->establishment_year}}">
                        @error('establishment_year')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="d-flex col-12">
                            <div class="col-8">
                                <p class="mg-b-10">تصویر مجوز تاسیس</p>
                                <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                                    <input type="file" class="dropify" name="establishment_license_image">
                                </div>
                            </div>
                            <div>
                                @if (is_array(json_decode($information->establishment_license_image,true)))
                                <ul id="lightgallery-1" class="list-unstyled row mb-0 mt-3" lg-event-uid>
                                    @foreach (json_decode($information->establishment_license_image,true) as $key => $image )
                                    <li class="col-xs-6 col-sm-8 col-md-8 col-xl-8 mb-3" data-responsive="{{$image}}"
                                    data-src="{{$image}}" lg-event-uid="&amp;1">
                                    <a href="javascript:void(0);" class="wd-100p">
                                        <img class="img-responsive" src="{{$image}}" alt="Thumb-1">
                                    </a>
                                </li>
                                @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        @error('establishment_license_image ')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="d-flex col-12">
                            <div class="col-8">
                                <p class="mg-b-10">تصویر مجوز راه اندازی</p>
                                <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                                    <input type="file" class="dropify" name="startup_license_image">
                                </div>
                            </div>
                            <div>
                                @if (is_array(json_decode($information->startup_license_image,true)))
                                <ul id="lightgallery-2" class="list-unstyled row mb-0 mt-3" lg-event-uid>
                                    @foreach (json_decode($information->startup_license_image,true) as $key => $image)
                                    <li class="col-xs-6 col-sm-8 col-md-8 col-xl-8 mb-3" data-responsive="{{$image}}"
                                    data-src="{{$image}}" lg-event-uid="&amp;1">
                                    <a href="javascript:void(0);" class="wd-100p">
                                        <img class="img-responsive" src="{{$image}}" alt="Thumb-1">
                                    </a>
                                </li>
                                @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>


                        @error('startup_license_image')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="d-flex col-12">
                            <div class="col-8">
                                <p class="mg-b-10">تصویر نمایه</p>
                                <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                                    <input type="file" class="dropify" name="profile_image">
                                </div>
                            </div>
                            <div>
                                @if (is_array(json_decode($information->profile_image,true)))
                                <ul id="lightgallery-3" class="list-unstyled row mb-0 mt-3" lg-event-uid>
                                    @foreach (json_decode($information->profile_image,true) as $key => $image )
                                    <li class="col-xs-6 col-sm-8 col-md-8 col-xl-8 mb-3" data-responsive="{{$image}}"
                                    data-src="{{$image}}" lg-event-uid="&amp;1">
                                    <a href="javascript:void(0);" class="wd-100p">
                                        <img class="img-responsive" src="{{$image}}" alt="Thumb-1">
                                    </a>
                                </li>
                                @endforeach
                                </ul>
                                @endif
                            </div>
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
                        @if (is_array(json_decode($information->school_image,true)))
                        <ul id="lightgallery" class="list-unstyled row mb-0 mt-3" lg-event-uid>
                            @foreach (json_decode($information->school_image,true) as $key => $image )
                            <li class="col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3" data-responsive="{{$image}}"
                                data-src="{{$image}}" lg-event-uid="&amp;1">
                                <a href="javascript:void(0);" class="wd-100p">
                                    <img class="img-responsive" src="{{$image}}" alt="Thumb-1">
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        @error('school_image[]')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <p class="mg-b-10">مزایا و تسهیلات سازمانی </p>
                        <textarea class="form-control" name="benefits" rows="10">{{$information->benefits}}</textarea>
                        @error('benefits')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mt-4">
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