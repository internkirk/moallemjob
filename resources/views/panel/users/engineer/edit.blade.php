@extends('panel.layouts.master')


@section('title' , 'ایجاد ادمین')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد ادمین</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.engineer.index')}}">
                    لیست ادمین ها
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ایجاد ادمین
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.engineer.index')}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.engineer.update',$engineer->id)}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">نام</p>
                        <input type="text" class="form-control" name="first_name" value="{{$engineer->first_name}}">
                        @error('first_name')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">نام خانوادگی</p>
                        <input type="text" class="form-control" name="last_name" value="{{$engineer->last_name}}">
                        @error('last_name')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">ایمیل</p>
                        <input type="email" class="form-control" name="email" value="{{$engineer->email}}">
                        @error('email')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">حوزه کاری</p>
                        <input type="text" class="form-control" name="profession" value="{{$engineer->profession}}">
                        @error('profession')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">شماره همراه</p>
                        <input type="number" class="form-control" name="phone" value="{{$engineer->phone}}">
                        @error('phone')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <p class="mg-b-10">آدرس</p>
                        <textarea class="form-control" name="address" rows="4">{{$engineer->address}}</textarea>
                        @error('address')
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