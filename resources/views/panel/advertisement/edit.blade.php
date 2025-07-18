@extends('panel.layouts.master')


@section('title' , 'ویرایش آگهی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش آگهی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.advertisement.index')}}">
                    لیست آگهی ها
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش 
            </li>
        </ol>
    </div>
    <div class="d-flex col-12 justify-content-end">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.requirements.show',$advertisement->advertisement_id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-1">
                شرایط احراز شغل
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.location.show',$advertisement->advertisement_id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-1">
                 موقعیت محل کار
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.salary.show',$advertisement->advertisement_id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-1">
                 حقوق و مزایا
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.background.show',$advertisement->advertisement_id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-1">
                 سابقه کار
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.additional.condition.show',$advertisement->advertisement_id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-1">
                 شرایط تکمیلی
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.education.show',$advertisement->advertisement_id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-1">
                 تحصیلات
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.soft.skill.show',$advertisement->advertisement_id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-1">
                 مهارت های نرم افزاری
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.description.show',$advertisement->advertisement_id)}}" type="button" class="btn  btn-secondary btn-icon-text my-2 me-1">
                 شرح شغلی
            </a>
        </div>
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
                <form action="{{route('panel.advertisement.update',$advertisement->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">وضعیت آگهی</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="status"  type="radio" value="true" @if($advertisement->advertisement->status) checked @endif> <span>قابل نمایش</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="status" @if(!$advertisement->advertisement->status) checked @endif type="radio" value="false"> <span>پنهان</span></label>
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
                                <label class="rdiobox"><input name="is_featured"  type="radio" value="true" @if($advertisement->advertisement->is_featured) checked @endif> <span>برجسته </span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="is_featured" @if(!$advertisement->advertisement->is_featured) checked @endif type="radio" value="false"> <span>عادی</span></label>
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
                                <label class="rdiobox"><input name="is_urgent"  type="radio" value="true" @if($advertisement->advertisement->is_urgent) checked @endif> <span>فعال </span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="is_urgent" @if(!$advertisement->advertisement->is_urgent) checked @endif type="radio" value="false"> <span>غیر فعال</span></label>
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
                        <input type="text" class="form-control" name="job_title" value="{{$advertisement->job_title}}">
                        @error('job_title')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">مقطع تحصیلی</p>
                        <input type="text" class="form-control" name="academic_level" value="{{$advertisement->academic_level}}">
                        @error('academic_level')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">سمت</p>
                        <input type="text" class="form-control" name="school_role" value="{{$advertisement->school_role}}">
                        @error('school_role')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">پایه تحصیلی </p>
                        <input type="text" class="form-control" name="academic_section" value="{{$advertisement->academic_section}}">
                        @error('academic_section')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">رشته </p>
                        <input type="text" class="form-control" name="major" value="{{$advertisement->major}}">
                        @error('major')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">نوع همکاری </p>
                        <input type="text" class="form-control" name="cooperation_type" value="{{$advertisement->cooperation_type}}">
                        @error('cooperation_type')
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
<!-- INTERNAL FORM-ELEMENTS JS -->
<script src="{{asset('assets/js/advanced-form-elements.js')}}"></script>

@endsection