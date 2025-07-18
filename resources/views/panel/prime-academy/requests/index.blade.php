@extends('panel.layouts.master')


@section('title' , 'لیست درخواست ها')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست درخواست ها</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست درخواست ها</li>
        </ol>
    </div>
    <div class="d-flex">
        {{-- <div class="justify-content-center">
            <a href="{{route('panel.plan.create')}}" type="button" class="btn btn-primary my-2 btn-icon-text">
                ایجاد
            </a>
        </div> --}}
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
                    <table class="table table-bordered card-table table-striped table-vcenter text-nowrap mb-0"
                        id="requestsTable">
                        <thead>
                            <tr>
                                <th class="wd-20p">آموزشگاه</th>
                                <th class="wd-25p">فایل های ارسالی</th>
                                <th class="wd-20p">وضعیت</th>
                                <th class="wd-20p">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $key => $request)
                            <tr>
                                <td>
                                    <a href="{{route('panel.academy.edit',$request->academy->id)}}">
                                        {{$request->academy->name}}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('panel.prime.academy.requests.show',$request->id)}}" class="btn btn-warning">نمایش فایل ها</a>
                                </td>
                                <td>
                                    @if ($request->status)
                                    <span class="badge bg-success">موفق</span>
                                    @else
                                    <span class="badge bg-danger">ناموفق</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.prime.academy.requests.edit',$request->id)}}" class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.prime.academy.requests.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$request->id}}" name="id">

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
            
               $('#requestsTable').DataTable({
                   responsive: true,
                   language: {
                       searchPlaceholder: 'Search...',
                       sSearch: '',
                       lengthMenu: '_MENU_ items/page',
                    }
                });
            })
    </script>
    @endsection