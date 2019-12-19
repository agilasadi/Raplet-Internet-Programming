@extends('layouts.app')

@section('style')
    <link href="{{ asset('mycss/profile.css') }}" rel="stylesheet">
    <link href="{{ asset('mycss/addHeaders.css') }}" rel="stylesheet">
    @if($post->type == 1)
        <style>
            .uploadingPostPreview{
                display: block;
            }
            .file-upload-content {
                display: block;
            }
            .image-upload-wrap{
                display: none;
            }
        </style>
    @endif
@endsection

@section('pageHeaders')
    <title>{{ trans('home.rapletEditHeader') }}</title>
@endsection

@section('content')
    <div class="container">
        <div class="form-group position-relative">
            <label for="editablePostField">{{ trans('home.header') }}:</label>
            <input type="text" class="form-control headerEnteringInputField" id="editablePostField"  value="{{ $post->content }}" placeholder="{{ trans('home.header') }}">

            <button class="transitionSlow addImageBtn"><i class="far fa-image"></i></button>

            <div class="file-upload box-shadow">
                <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><i class="fas fa-folder-open"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.choosImage') }}</button>

                <div class="image-upload-wrap">
                    <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />
                    <div class="drag-text">
                        <i class="far fa-image"></i>
                        <h6>{{ trans('home.dragnandDropImageHereorClickTochoos') }}</h6>
                    </div>
                </div>
                <div class="file-upload-content">
                    <img class="file-upload-image" src="@if($post->type == 1) {{url('storage/posts/'.$post->postmedia->image)}} @else # @endif" alt="your image" />
                    <div class="image-title-wrap">
                        <button type="button" onclick="removeUpload()" class="remove-image"><i class="fas fa-trash"></i>&nbsp;&nbsp;{{ trans('home.remove')}}</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="editableCategoryField">{{ trans('home.category') }}</label>
            </div>
            <select class="custom-select" id="editableCategoryField">
                @foreach($cats as $cat)
                    <option value="{{ $cat->id }}" @if($cat->id == $post->category_id) selected @endif>{{ trans('categories.'.$cat->slug) }}</option>
                @endforeach
            </select>
        </div>


        <button class="savePostChanges btn btn-primary shadowingBtn" data-content_id="{{$post->id}}">{{ trans('home.save') }}</button>
        @if($post->type == '1')
        <small id="passwordHelpInline" class="text-muted">
            &nbsp;&nbsp;<i class="far fa-image"></i>&nbsp;&nbsp;{{ trans('home.thisisvisualheaderincludevisual')}}
        </small>
        @endif

        <!-- preview section -->
        <div class="uploadingPostPreview transitionSlow">
            <img id="file-upload-image" src="@if($post->type == 1){{url('storage/posts/'.$post->postmedia->image)}} @endif" class="specialImageForHeader">
            <button class="closerCross" onclick="removeUpload()"><i class="fas fa-times transitionSlow" ></i></button>
        </div>
    </div>


@endsection

@section('script')
    <script>
        var postEdit = "{{ route('postEdit') }}";
    </script>
    <script src="{{ asset('myjs/authed/editheader.js') }}" defer></script>
@endsection