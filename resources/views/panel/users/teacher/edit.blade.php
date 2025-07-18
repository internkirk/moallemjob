@extends('panel.layouts.master')


@section('title' , 'ویرایش معلم')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش معلم</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.teacher.index')}}">
                    لیست معلمان
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ایجاد 
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.academic.background.show',$teacher->id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-2">
                سوابق تحصیلی
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.job.background.show',$teacher->id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-2">
                سوابق شغلی
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.skill.show',$teacher->id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-2">
                 مهارت ها
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.job.in.demand.show',$teacher->id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-2">
                  مشاغل درخواستی
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.index')}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.teacher.update',$teacher->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 mg-b-20">
                        <p class="mg-b-10">کاربر</p>
                        <select class="form-control select2-with-search" name="user_id">
                            <option label="Choose one">
                            </option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}" @if($teacher->user_id == $user->id) selected @endif>
                                {{$user->first_name}} {{$user->last_name}} , ID  =>  {{$user->id}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">نام</p>
                        <input type="text" class="form-control" name="first_name" value="{{$teacher->first_name}}">
                        @error('first_name')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">نام خانوادگی</p>
                        <input type="text" class="form-control" name="last_name" value="{{$teacher->last_name}}">
                        @error('last_name')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">جنسیت</p>
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_male" type="checkbox" @if($teacher->is_male) checked @endif> <span>مرد </span></label>
                        </div>
                        @error('is_male')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">وضعیت تاهل</p>
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_single" type="checkbox" @if($teacher->is_single) checked @endif> <span>مجرد </span></label>
                        </div>
                        @error('is_single')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">سن</p>
                        <input type="number" class="form-control" name="age" value="{{$teacher->age}}">
                        @error('age')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">ایمیل</p>
                        <input type="email" class="form-control" name="email" value="{{$teacher->email}}">
                        @error('email')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">شماره همراه</p>
                        <input type="number" class="form-control" name="phone" value="{{$teacher->phone}}">
                        @error('phone')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">شهر</p>
                        <input type="text" class="form-control" name="city" value="{{$teacher->city}}">
                        @error('city')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">استان</p>
                        <input type="text" class="form-control" name="province" value="{{$teacher->province}}">
                        @error('province')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">وضعیت گزینش</p>
                        <div class="col-lg-4 col-xl-3">
                            <label class="ckbox"><input name="is_selected" type="checkbox" @if($teacher->is_selected) checked @endif> <span>دارد </span></label>
                        </div>
                        @error('is_selected')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    @if (is_array(json_decode($teacher->selection_image,true)))
                        <ul id="lightgallery" class="list-unstyled row mb-0 mt-3" lg-event-uid>
                            @foreach (json_decode($teacher->selection_image,true) as $key => $image )
                            <li class="col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3" data-responsive="{{$image}}"
                                data-src="{{$image}}" lg-event-uid="&amp;1">
                                <a href="javascript:void(0);" class="wd-100p">
                                    <img class="img-responsive" src="{{$image}}" alt="Thumb-1">
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        <div class="form-group">
                            <p class="mg-b-10">  تصویر گزینش</p>
                            <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                                <input type="file" class="dropify" name="selection_image" >
                            </div>
                            @error('selection_image')
                            <ui>
                                <li class="alert alert-danger">{{$message}}</li>
                            </ui>
                            @enderror
                        </div>
                    <div class="form-group">
                        <p class="mg-b-10"> تصویر</p>
                        <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                            <input type="file" class="dropify" name="avatar" >
                        </div>
                        @if (is_array(json_decode($teacher->avatar,true)))
                        <ul id="lightgallery-1" class="list-unstyled row mb-0 mt-3" lg-event-uid>
                            @foreach (json_decode($teacher->avatar,true) as $key => $image )
                            <li class="col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3" data-responsive="{{$image}}"
                                data-src="{{$image}}" lg-event-uid="&amp;1">
                                <a href="javascript:void(0);" class="wd-100p">
                                    <img class="img-responsive" src="{{$image}}" alt="Thumb-1">
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        {{-- <ul>
                            <li class="my-2">
                                <img src="{{json_decode($teacher->avatar,true)[0]}}" width="250px" height="250px" alt="">
                            </li>
                        </ul> --}}
                        @error('avatar')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <p class="mg-b-10">توضیحات</p>
                        <textarea class="form-control" name="description" rows="4">{{$teacher->description}}</textarea>
                        @error('description')
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