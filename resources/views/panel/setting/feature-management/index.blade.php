@extends('panel.layouts.master')


@section('title' , 'لیست ویژگی ها')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست  ویژگی ها</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست ویژگی ها</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.feature.management.create')}}" type="button" class="btn btn-primary my-2 btn-icon-text">
                ایجاد 
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
                <ul>
                    <li class="alert alert-danger">
                        توجه کنید که به هیچ وجه یک ویژگی را حذف نکنید
                    </li>
                    <li class="alert alert-info">
                       صرفا آن را فعال یا غیر فعال کنید
                    </li>
                </ul>
            </div>
            <div class="card-header border-bottom-0 pb-0">
                @session("success")
                <ui>
                    <li class="alert alert-success">{{session('success')}}</li>
                </ui>
                @endsession
            </div>
            <div class="card-body">
                <div class="table-responsive border userlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>عنوان</span></th>
                                <th class="wd-lg-8p"><span>عنوان فارسی</span></th>
                                <th class="wd-lg-20p"><span>وضعیت</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($features as $feature)
                            <tr>
                                <td>{{$feature->feature}}</td>
                                <td>{{$feature->fa_title}}</td>
                                <td>
                                    @if ($feature->status)
                                    <span class="badge bg-success">فعال</span>
                                    @else    
                                    <span class="badge bg-danger">غیر فعال</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.feature.management.edit',$feature->id)}}" class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.feature.management.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$feature->id}}" name="id">

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
                </div>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<!-- row closed  -->

@endsection