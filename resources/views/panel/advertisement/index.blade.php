@extends('panel.layouts.master')


@section('title' , 'لیست آگهی ها')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست آگهی ها</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست آگهی ها</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.advertisement.create')}}" type="button" class="btn btn-primary my-2 btn-icon-text">
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
                <div class="table-responsive">
                    <table class="table table-bordered border-bottom" id="advertisementTable">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>ثبت کننده آگهی</span></th>
                                <th class="wd-lg-20p"><span>عنوان شغل</span></th>
                                <th class="wd-lg-20p"><span>مقطع تحصیلی</span></th>
                                <th class="wd-lg-20p"><span>سمت</span></th>
                                <th class="wd-lg-20p"><span>پایه تحصیلی</span></th>
                                <th class="wd-lg-20p"><span>رشته</span></th>
                                <th class="wd-lg-20p"><span>نوع همکاری</span></th>
                                <th class="wd-lg-20p"><span>وضعیت</span></th>
                                <th class="wd-lg-20p"><span>برجسته</span></th>
                                <th class="wd-lg-20p"><span>برچسب فوری</span></th>
                                <th class="wd-lg-20p"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($advertisements as $advertisement)
                            <tr>
                                <td>
                                    @if ($advertisement->advertisement->user->first_name && $advertisement->advertisement->user->last_name)    
                                    <a href="{{route('panel.users.edit',$advertisement->advertisement->user->id)}}">
                                        {{$advertisement->advertisement->user->first_name}}
                                        {{$advertisement->advertisement->user->last_name}}
                                    </a>
                                    @else
                                    <a href="{{route('panel.users.edit',$advertisement->advertisement->user->id)}}">
                                        {{$advertisement->advertisement->user->phone}}
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    {{$advertisement->job_title}}
                                </td>
                                <td>
                                    {{$advertisement->academic_level}}
                                </td>
                                <td>
                                    {{$advertisement->school_role}}
                                </td>
                                <td>
                                    {{$advertisement->academic_section}}
                                </td>
                                <td>
                                    {{$advertisement->major}}
                                </td>
                                <td>
                                    {{$advertisement->cooperation_type}}
                                </td>
                                <td>
                                    @if ($advertisement->advertisement->status)
                                    <span class="badge bg-success text-white">
                                        قابل نمایش
                                    </span>
                                    @else
                                    <span class="badge bg-danger text-white">
                                        پنهان
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($advertisement->advertisement->is_featured)
                                    <span class="badge bg-success text-white">
                                       برجسته
                                    </span>
                                    @else
                                    <span class="badge bg-danger text-white">
                                        عادی
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($advertisement->advertisement->is_urgent)
                                    <span class="badge bg-success text-white">
                                       فعال
                                    </span>
                                    @else
                                    <span class="badge bg-danger text-white">
                                        غیر فعال
                                    </span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.advertisement.edit',$advertisement->advertisement_id)}}"
                                        class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.advertisement.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$advertisement->id}}" name="id">

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


@section('scripts')

<!-- INTERNAL DATA TABLE JS -->
<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/js/table-data.js')}}"></script>
<script src="{{asset('assets/js/select2.js')}}"></script>


<script>

        $(function () {
               'use strict'
            
        
               $('#advertisementTable').DataTable({
                //    responsive: true,
                   language: {
                       searchPlaceholder: 'Search...',
                       sSearch: '',
                       lengthMenu: '_MENU_ items/page',
                    }
                });
            })
        
</script>
@endsection