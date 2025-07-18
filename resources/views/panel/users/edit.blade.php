@extends('panel.layouts.master')


@section('title' , 'ویرایش کاربر')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد کاربر</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.users.index')}}">
                    لیست کاربر ها
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش کاربر
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.users.index')}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.users.update',$user->id)}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">نام</p>
                        <input type="text" class="form-control" name="first_name" value="{{$user?->first_name}}">
                        @error('first_name')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">نام خانوادگی</p>
                        <input type="text" class="form-control" name="last_name" value="{{$user?->last_name}}">
                        @error('last_name')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">ایمیل</p>
                        <input type="email" class="form-control" name="email" value="{{$user?->email}}">
                        @error('email')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">شماره همراه</p>
                        <input type="number" class="form-control" name="phone" value="{{$user->phone}}">
                        @error('phone')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <p class="mg-b-10">آدرس</p>
                        <textarea class="form-control" name="address" rows="4">{{$user->address}}</textarea>
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