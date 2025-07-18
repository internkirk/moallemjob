@extends('panel.layouts.master')


@section('title' , 'سابقه شغلی')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">سابقه شغلی</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست معلمان</li>
            <li class="breadcrumb-item active" aria-current="page">سابقه شغلی</li>
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

                    @if ($jobBackgrounds->isNotEmpty())
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>رشته تحصیلی</span></th>
                                <th class="wd-lg-20p"><span> شهر</span></th>
                                <th class="wd-lg-20p"><span> آموزشگاه</span></th>
                                <th class="wd-lg-20p"><span> سال شروع</span></th>
                                <th class="wd-lg-20p"><span> سال پایان</span></th>
                                <th class="wd-lg-20p"><span> مقطع تحصیلی</span></th>
                                <th class="wd-lg-20p"><span> سمت</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobBackgrounds as $key => $jobBackground)
                            <tr>
                                <td>{{$jobBackground->major}}</td>
                                <td>{{$jobBackground->city}}</td>
                                <td>{{$jobBackground->school}}</td>
                                <td>{{$jobBackground->start_year}}</td>
                                <td>{{$jobBackground->end_year}}</td>
                                <td>
                                    @if ($jobBackground->is_pre_school)
                                    پیش دبستانی
                                    @elseif($jobBackground->is_elementary)
                                    ابتدایی
                                    @elseif($jobBackground->is_middle_school)
                                    متوسطه اول
                                    @elseif($jobBackground->is_high_school)
                                    متوسطه نظری
                                    @elseif($jobBackground->is_techinical_college)
                                    هنرستان
                                    @elseif($jobBackground->is_foreign_lan_teacher)
                                    مدرس زبان خارجی
                                    @elseif($jobBackground->is_entrance_exam_teacher)
                                    مدرس کنکور
                                    @elseif($jobBackground->is_academic_counsellor)
                                    مشاور تحصیلی و تربیتی
                                    @endif
                                </td>
                                <td>
                                    @if ($jobBackground->is_manager)
                                    مدیر
                                    @elseif($jobBackground->is_deputy)
                                    معاون
                                    @elseif($jobBackground->is_couch)
                                    مربی
                                    @elseif($jobBackground->is_teacher)
                                    آموزگار
                                    @elseif($jobBackground->is_dabir)
                                    دبیر
                                    @elseif($jobBackground->is_honar_amouz)
                                    هنرآموزگار
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.teacher.job.background.edit',[$teacher->id,$jobBackground->id])}}"
                                        class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.teacher.job.background.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$jobBackground->id}}" name="id">
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
                            سابقه ای یافت نشد...
                        </h3>
                        <a href="{{route('panel.teacher.job.background.create',$teacher->id)}}" type="button"
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