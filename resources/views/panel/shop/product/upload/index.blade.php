@extends('panel.layouts.master')


@section('title' , 'آپلود فایل')

@section('links')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.js"></script>

<style>
    /* Customize Dropzone container */
    #upload-form {
        border: 2px dashed #007bff;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
    }

    /* Customize Dropzone hover state */
    #upload-form.dz-drag-hover {
        border-color: #28a745;
        background: #e9ecef;
    }

    /* Customize Dropzone message */
    #upload-form .dz-message {
        font-size: 1.5rem;
        color: #6c757d;
        text-align: center;
        margin: 20px 0;
    }

    /* Customize Dropzone previews */
    #upload-form .dz-preview {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #dee2e6;
        background: #ffffff;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    /* Customize file name */
    #upload-form .dz-preview .dz-filename {
        font-weight: bold;
        color: #343a40;
    }

    /* Customize progress bar */
    #upload-form .dz-preview .dz-progress .dz-upload {
        background: #007bff;
    }

    /* Customize error message */
    #upload-form .dz-preview .dz-error-message {
        color: #dc3545;
        font-weight: bold;
    }
</style>
@endsection

@section('body')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">آپلود فایل</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel.index')}}">داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست محصولات </li>
        </ol>
    </div>
    <div class="d-flex">
        <div class="justify-content-center">
            <a href="{{route('panel.shop.product.index')}}" type="button" class="btn btn-primary my-2 btn-icon-text">
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
            <div class="card-body">
                <form id="upload-form" class="dropzone">
                    <!-- this is were the previews should be shown. -->
                    <div class="previews"></div>
                </form>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<!-- row closed  -->

@endsection


@section('scripts')




<script>
    Dropzone.options.uploadForm = { // The camelized version of the ID of the form element

// The configuration we've talked about above
url: '{{ route("panel.shop.product.upload.file.store") }}',
    method: 'post',
    chunking: true,
    forceChunking: true,
    chunkSize: 20 * 1024 * 1024, // 20 MB chunks
    dictDefaultMessage: 'لطفا فایل خود را وارد کنید',
    thumbnailWidth: 120,
    thumbnailHeight: 120,
    parallelChunkUploads: true,
    maxFilesize: 5048,

// The setting up of the dropzone
init: function() {
this.on('sending', function(file, xhr, formData) {
            formData.append("_token", '{{ csrf_token() }}');
            formData.append('productId', '{{$product->id}}')
});
}

}
</script>
@endsection