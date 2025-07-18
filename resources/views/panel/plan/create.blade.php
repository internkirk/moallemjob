@extends('panel.layouts.master')


@section('title' , 'ایجاد پلن')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">ایجاد پلن</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item"> <a href="{{route('panel.plan.index')}}">
                    لیست پلن ها
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                ایجاد
            </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.plan.index')}}" type="button" class="btn btn-primary btn-icon-text my-2 me-2">
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
                <form action="{{route('panel.plan.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">عنوان</p>
                        <input type="text" class="form-control" name="title">
                        @error('title')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">قیمت</p>
                        <input type="number" class="form-control" name="price">
                        @error('price')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">وضعیت</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="status"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="status" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('status')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">پکیج پیشنهادی</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="is_suggested"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="is_suggested" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('is_suggested')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">زمان انقضا آگهی</p>
                        <input type="number" class="form-control" name="declaration_expire_days">
                        @error('declaration_expire_days')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">تعداد آگهی استخدام</p>
                        <input type="text" class="form-control" name="recruitment_declaration_quantity">
                        @error('recruitment_declaration_quantity')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10"> تعداد  شغل های برجسته</p>
                        <input type="number" class="form-control" name="outstanding_job_quantity">
                        @error('outstanding_job_quantity')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10"> انقضا برجسته بودن آگهی (به تعداد روز وارد شود)</p>
                        <input type="number" class="form-control" name="outstanding_job_expire_time">
                        @error('outstanding_job_expire_time')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10"> انقضا برچسب فوری آگهی (به تعداد روز وارد شود)</p>
                        <input type="number" class="form-control" name="urgent_lable_expire_time">
                        @error('urgent_lable_expire_time')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">اطلاع رسانی در تلگرام</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="telegram_declaration"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="telegram_declaration" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('telegram_declaration')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">اطلاع رسانی با ایمیل</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="email_declaration"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="email_declaration" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('email_declaration')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">اطلاع رسانی با پیامک</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="sms_declaration"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="sms_declaration" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('sms_declaration')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10"> تعداد  رزومه های پیشنهادی</p>
                        <input type="number" class="form-control" name="suggested_resume_quantity">
                        @error('suggested_resume_quantity')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">پشتیبانی 24/7</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="is_full_time_support"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="is_full_time_support" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('is_full_time_support')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">نمایش متمایز آگهی و درج برچسب فوری</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="is_suggested_resume"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="is_suggested_resume" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('is_suggested_resume')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">احتمال نمایش در نتایج جستجو</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="possibility_in_search_results"  type="radio" value="1/5"> <span>یک و نیم برابر</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="possibility_in_search_results"  type="radio" value="2"> <span>دو برابر</span></label>
                            </div>
                        </div>
                        @error('possibility_in_search_results')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">احتمال بازدید بیشتر توسط کارجویان</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="possibility_to_visit_by_job_seekers"  type="radio" value="1/5"> <span>یک و نیم برابر</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="possibility_to_visit_by_job_seekers"  type="radio" value="2"> <span>دو برابر</span></label>
                            </div>
                        </div>
                        @error('possibility_to_visit_by_job_seekers')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">مشاهده آمار و تحلیل های مربوط به آگهی ها</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="show_declaration_analytics"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="show_declaration_analytics" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('show_declaration_analytics')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">دسترسی به لیست معلمان برتر</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="access_to_best_teachers_list"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="access_to_best_teachers_list" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('access_to_best_teachers_list')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">طراحی پلن متناسب با نیاز های خاص کارفرما</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="design_specific_plan"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="design_specific_plan" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('design_specific_plan')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">مشاوره تخصصی در زمینه جذب معلم</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="specialized_advice"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="specialized_advice" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('specialized_advice')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">اضافه کردن ویژگی های خاص براساس درخواست</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="adding_specific_features"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="adding_specific_features" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('adding_specific_features')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">مشاوره نوشتن آگهی استخدام</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="recruitment_declaration_advice"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="recruitment_declaration_advice" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('recruitment_declaration_advice')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">پشتیبانی اختصاصی تا لحظه استخدام</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="recruitment_specific_support"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="recruitment_specific_support" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('recruitment_specific_support')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p class="mg-b-10">کمک به غربال گری رزومه های دریافتی</p>
                        <div class="col-lg-4 col-xl-3 d-flex gap-5">
                            <div>
                                <label class="rdiobox"><input name="screening_resume_support"  type="radio" value="true"> <span>فعال</span></label>
                            </div>
                            <div>
                                <label class="rdiobox"><input name="screening_resume_support" checked type="radio" value="false"> <span>غیرفعال</span></label>
                            </div>
                        </div>
                        @error('screening_resume_support')
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
<!-- INTERNAL QUILL JS -->
<script src="{{asset('assets/plugins/quill/quill.min.js')}}"></script>

<!-- INTERNAL FORM-EDITOR JS -->
<script src="{{asset('assets/js/form-editor.js')}}"></script>

<!-- INTERNAL FILEUPLOADERS JS -->
<script src="{{asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

<!-- INTERNALFANCY UPLOADER JS -->
{{-- <script src="{{asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script> --}}

<!-- INTERNAL FORM-ELEMENTS JS -->
<script src="{{asset('assets/js/advanced-form-elements.js')}}"></script>



@endsection