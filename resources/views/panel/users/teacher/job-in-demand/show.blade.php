@extends('panel.layouts.master')


@section('title' , 'درخواست ها')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">درخواست ها</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست معلمان</li>
            <li class="breadcrumb-item active" aria-current="page">درخواست ها</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.teacher.edit',$teacher->id)}}" type="button"
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

                    @if ($jobInDemands->isNotEmpty())
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>رشته تحصیلی</span></th>
                                <th class="wd-lg-20p"><span> شهر</span></th>
                                <th class="wd-lg-20p"><span> استان</span></th>
                                <th class="wd-lg-20p"><span> حقوق درخواستی</span></th>
                                <th class="wd-lg-20p"><span> مقطع تحصیلی</span></th>
                                <th class="wd-lg-20p"><span> سمت</span></th>
                                <th class="wd-lg-20p"><span> نوع همکاری</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobInDemands as $key => $jobInDemand)
                            <tr>
                                <td>{{$jobInDemand->major}}</td>
                                <td>{{$jobInDemand->city}}</td>
                                <td>{{$jobInDemand->province}}</td>
                                <td>{{number_format($jobInDemand->salary)}}</td>
                                <td>
                                    @if ($jobInDemand->is_pre_school)
                                    پیش دبستانی
                                    @elseif($jobInDemand->is_elementary)
                                    ابتدایی
                                    @elseif($jobInDemand->is_middle_school)
                                    متوسطه اول
                                    @elseif($jobInDemand->is_high_school)
                                    متوسطه نظری
                                    @elseif($jobInDemand->is_techinical_college)
                                    هنرستان
                                    @elseif($jobInDemand->is_foreign_lan_teacher)
                                    مدرس زبان خارجی
                                    @elseif($jobInDemand->is_entrance_exam_teacher)
                                    مدرس کنکور
                                    @elseif($jobInDemand->is_academic_counsellor)
                                    مشاور تحصیلی و تربیتی
                                    @endif
                                </td>
                                <td>
                                    @if ($jobInDemand->is_manager)
                                    مدیر
                                    @elseif($jobInDemand->is_deputy)
                                    معاون
                                    @elseif($jobInDemand->is_couch)
                                     مربی
                                    @elseif($jobInDemand->is_teacher)
                                     آموزگار
                                    @elseif($jobInDemand->is_dabir)
                                    دبیر
                                    @elseif($jobInDemand->is_honar_amouz)
                                    هنرآموزگار
                                    @endif
                                </td>
                                <td>
                                    @if ($jobInDemand->is_full_time)
                                    تمام وقت
                                    @elseif($jobInDemand->is_half_time)
                                    نیمه وقت
                                    @elseif($jobInDemand->is_part_time)
                                     پاره وقت
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.teacher.job.in.demand.edit',[$teacher->id,$jobInDemand->id])}}"
                                        class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.teacher.job.in.demand.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$jobInDemand->id}}" name="id">
                                        <input type="hidden" value="{{$teacher->id}}" name="teacher_id">

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
                            درخواستی یافت نشد...
                        </h3>
                        <a href="{{route('panel.teacher.job.in.demand.create',$teacher->id)}}" type="button"
                            class="btn btn-secondary btn-icon-text my-2 me-2">ایجاد درخواست</a>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<!-- row closed  -->

@endsection