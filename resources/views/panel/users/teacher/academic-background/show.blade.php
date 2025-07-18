@extends('panel.layouts.master')


@section('title' , 'سابقه تحصیلی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">سابقه تحصیلی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست معلمان</li>
            <li class="breadcrumb-item active" aria-current="page">سابقه تحصیلی</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.edit',$teacher->id)}}" type="button" class="btn btn-primary my-2 btn-icon-text">
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

                    @if (!is_null($academicBackground))
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>مقطع تحصیلی</span></th>
                                <th class="wd-lg-20p"><span>رشته تحصیلی</span></th>
                                <th class="wd-lg-20p"><span>دانشگاه</span></th>
                                <th class="wd-lg-20p"><span>معدل</span></th>
                                <th class="wd-lg-20p"><span>سال فارغ التحصیلی</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @if ($academicBackground->is_high_school)
                                    متوسطه
                                    @elseif($academicBackground->is_associate)
                                    کاردانی
                                    @elseif($academicBackground->is_bachelor)
                                    کارشناسی
                                    @elseif($academicBackground->is_master)
                                    کارشناسی ارشد
                                    @elseif($academicBackground->is_phd)
                                    دکترا و بالاتر
                                    @endif
                                </td>
                                <td>{{$academicBackground->major}}</td>
                                <td>
                                    {{$academicBackground->university}}
                                </td>
                                <td>
                                    {{$academicBackground->gpa}}
                                </td>

                                <td>
                                    {{$academicBackground->year_of_graduation}}
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.teacher.academic.background.edit',$teacher->id)}}"
                                        class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.teacher.academic.background.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$academicBackground->id}}" name="id">
                                        <input type="hidden" value="{{$teacher->id}}" name="teacher_id">

                                        <button type="submit" class="btn btn-sm btn-danger text-white">
                                            <span class="fe fe-trash">
                                            </span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @else
                    <div class="text-center p-5">
                        <h3 >
                            سابقه تحصیلی یافت نشد...
                        </h3>
                        <a href="{{route('panel.teacher.academic.background.create',$teacher->id)}}" type="button" class="btn btn-secondary btn-icon-text my-2 me-2" >ایجاد سابقه</a>
                    </div>
                    @endif

                   
                </div>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<!-- row closed  -->

@endsection