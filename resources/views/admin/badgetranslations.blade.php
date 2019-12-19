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
                <th scope="col">Badge Name</th>
                <th scope="col">Badge</th>
                @foreach($registeredLangs as $registeredLang)
                    <th scope="col">{{ $registeredLang->name }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($badges as $badge)
               <tr>
                   <td>{{ $badge->name }}</td>
                   <td>{!! $badge->class !!}</td>
                   @foreach($registeredLangs as $registeredLang)
                       <td scope="col">
                           <input type="text" class="form-control transnamesInputField" placeholder="{{ $registeredLang->name }} ------------" data-short_name="{{ $registeredLang->short_name }}" data-content_id="{{ $badge->id }}"
                                  data-previous_content="@if($linguals->where('content_id', "4-".$badge->id)->where('short_name', $registeredLang->short_name)->first() != null) {{ $linguals->where('content_id', "4-".$badge->id)->where('short_name', $registeredLang->short_name)->first()->transname }} @endif"
                                  value="@if($linguals->where('content_id', "4-".$badge->id)->where('short_name', $registeredLang->short_name)->first() != null) {{ $linguals->where('content_id', "4-".$badge->id)->where('short_name', $registeredLang->short_name)->first()->transname }} @endif">
                       </td>
                   @endforeach
               </tr>
            @endforeach
            </tbody>
        </table>

    </div>



    <script>
        var createBadgeTranslation = '{{ route('createBadgeTranslation') }}';

        $(document).ready(function(){
            $(".transnamesInputField").focusout(function(){
                var previous_content = $(this).data('previous_content');
                var currentContent = $(this).val();
                var content_id = $(this).data('content_id');
                var short_name = $(this).data('short_name');

                var contentCheck =  $.trim($(this).val());


                if(currentContent != previous_content && contentCheck.length > 0){ // check if the data is a news data
                    $(".rapletIsLoading").css('display', 'block');
                    $.ajax({
                        url: createBadgeTranslation,
                        method: "POST",
                        data: {
                            currentContent: currentContent,
                            content_id: content_id,
                            short_name: short_name,
                            _token: token
                        },
                        success: function (data) {

                            if(data.success == '1'){
                                setTimeout(
                                    function()
                                    {
                                        $(".rapletIsLoading").css('display', 'none');
                                    }, 2000);

                                $(this).data('previous_content', currentContent);

                                $.toast({
                                    text: data.message,
                                    showHideTransition: 'fade',
                                    allowToastClose: true,
                                    hideAfter: 3000,
                                    stack: 5,
                                    position: 'bottom-left',

                                    textAlign: 'left', 
                                    loader: true, 
                                    loaderBg: '#41b883' 
                                });
                            }
                            else {
                                setTimeout(
                                    function()
                                    {
                                        $(".rapletIsLoading").css('display', 'none');
                                    }, 2000);
                                $.toast({
                                    text: data.message,
                                    showHideTransition: 'fade',
                                    allowToastClose: true,
                                    hideAfter: 3000,
                                    stack: 5,
                                    position: 'bottom-left',

                                    textAlign: 'left', 
                                    loader: true, 
                                    loaderBg: 'red' 
                                });
                            }
                        }

                    })
                }
                else {
                    console.log(" content is either empty or same as the previous one ");
                }
            });
        });
    </script>

@endsection
