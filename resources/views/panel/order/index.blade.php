@extends('panel.layouts.master')


@section('title' , 'لیست سفارشات')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست سفارشات</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست سفارشات</li>
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
                        id="ordersTable">
                        <thead>
                            <tr>
                                <th class="wd-20p">کاربر</th>
                                <th class="wd-25p">پکیج</th>
                                <th class="wd-20p">قیمت</th>
                                <th class="wd-15p">کدپیگیری</th>
                                <th class="wd-20p">وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                            <tr>
                                <td>
                                    <a href="{{route('panel.users.edit',$order->user->id)}}">
                                        {{$order->user->first_name}} {{$order->user->last_name}}
                                    </a>
                                </td>
                                <td>{{$order->plan->title}}</td>
                                <td>{{number_format($order->price)}}</td>
                                <td>{{$order->code}}</td>
                                <td>
                                    @if ($order->status)
                                    <span class="badge bg-success">موفق</span>
                                    @else
                                    <span class="badge bg-danger">ناموفق</span>
                                    @endif
                                </td>
                                {{-- <td class="d-flex gap-2">
                                    <a href="{{route('panel.order.show',$order->id)}}" class="btn btn-sm btn-info">
                                        نمایش
                                    </a>
                                </td> --}}
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
            
               $('#ordersTable').DataTable({
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