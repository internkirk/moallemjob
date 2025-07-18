@extends('panel.layouts.master')


@section('title' , 'اطلاعات تکمیلی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">اطلاعات تکمیلی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست آموزشگاه هل</li>
            <li class="breadcrumb-item active" aria-current="page">اطلاعات تکمیلی</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.academy.edit',$academy->id)}}" type="button"
                class="btn btn-primary my-2 btn-icon-text">
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
                @session("success")
                <ui>
                    <li class="alert alert-success">{{session('success')}}</li>
                </ui>
                @endsession
            </div>
            <div class="card-body">
                <div class="table-responsive border userlist-table">

                    @if ($informations->isNotEmpty())
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>سال تاسیس</span></th>
                                <th class="wd-lg-20p"><span> مجوز تاسیس</span></th>
                                <th class="wd-lg-20p"><span> مجوز راه اندازی</span></th>
                                <th class="wd-lg-20p"><span> تصویر نمایه</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($informations as $key => $information)
                            <tr>
                                <td>{{$information->establishment_year}}</td>
                                <td>
                                    <span class="main-img-user"><img alt="avatar" src="{{json_decode($information?->establishment_license_image,true)[0]}}"></span>
                                </td>
                                <td>
                                    <span class="main-img-user"><img alt="avatar" src="{{json_decode($information?->startup_license_image,true)[0]}}"></span>
                                </td>
                                <td>
                                    
                                    @if(json_decode($information?->profile_image,true) != NULL)
                                    <span class="main-img-user"><img alt="avatar" src="{{json_decode($information?->profile_image,true)[0]}}"></span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.academy.additional.informations.edit',[$academy->id,$information->id])}}"
                                        class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.academy.additional.informations.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$information->id}}" name="id">
                                        <input type="hidden" value="{{$academy->id}}" name="academy_id">

                                        <button type="submit" class="btn btn-sm btn-danger text-white">
                                            <span class="fe fe-trash">
                                            </span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center p-5">
                        <h3>
                            اطلاعاتی یافت نشد...
                        </h3>
                        <a href="{{route('panel.academy.additional.informations.create',$academy->id)}}" type="button"
                            class="btn btn-secondary btn-icon-text my-2 me-2">ایجاد </a>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<!-- row closed  -->

@endsection