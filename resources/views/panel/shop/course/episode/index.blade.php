@extends('panel.layouts.master')


@section('title' , 'لیست اپیزود ها')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست اپیزود ها</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست اپیزود ها</li>
        </ol>
    </div>
    <div class="d-flex gap-2">
        <div class="justify-content-center">
            <a href="{{route('panel.shop.course.index')}}" type="button"
                class="btn btn-primary btn-icon-text my-2 me-2">
                بازگشت
            </a>
        </div>
        <div class="justify-content-center">
            <a href="{{route('panel.shop.course.episode.create',$course->id)}}" type="button"
                class="btn btn-primary my-2 btn-icon-text">
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
                    <table class="table table-bordered border-bottom" id="episodesTable">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>عنوان دوره</span></th>
                                <th class="wd-lg-8p"><span>عنوان</span></th>
                                <th class="wd-lg-20p"><span>توضیحات کوتاه</span></th>
                                <th class="wd-lg-20p"><span>مدت زمان</span></th>
                                <th class="wd-lg-20p"><span>وضعیت</span></th>
                                <th class="wd-lg-20p"><span>لینک ویدئو</span></th>
                                <th class="wd-lg-20p"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($episodes as $episode)
                            <tr>
                                <td>
                                    <a href="{{route('panel.shop.course.edit',$episode->course->id)}}">
                                        {{$episode->course->title}}
                                    </a>
                                </td>
                                <td>
                                    {{$episode->title}}
                                </td>
                                <td>
                                    {!!Str::limit($episode->short_description,80)!!}
                                </td>
                                <td>
                                    {{$episode->duration}}
                                </td>
                                <td>
                                    @if ($episode->status)
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
                                    <a href="{{route('panel.shop.course.episode.upload.video.index',$episode->id)}}"
                                        class="btn btn-outline-primary">بارگذاری</a>
                                    @if ($episode->link != NULL)
                                    <a href="{{route('panel.shop.course.episode.download.video',['id' => $episode->id, 'filename' => collect(explode('/',$episode->link))->last()])}}"
                                        class="btn btn-outline-success">دانلود</a>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('panel.shop.course.episode.edit',['id' =>$episode->id])}}"
                                        class="btn btn-sm btn-info">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
                                    <form action="{{route('panel.shop.course.episode.delete',$episode->course_id)}}"
                                        method="POST" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf
                                        <input type="hidden" value="{{$episode->id}}" name="id">

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
            
        
               $('#episodesTable').DataTable({
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