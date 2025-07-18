@extends('panel.layouts.master')


@section('title' , 'لیست تیکت ها')


@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">لیست تیکت ها</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست تیکت ها</li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.pro.resume.request.index')}}" type="button"
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
            <div class="card-body" style="height: 500px; overflow-y: scroll;background-color: rgb(245, 245, 245)">
                {{-- @dd($tickets) --}}
                @foreach ($tickets as $ticket)
                <div class="mt-5 border border-b p-3 rounded-3 bg-white">
                    @if (!$ticket->is_admin)
                    <a href="{{route('panel.teacher.edit',$ticket->request->teacher->id)}}">
                        <p>{{$ticket->request->teacher->first_name}} {{$ticket->request->teacher->last_name}}</p>
                    </a>
                    @else
                    <span class="bg-primary p-1 rounded-3">ادمین</span>
                    @endif
                    <hr>
                    <p>{{$ticket->text}}</p>
                    <hr>
                    @if ($ticket->file != NULL)
                    <a href="{{json_decode($ticket->file)[0]}}" class="btn btn-info">فایل ضمیمه</a>
                    @endif
                </div>
                @endforeach
            </div>
            <hr>
            <div class="border border-t">
                <form class="py-3" action="{{route('panel.pro.resume.ticket.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="request_id" value="{{$request_id}}">
                    <div class="form-group d-flex">
                        <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                            <p class="mg-b-10"> فایل ضمیمه</p>
                            <input type="file" class="dropify" name="file">
                        </div>
                        @error('file')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>

                    <div class="form-group mb-5">
                        <div class="col-sm-12 col-md-12 mt-lg-0 mt-3">
                            <p class="mg-b-10">پاسخ</p>
                            <textarea class="form-control" rows="10" cols="10" name="text"></textarea>
                        </div>
                        @error('text')
                        <ui>
                            <li class="alert alert-danger">{{$message}}</li>
                        </ui>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <button class="btn ripple btn-main-primary btn-block" type="submit">ارسال</button>
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
{{-- <script src="{{asset('assets/js/form-editor.js')}}"></script> --}}

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