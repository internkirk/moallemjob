@extends('panel.layouts.master')


@section('title' , 'ویرایش شرایط تکمیلی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش شرایط تکمیلی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.advertisement.index')}}">
                    لیست آگهی ها
                </a>
            </li>
            <li class="breadcrumb-item"> <a
                    href="{{route('panel.advertisement.job.additional.condition.show',$advertisement->id)}}">
                    شرایط تکمیلی
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش شرایط تکمیلی
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.additional.condition.show',$advertisement->id)}}" type="button"
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
                <form action="{{route('panel.advertisement.job.additional.condition.update',$jobAdditionalCondition->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="advertisement_id" value="{{$advertisement->id}}">
                    <div class="form-group">
                        <p class="mg-b-10">اتمام خدمت سربازی یا معافیت</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="military_service" @if($jobAdditionalCondition->military_service) checked @endif type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="military_service" @if(!$jobAdditionalCondition->military_service) checked @endif type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('military_service')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">گواهی گزینش</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="selection_certificate" @if($jobAdditionalCondition->selection_certificate) checked @endif type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="selection_certificate" @if(!$jobAdditionalCondition->selection_certificate) checked @endif type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('selection_certificate')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">گواهی عدم سوء پیشینه</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="no_crime_certificate" @if($jobAdditionalCondition->no_crime_certificate) checked @endif type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="no_crime_certificate" @if(!$jobAdditionalCondition->no_crime_certificate) checked @endif type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('no_crime_certificate')
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