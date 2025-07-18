@extends('panel.layouts.master')


@section('title' , 'تعمیرکاران')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست  تعمیرکاران</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست تعمیرکاران</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.engineer.create')}}" type="button" class="btn btn-primary my-2 btn-icon-text">
                ایجاد تعمیرکار
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
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>نام</span></th>
                                <th class="wd-lg-20p"><span>نام خانوادگی</span></th>
                                <th class="wd-lg-20p"><span>ایمیل</span></th>
                                <th class="wd-lg-20p"><span>تلفن همراه</span></th>
                                <th class="wd-lg-20p"><span>حرفه</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($engineers as $engineer)
                            <tr>
                                <td>{{$engineer->first_name}}</td>
                                <td>
                                    {{$engineer->last_name}}
                                </td>
                                <td>
                                    {{$engineer->email}}
                                </td>
                                <td>
                                    {{$engineer->phone}}
                                </td>
                                <td>
                                    {{$engineer->profession}}
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.engineer.edit',$engineer->id)}}" class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.engineer.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$engineer->id}}" name="id">

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