@extends('panel.layouts.master')


@section('title' , 'ویرایش آموزشگاه')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش آموزشگاه</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.academy.index')}}">
                    لیست آموزشگاه
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش 
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.academy.additional.informations.show',$academy->id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-2">
                   اطلاعات تکمیلی
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.academy.index')}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.academy.update',$academy->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-lg-12 mg-b-20">
                        <p class="mg-b-10">کاربر</p>
                        <select class="form-control select2-with-search" name="user_id">
                            <option label="Choose one">
                            </option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}" @if($academy->user_id == $user->id) selected @endif>
                                {{$user->first_name}} {{$user->last_name}} , ID  =>  {{$user->id}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">ویژه بودن آموزشگاه</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="chbox"><input name="is_prime_academy"  type="checkbox" value="true" @if($academy->isPrime()) checked @endif> <span>فعال</span></label>
                            </div>
                        </div>
                        @error('is_prime_academy')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">نام</p>
                        <input type="text" class="form-control" name="name" value="{{$academy->name}}">
                        @error('name')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">شماره همراه</p>
                        <input type="number" class="form-control" name="phone" value="{{$academy->phone}}">
                        @error('phone')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">تعداد دانش آموزان</p>
                        <input type="number" class="form-control" name="students_number" value="{{$academy->students_number}}">
                        @error('students_number')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">آدرس وب سایت</p>
                        <input type="text" class="form-control" name="website" value="{{$academy->website}}">
                        @error('website')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">شهر</p>
                        <input type="text" class="form-control" name="city" value="{{$academy->city}}">
                        @error('city')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">استان</p>
                        <input type="text" class="form-control" name="province" value="{{$academy->province}}">
                        @error('province')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group d-flex">
                        <div class="col-sm-6 col-md-6 mt-lg-0 mt-3">
                            <p class="mg-b-10"> لوگو آموزشگاه</p>
                            <input type="file" class="dropify" name="logo">
                        </div>
                        <div>
                            <img src="{{json_decode($academy->logo,true)[0]}}" width="250px" height="250px" alt="">
                        </div>
                        @error('logo')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-5">
                        <p class="mg-b-10">توضیحات کوتاه</p>
                        <textarea class="form-control" name="short_description" rows="10">{{$academy->short_description}}</textarea>
                        @error('short_description')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <p class="mg-b-10">توضیحات </p>
                        <textarea class="form-control" name="description" rows="10">{{$academy->description}}</textarea>
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



@endsection