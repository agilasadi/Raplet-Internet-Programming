@extends('layouts.app')

@section('pageHeaders')
    <title>{{ config('app.name', 'Laravel') }}</title>
@endsection


@section('content')
    <div class="container">
        <div class="col-md-12 my-3 noSidePadding">
            @include('admin.includes.adminNavList')
        </div>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
            </div>
            <input type="text" class="form-control" id="badge_name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div>
        <div class="form-group">
            <label for="badge_type">badge type</label>
            <select class="custom-select" id="badge_type">
                <option selected value="1">Post</option>
                    <option value="0">User</option>
                    <option value="1">Post</option>
                    <option value="2">Comment</option>
            </select>
        </div>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Class</span>
            </div>
            <input type="text" class="form-control" id="badge_classes" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Badge style</span>
            </div>
            <input type="text" class="form-control" id="badge_style" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Required Reputation</span>
            </div>
            <input type="text" class="form-control" id="badge_reqs" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div>

        <div class="form-group">
            <label for="badge_ruler">badge ruler role</label>
            <select class="form-control" id="badge_ruler">
                @foreach($ranks as $rank)
                    <option value="{{ $rank->name }}">{{ $rank->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Badge Buff Reputation</span>
            </div>
            <input type="text" class="form-control" id="badge_buff" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div>

        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile02">
                <label class="custom-file-label" for="inputGroupFile02" id="badge_image" aria-describedby="inputGroupFileAddon02">Choose badge image</label>
            </div>
        </div>

        <div class="input-group input-group-sm mb-3">
            <button type="button" id="submitTheBadge" class="btn btn-primary">Save Badge</button>
        </div>
    </div>



    <script>

        var createBadge = '{{ route('createBadge') }}';

        $("#submitTheBadge").click(function () {
            $("#submitComment").attr("disabled", true);

            var badge_name = $('#badge_name').val();
            var badge_type = $('#badge_type').val();
            var badge_classes = $('#badge_classes').val();
            var badge_style = $('#badge_style').val();
            var badge_reqs = $('#badge_reqs').val();
            var badge_ruler = $('#badge_ruler').val();
            var badge_buff = $('#badge_buff').val();
            var badge_image = $('#badge_image').val();


            $.ajax({
                url: createBadge,
                method: "POST",
                data: {
                    badge_name: badge_name,
                    badge_type: badge_type,
                    badge_classes: badge_classes,
                    badge_style: badge_style,
                    badge_reqs: badge_reqs,
                    badge_ruler: badge_ruler,
                    badge_buff: badge_buff,
                    badge_image: badge_image,

                    _token: token
                },
                success: function (data) {
                    if(data.success === '1'){
                        $.toast({
                            text: data.message,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left', 
                            loader: true, 
                            loaderBg: '#5475b8' 
                        });
                        $('.newCommentBeenAdded').append(data.newComment);
                        $('.linkInsideCommentBox' + data.newCommentId).append(data.commentLinks);
                        $("#submitComment").attr("disabled", false);

                    }
                    else if(data.success === '0'){
                        $.toast({
                            text: data.message,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left', 
                            loader: true, 
                            loaderBg: '#5475b8' 
                        });
                    }
                    else{
                        jQuery.each(data.errors, function (key, value) {
                            $.toast({
                                text: value,
                                showHideTransition: 'fade',
                                allowToastClose: true,
                                hideAfter: 3000,
                                stack: 5,
                                position: 'bottom-left',

                                textAlign: 'left', 
                                loader: true, 
                                loaderBg: 'red', 
                            });
                        })
                    }

                },error:function (e) {
                    jQuery.each(data.errors, function (key, value) {
                        $.toast({
                            text: value,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left', 
                            loader: true, 
                            loaderBg: 'red', 
                        });
                    })
                }

            })
        });
    </script>
@endsection
