@extends('panel.layouts.master')


@section('title' , 'ویرایش سابقه کار')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش سابقه کار</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.advertisement.index')}}">
                    لیست آگهی ها
                </a>
            </li>
            <li class="breadcrumb-item"> <a
                    href="{{route('panel.advertisement.job.background.show',$advertisement->id)}}">
                    سابقه کار
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش سابقه کار
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.background.show',$advertisement->id)}}" type="button"
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
                <form action="{{route('panel.advertisement.job.background.update',$jobBackground->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="advertisement_id" value="{{$advertisement->id}}">
                    <div class="form-group">
                        <p class="mg-b-10">جذب به عنوان کارآموز</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="as_intern" type="radio" value="true" @if($jobBackground->as_intern) checked @endif>
                                    <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="as_intern" @if(!$jobBackground->as_intern) checked @endif type="radio" value="false">
                                    <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('as_intern')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">داشتن سابقه کار الزامی است</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="must_have_background" type="radio" value="true" @if($jobBackground->must_have_background) checked @endif>
                                    <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="must_have_background" type="radio"
                                        value="false"  @if(!$jobBackground->must_have_background) checked @endif> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('must_have_background')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">میزان سابقه</p>
                        <textarea type="text" class="form-control" name="background" rows="10" cols="10">{{$jobBackground->background}}</textarea>
                        @error('background')
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