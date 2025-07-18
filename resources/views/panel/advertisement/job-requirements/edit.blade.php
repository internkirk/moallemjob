@extends('panel.layouts.master')


@section('title' , 'ویرایش شرایط احراز شغل')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ویرایش شرایط احراز شغل</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.advertisement.index')}}">
                    لیست آگهی ها
                </a>
            </li>
            <li class="breadcrumb-item"> <a
                    href="{{route('panel.advertisement.job.requirements.show',$advertisement->id)}}">
                    شرایط احراز شغل
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ویرایش شرایط احراز شغل
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.job.requirements.show',$advertisement->id)}}" type="button"
                class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.advertisement.job.requirements.update',$jobRequirements->id)}}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="advertisement_id" value="{{$advertisement->id}}">
                    <div class="col-lg-12 mg-t-20 ">
                        <p class="mg-b-10">حداقل سن</p>
                        <select class="form-control select2-with-search" name="min_age">
                            <option label="Choose one">
                            </option>
                            <option value="تفاوتی ندارد" @if ($jobRequirements->min_age == 'تفاوتی ندارد')
                                selected
                                @endif
                                >
                                تفاوتی ندارد
                            </option>
                            <option value="بازه 18 الی 50" @if ($jobRequirements->min_age == 'بازه 18 الی 50')
                                selected
                                @endif
                                >
                                بازه 18 الی 50
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-12 mg-t-20 ">
                        <p class="mg-b-10">حداکثر سن</p>
                        <select class="form-control select2-with-search" name="max_age">
                            <option label="Choose one">
                            </option>
                            <option value="تفاوتی ندارد" @if ($jobRequirements->max_age == 'تفاوتی ندارد')
                                selected
                                @endif
                                >
                                تفاوتی ندارد
                            </option>
                            <option value="بازه 18 الی 60" @if ($jobRequirements->max_age == 'بازه 18 الی 60')
                                selected
                                @endif
                                >
                                بازه 18 الی 60
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-12 mg-t-20">
                        <p class="mg-b-10">جنسیت</p>
                        <select class="form-control select2-with-search" name="sex">
                            <option label="Choose one">
                            </option>
                            <option value="ترجیحا خانم" @if ($jobRequirements->sex == 'ترجیحا خانم')
                                selected
                                @endif
                                >
                                ترجیحا خانم
                            </option>
                            <option value="ترجیحا آقا" @if ($jobRequirements->sex == 'ترجیحا آقا')
                                selected
                                @endif>
                                ترجیحا آقا
                            </option>
                            <option value="فقط خانم" @if ($jobRequirements->sex == 'فقط خانم')
                                selected
                                @endif>
                                فقط خانم
                            </option>
                            <option value="فقط آقا" @if ($jobRequirements->sex == 'فقط آقا')
                                selected
                                @endif>
                                فقط آقا
                            </option>
                            <option value="تفاوتی ندارد" @if ($jobRequirements->sex == 'تفاوتی ندارد')
                                selected
                                @endif>
                                تفاوتی ندارد
                            </option>
                        </select>
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

@section('scripts')

<!-- INTERNAL FORM-ELEMENTS JS -->
<script src="{{asset('assets/js/advanced-form-elements.js')}}"></script>

@endsection