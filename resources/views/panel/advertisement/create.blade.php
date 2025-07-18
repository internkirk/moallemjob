@extends('panel.layouts.master')


@section('title' , 'ایجاد آگهی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد آگهی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.advertisement.index')}}">
                    لیست آگهی ها
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ایجاد 
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.index')}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.advertisement.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">وضعیت آگهی</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="status"  type="radio" value="true"> <span>قابل نمایش</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="status" checked type="radio" value="false"> <span>پنهان</span></label>
                            </div>
                        </div>
                        @error('status')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">وضعیت برجسته بودن آگهی</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="is_featured"  type="radio" value="true"> <span>برجسته </span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="is_featured" checked type="radio" value="false"> <span>عادی</span></label>
                            </div>
                        </div>
                        @error('is_featured')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">وضعیت نمایش و درج برچسب فوری آگهی</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="is_urgent"  type="radio" value="true"> <span>فعال </span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="is_urgent" checked type="radio" value="false"> <span>غیر فعال</span></label>
                            </div>
                        </div>
                        @error('is_urgent')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">عنوان شغلی</p>
                        <input type="text" class="form-control" name="job_title">
                        @error('job_title')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">مقطع تحصیلی</p>
                        <input type="text" class="form-control" name="academic_level">
                        @error('academic_level')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">سمت</p>
                        <input type="text" class="form-control" name="school_role">
                        @error('school_role')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">پایه تحصیلی </p>
                        <input type="text" class="form-control" name="academic_section">
                        @error('academic_section')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">رشته </p>
                        <input type="text" class="form-control" name="major">
                        @error('major')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">نوع همکاری </p>
                        <input type="text" class="form-control" name="cooperation_type">
                        @error('cooperation_type')
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

<!-- INTERNAL FORM-ELEMENTS JS -->
<script src="{{asset('assets/js/advanced-form-elements.js')}}"></script>

@endsection