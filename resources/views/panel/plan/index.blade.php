@extends('panel.layouts.master')


@section('title' , 'لیست پلن ها')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست پلن ها</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست پلن ها</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.plan.create')}}" type="button" class="btn btn-primary my-2 btn-icon-text">
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
                                <th class="wd-lg-8p"><span>وضعیت</span></th>
                                <th class="wd-lg-8p"><span>قیمت</span></th>
                                <th class="wd-lg-8p"><span> انقضا درج آگهی </span></th>
                                <th class="wd-lg-20p"><span> آگهی استخدام</span></th>
                                <th class="wd-lg-20p"><span>شغل های برجسته</span></th>
                                <th class="wd-lg-20p"><span>انقضا آگهی های برجسته</span></th>
                                <th class="wd-lg-20p"><span>اطلاع رسانی تلگرام</span></th>
                                <th class="wd-lg-20p"><span>اطلاع رسانی ایمیلی</span></th>
                                <th class="wd-lg-20p"><span>اطلاع رسانی پیامکی</span></th>
                                <th class="wd-lg-20p"><span>رزومه پیشنهادی</span></th>
                                <th class="wd-lg-20p"><span>پشتیبانی 24/7</span></th>
                                <th class="wd-lg-20p"><span>برچسب فوری</span></th>
                                <th class="wd-lg-20p"><span>نمایش بیشتر در نتایج جستجو</span></th>
                                <th class="wd-lg-20p"><span>بازدید بیشتر توسط کارجویان</span></th>
                                <th class="wd-lg-20p"><span>آمار و تحلیل آگهی ها</span></th>
                                <th class="wd-lg-20p"><span>دسترسی به معلمان برتر</span></th>
                                <th class="wd-lg-20p"><span>طراحی پلن اختصاصی</span></th>
                                <th class="wd-lg-20p"><span>مشاوره تخصصی جذب معلم</span></th>
                                <th class="wd-lg-20p"><span>ویژگی های خاص براساس درخواست</span></th>
                                <th class="wd-lg-20p"><span>مشاوره نوشتن آگهی استخدام</span></th>
                                <th class="wd-lg-20p"><span>پشتیبانی اختصاصی تا لحظه استخدام</span></th>
                                <th class="wd-lg-20p"><span>غربال گری رزومه های دریافتی</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plans as $plan)
                            <tr>
                                <td>{{$plan->title}}</td>
                                <td>
                                    @if ($plan->status)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                    {{number_format($plan->price)}}
                                </td>
                                <td>
                                    {{number_format($plan->declaration_expire_days)}}
                                </td>
                                <td>
                                    {{$plan->recruitment_declaration_quantity}}
                                </td>
                                <td>
                                    {{number_format($plan->outstanding_job_quantity)}}
                                </td>
                                <td>
                                    {{number_format($plan->outstanding_job_expire_time)}}
                                </td>
                                <td>
                                    @if ($plan->telegram_declaration)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($plan->email_declaration)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($plan->sms_declaration)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                    {{number_format($plan->suggested_resume_quantity)}}
                                </td>
                                <td>
                                    @if ($plan->is_full_time_support)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($plan->is_suggested_resume)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($plan->is_one_and_half_possibility_in_search_results == true)
                                    1/5 برابر
                                    @else
                                    2 برابر
                                    @endif
                                </td>
                                <td>
                                    @if ($plan->is_one_and_half_possibility_to_visit_by_job_seekers == true)
                                    1/5 برابر
                                    @else
                                    2 برابر
                                    @endif
                                </td>

                                <td>
                                    @if ($plan->show_declaration_analytics)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                     @if ($plan->access_to_best_teachers_list)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                     @if ($plan->design_specific_plan)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                     @if ($plan->specialized_advice)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                     @if ($plan->adding_specific_features)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                     @if ($plan->recruitment_declaration_advice)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                     @if ($plan->recruitment_specific_support)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td>
                                     @if ($plan->screening_resume_support)
                                    <span class="badge bg-success text-white">فعال</span>
                                    @else
                                    <span class="badge bg-danger text-white">غیر فعال</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.plan.edit',$plan->id)}}" class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.plan.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$plan->id}}" name="id">

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