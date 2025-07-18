@extends('panel.layouts.master')


@section('title' , 'سابقه کار')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">سابقه کار</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست آگهی ها</li>
            <li class="breadcrumb-item active" aria-current="page">سابقه کار آگهی</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.edit',$advertisement->id)}}" type="button"
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

                    @if ($jobBackgrounds->isNotEmpty())
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-20p"><span>جذب به عنوان کارآموز</span></th>
                                <th class="wd-lg-20p"><span>داشتن سابقه کار الزامی است</span></th>
                                <th class="wd-lg-20p"><span> میزان سابقه</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobBackgrounds as $key => $jobBackground)
                            <tr>
                                <td>{{$jobBackground->as_intern ? "فعال" : "غیرفعال"}}</td>
                                <td>{{$jobBackground->must_have_background ? "فعال" : "غیرفعال"}}</td>
                                <td>{{Str::limit($jobBackground->background,80)}}</td>
                                
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.advertisement.job.background.edit',[$advertisement->id,$jobBackground->id])}}"
                                        class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.advertisement.job.background.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$jobBackground->id}}" name="id">
                                        <input type="hidden" value="{{$advertisement->id}}" name="advertisement_id">

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
                            سابقه ای یافت نشد...
                        </h3>
                        <a href="{{route('panel.advertisement.job.background.create',$advertisement->id)}}" type="button"
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