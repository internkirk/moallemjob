@extends('panel.layouts.master')


@section('title' , 'ادمین ها')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست ادمین ها</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست ادمین ها</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.admin.create')}}" type="button" class="btn btn-primary my-2 btn-icon-text">
                ایجاد ادمین
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
                <div class="table-responsive userlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0" id="adminsTable">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>نام</span></th>
                                <th class="wd-lg-20p"><span>نام خانوادگی</span></th>
                                <th class="wd-lg-20p"><span>ایمیل</span></th>
                                <th class="wd-lg-20p"><span>تلفن همراه</span></th>
                                <th class="wd-lg-20p"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                            <tr>
                                <td>{{$admin?->first_name}}</td>
                                <td>
                                    {{$admin?->last_name}}
                                </td>
                                <td>
                                    {{$admin?->email}}
                                </td>
                                <td>
                                    {{$admin->phone}}
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.admin.edit',$admin->id)}}" class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.admin.delete')}}" method="POST"
                                        onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$admin->id}}" name="id">

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
            
        
               $('#adminsTable').DataTable({
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