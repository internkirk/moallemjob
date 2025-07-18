@extends('panel.layouts.master')


@section('title' , 'ایجاد عنوان رشته')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد عنوان رشته</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.major.index')}}">
                    لیست عنوان رشته ها
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ایجاد 
            </li>
        </ol>
    </div>
    <div class="d-flex col-12 justify-content-end">
        <div class="justify-content-center">
            <a href="{{route('panel.major.index')}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.major.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">عنوان رشته</p>
                        <input type="text" class="form-control" name="title">
                        @error('title')
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