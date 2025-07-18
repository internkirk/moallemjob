@extends('panel.layouts.master')


@section('title' , 'ایجاد حقوق و مزایا')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد حقوق و مزایا</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.advertisement.index')}}">
                    لیست آگهی ها
                </a>
            </li>
            <li class="breadcrumb-item"> <a
                    href="{{route('panel.advertisement.job.salary.show',$advertisement->id)}}">
                    حقوق و مزایا
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ایجاد حقوق و مزایا
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.salary.show',$advertisement->id)}}" type="button"
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
                <form action="{{route('panel.advertisement.job.salary.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="advertisement_id" value="{{$advertisement->id}}">
                    <div class="form-group">
                        <p class="mg-b-10">حداقل حقوق</p>
                        <input type="number" class="form-control" name="min_salary">
                        @error('min_salary')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">حداکثر حقوق</p>
                        <input type="number" class="form-control" name="max_salary">
                        @error('max_salary')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">مزایا و تسهیلات</p>
                        <textarea type="text" class="form-control" name="benefits" rows="10" cols="10"></textarea>
                        @error('benefits')
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