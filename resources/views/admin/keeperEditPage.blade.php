@extends('layouts.app')

@section('pageHeaders')
    <title>{{ config('app.name', 'Laravel') }}</title>
@endsection


@section('content')
    <div class="container">
        <div class="col-md-12 my-3 noSidePadding">
            @include('admin.includes.adminNavList')
        </div>

        <div class="card">
        <div class="row">
            <div class="col-3 mt-3 mb-3">
                <div class="nav flex-column nav-pills pl-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('keeperCreatePage') }}">Create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="">Edit</a>
                    </li>
                </ul>
                </div>
            </div>
        <div id="editKeepersPill" class="col-md-9">
            <div class="col-md-12">
                <h4 class="card-header text-center">Edit original keeper</h4>
                <div class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($multilingual == "1")
                                {{$lang}}
                            @else
                                Original Messages
                            @endif
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($langs as $lang)
                                <a class="dropdown-item" href="{{ route('keeperEditPage', $lang->id) }}">{{ $lang->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

            @foreach($allKeepers as $allKeeper)
                        <div class="modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="keeperCoverimagePrevievHolder{{$allKeeper->id}} @if($allKeeper->image == "0") hideInBeginning @endif">
                                        <img class="imageFullModel" data-keeperEdit_id="{{$allKeeper->id}}" id="keeperCoverPreview{{$allKeeper->id}}" src="{{url('storage/keepers/'.$allKeeper->image)}}">
                                    </div>

                                    <div class="@if($allKeeper->image == "0") fieldForNoImg @endif imageBannerHolder{{$allKeeper->id}}">
                                        <div class="absoluteSideDiv">
                                            <button class="@if($allKeeper->image == "0") hideInBeginning @endif absoluteButton keeperCoverDump DumperClassify{{$allKeeper->id}}" data-keeperEdit_id="{{$allKeeper->id}}"><i class="fas fa-trash-alt"></i></button>
                                            <label for="keeperCover{{$allKeeper->id}}" class="absoluteButton"><i class="fas fa-image"></i></label>
                                            <input id="keeperCover{{$allKeeper->id}}" data-keeperEdit_id="{{$allKeeper->id}}" class="hideInBeginning keeperCoverInputField" name="keeperCover" type="file">
                                        </div>
                                    </div>

                                    <input type="text" class="hideInBeginning" disabled="disabled" id="keeperCoverName{{$allKeeper->id}}"
                                           value="{{$allKeeper->image}}">
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"><small>Content</small></label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="keeperContent{{$allKeeper->id}}" placeholder="Content">{{ $allKeeper->content }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"><small>Link text</small></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="keeperLinkText{{$allKeeper->id}}" placeholder="Link text" value="{{$allKeeper->link_text}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"><small>Link url</small></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="keeperLinkUrl{{$allKeeper->id}}" placeholder="Link url" value="{{$allKeeper->link_url}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"><small>Expiration</small></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="keeperExpire{{$allKeeper->id}}" placeholder="Expiration" value="{{$allKeeper->expire}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"><small>Notification Type</small></label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="keeperType{{$allKeeper->id}}">
                                                        <option value="0" @if($allKeeper->type == 0) selected @endif>Regular message</option>
                                                        <option value="1" @if($allKeeper->type == 1) selected @endif> Cookie & Privacy </option>
                                                        <option value="2" @if($allKeeper->type == 2) selected @endif> News </option>
                                                        <option value="3" @if($allKeeper->type == 3) selected @endif> Advertisement </option>
                                                        <option value="4" @if($allKeeper->type == 4) selected @endif> Large Privacy & Cookie </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"><small>Status</small></label>
                                                <div class="col-sm-9">
                                                    <select class="form-control keeperField musthave fieldFiller" name="Status" id="keeperStatus{{$allKeeper->id}}">
                                                        <option value="0" @if($allKeeper->user_type == "0") selected @endif>Disabled</option>
                                                        <option value="1" @if($allKeeper->user_type == "1") selected @endif>Live</option>
                                                        <option value="2" @if($allKeeper->user_type == "2") selected @endif>Draft</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"><small>User Type {{ $allKeeper->user_type }}</small></label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="keeperUserType{{$allKeeper->id}}">
                                                        <option value="0" @if($allKeeper->user_type == "0") selected @endif>Regular</option>
                                                        @foreach($ranks as $rank)
                                                        <option value="{{ $rank->id }}" @if($allKeeper->user_type == $rank->id) selected @endif>{{$rank->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-light">{{ $allKeeper->lang->name }}</button>
                                        <button type="button" data-keeperedit_id="{{ $allKeeper->id }}" class="btn btn-primary updateAKeeper"><i class="fas fa-save"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>




        </div>
        </div>

    </div>



    <script>
        var editTheKeeper = '{{ route('editTheKeeper') }}';
    </script>
@endsection

@section('script')
    <script src="{{ asset('myjs/adminPanel.js') }}"></script>
    <script src="{{ asset('myjs/admin/keepertranslate.js') }}"></script>

@endsection
