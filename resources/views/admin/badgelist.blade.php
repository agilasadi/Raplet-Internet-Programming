@extends('layouts.app')

@section('pageHeaders')
    <title>{{ config('app.name', 'Laravel') }}</title>
@endsection


@section('content')
    <div class="container">
        <div class="col-md-12 my-3 noSidePadding">
            @include('admin.includes.adminNavList')
        </div>

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Badge Name</th>
                <th scope="col">Badge</th>
                <th scope="col">Requirement</th>
                <th scope="col">Buff</th>
                <th scope="col">Badge Role</th>
            </tr>
            </thead>
            <tbody>
            @foreach($badges as $badge)
               <tr>
                   <th scope="row">{{ $badge->id }}</th>
                   <td>{{ $badge->name }}</td>
                   <td>{!! $badge->class !!}</td>
                   <td>{{ $badge->badge_reqs }}</td>
                   <td>{{ $badge->badge_buff }}</td>
                   <td>{{ $badge->badge_ruler }}</td>
               </tr>
            @endforeach
            </tbody>
        </table>

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
