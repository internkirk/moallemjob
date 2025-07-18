@extends('panel.layouts.master')


@section('title' , 'لیست دوره ها')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست دوره ها</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست دوره ها</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.shop.course.create')}}" type="button" class="btn btn-primary my-2 btn-icon-text">
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
                    <table class="table table-bordered border-bottom" id="coursesTable">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>عنوان</span></th>
                                <th class="wd-lg-20p"><span>مدرس</span></th>
                                <th class="wd-lg-20p"><span>توضیحات کوتاه</span></th>
                                <th class="wd-lg-20p"><span>دسته بندی</span></th>
                                <th class="wd-lg-20p"><span>قیمت</span></th>
                                <th class="wd-lg-20p"><span>کلید ها</span></th>
                                <th class="wd-lg-20p"><span>وضعیت</span></th>
                                <th class="wd-lg-20p"><span>قسمت های دوره</span></th>
                                <th class="wd-lg-20p"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                            <tr>
                                <td>
                                    {{$course->title}}
                                </td>
                                <td>
                                    {{$course->teacher}}
                                </td>
                                <td>
                                    {!!Str::limit($course->short_description,80)!!}
                                </td>
                                <td>
                                    {{$course->category->title}}
                                </td>
                                <td>
                                    {{number_format($course->price)}}
                                </td>
                                <td>
                                    @foreach (json_decode($course->slug,true) as $key => $slug)
                                    <span class="badge bg-info">
                                        {{$slug}}
                                    </span>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($course->status)
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
                                    <a href="{{route('panel.shop.course.episode.index',$course->id)}}" class="btn btn-sm btn-warning">نمایش</a>
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.shop.course.edit',$course->id)}}"
                                        class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.shop.course.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$course->id}}" name="id">

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
            
        
               $('#coursesTable').DataTable({
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