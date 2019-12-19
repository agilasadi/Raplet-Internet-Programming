@extends('layouts.app')
@section('style')
    <link href="{{asset('summernote/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('mycss/adminPanel.css')}}" rel="stylesheet">
@endsection
@section('pageHeaders')
    <title>{{ config('app.name', 'Laravel') }}</title>
@endsection


@section('content')
    <div class="container">
        <div class="col-md-12 my-3 noSidePadding">
            @include('admin.includes.adminNavList')
        </div>

        <div class="filterSelection float-right">
            <button class="coloredDarkText rapletBtn rapletModelTogle" data-model_id="currenPageResult">PREVIEW CURRENT PAGE</button>
            <button class="coloredDarkText rapletBtn"><i class="fas fa-file-invoice"></i></button>
            <button class="rapletBtn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="iconsInlists bolderLess text-uppercase coloredDarkText"><i class="fas fa-language"></i></span>&nbsp;&nbsp;{{ $selectedLang->name }}
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                @foreach($registeredLangs as $registeredLang)
                    <a class="dropdown-item" href="{{ route('termstranslations', $registeredLang->id) }}"><button class="iconsInlists bolderLess text-uppercase coloredDarkText">{{ $registeredLang->short_name }}</button>{{ $registeredLang->name }}</a>
                @endforeach
            </div>
        </div>
        <br>
        <br>

            <div id="summernote">@if(mb_substr($ruleTranslated, 0, 5) != "0"){!! $ruleTranslated !!}@endif</div>


        <div class="text-center p-3">
            <button class="btn btn-primary rapletModelTogle " data-model_id="submitNewTranslation"><i class="fas iconsInlists fa-save"></i>SAVE</button>
        </div>

        <div class="rapletCustomModel warningModel shadowed-light border-6 bg-white hideInBeginning transitionSlow" id="submitNewTranslation">
            <div class="text-center p-3">
            <div class="h5 p-3">Are you sure you want to save rules?</div>
                <div><p>You are about to update the <span class="bolder">rules</span> & <span class="bolder">terms</span> for <span class="bolder">{{ $selectedLang->name }}</span></p></div>
            <div class="p-3">
                <button class="btn btn-primary" onclick="submitLanguage()"><i class="fas iconsInlists fa-save"></i>SAVE</button>
                <button class="btn btn-danger rapletModelTogle" data-model_id="submitNewTranslation"><i class="fas iconsInlists fa-times"></i>CANCEL</button>
                <button class="btn btn-info"><i class="fas iconsInlists fa-print"></i>PREVIEW</button>
            </div>
            </div>
        </div>

        <div class="rapletCustomModel fullscreenModel shadowed-light border-6 bg-white hideInBeginning transitionSlow" id="currenPageResult" data-lang_id="{{ $selectedLang->id }}">
            <div class="p-3">
                <div class="container">
                    {!! $ruleTranslated !!}
                </div>
                <div class="p-3 text-center">
                  <button class="btn btn-danger rapletModelTogle" data-model_id="currenPageResult"><i class="fas iconsInlists fa-times"></i>Close</button>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('script')
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('myjs/submitRulesPage.js') }}"></script>


    <script>

        var  ruleContnetOfThis = '{{ $ruleTranslated }}';



       $('#summernote').summernote({
           height: 380,
           placeholder: 'Rules must be include fore each language!'
       });




        var termstranslate = "{{ route('termstranslate') }}";
        var lang_id = $("#currenPageResult").data('lang_id');
    </script>

@endsection
