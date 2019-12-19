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
                        <a class="nav-link active" href="#">Create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('keeperEditPage') }}">Edit</a>
                    </li>
                </ul>
                </div>
            </div>

        <div class="col-9">
        <div class="tab-content" id="v-pills-tabContent">
        <div id="createKeeperPill" class="tab-pane fade show active" role="tabpanel" aria-labelledby="createKeeperTab">
        <div class="col-md-12 admingPanelContentCreatField">

            <div class="form-row">

                <div class="col-md-12 mb-3 form-group">
                    <label for="exampleFormControlTextarea1"><i class="fas fa-money-check"></i> Message Content</label>
                    <textarea class="form-control keeperField musthave fieldFiller" name="Content" id="messageContent" rows="3"></textarea>
                </div>

                <div class="col-md-12 mb-3 form-group">
                    <label for="exampleFormControlFile1"><i class="fas fa-image"></i> Message image</label>
                    <input type="file" class="form-control-file keeperField betterhave" name="Cover" id="messageImg">
                </div>

                <div class="col-md-6 mb-3 form-group">
                    <label for="exampleFormControlInput1"><i class="fas fa-font"></i> Link Text</label>
                    <input type="text" class="form-control keeperField fieldFiller" id="linkText" name="Link-text" placeholder="This is what user will see">
                </div>

                <div class="col-md-6 mb-3 form-group">
                    <label for="exampleFormControlInput1"><i class="fas fa-link"></i> Link URL</label>
                    <input type="text" class="form-control keeperField fieldFiller" id="linkUrl" name="Link-url" placeholder="https://somesite.com/some-url">
                </div>

                <div class="col-md-4 mb-3 form-group">
                    <label for="exampleFormControlInput1"><i class="far fa-comment-alt"></i> Message Type</label>
                    <select class="form-control keeperField betterhave fieldFiller" name="Message-type" id="messageType">
                        <option selected value="0">Regular message</option>
                        <option value="1"> Cookie & Privacy </option>
                        <option value="2"> News </option>
                        <option value="3"> Advertisement </option>
                        <option value="4"> Large Privacy & Cookie </option>
                    </select>
                </div>


                <div class="col-md-4 mb-3 form-group">
                    <label for="exampleFormControlInput1"><i class="fas fa-toggle-on"></i> Status</label>
                    <select class="form-control keeperField musthave fieldFiller" name="Status" id="messageStatus" >
                        <option value="0">Disabled</option>
                        <option value="1" selected>Live</option>
                        <option value="2">Draft</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3 form-group">
                    <label for="exampleFormControlInput1"><i class="fas fa-language"></i> Origin Language</label>
                    <select class="form-control keeperField musthave fieldFiller" id="message_lang" name="Language">
                        @foreach($langs as $lang)
                           <option value="{{ $lang->short_name }}" id="">{{ $lang->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3 form-group">
                    <label for="exampleFormControlInput1"><i class="fas fa-users-cog"></i> For which users</label>
                    <select class="form-control keeperField musthave fieldFiller" id="for_user_type" name="User-type">
                        <option value="0" selected>Regular</option>
                        @foreach($ranks as $rank)
                            <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3 form-group">
                    <label for="exampleFormControlInput1"><i class="fas fa-calendar-alt"></i> Expire Day</label>
                    <input class="form-control keeperField musthave fieldFiller" min="{{$today}}" type="date" id="messageExpireDay" name="Expire-Day">
                </div>

                <div class="col-md-3 mb-3 form-group">
                    <label for="exampleFormControlInput1"><i class="fas fa-clock"></i> Expire Hour</label>
                    <input type="time" id="messageExpireMinute" class="form-control musthave keeperField fieldFiller" name="Expire-Hour">
                </div>



                <button type="button" onclick="checkKeeper()" class="btn btn-info">Submit</button>
            </div>

        </div>

        <div class="col-md-12 p-3 informativeBox">
            <h5 class="pb-3"><i class="fas fa-info-circle"></i> Information for entered data</h5>
            <ul>
                <li class="pb-3"><i class="fas fa-users-cog"></i> User Type
                    <ul>
                        <li>User type <b>1</b> is <b>regular</b>, and everybody including <b>registered</b> and <b>none registered</b> people will see it</li>
                        <li>User type <b>2</b> is registered <b>users</b></li>
                        <li>User type <b>3</b> is website <b>moderators</b></li>
                        <li>User type <b>4</b> is website <b>admins</b></li>
                        <li>User type <b>5</b> is admine panel <b>admins</b></li>
                    </ul>
                </li>
                <li class="pb-3"><i class="far fa-comment-alt"></i> Message Type
                    <ul>
                        <li>Message type <b>0</b> is regular and is not supposed to do anything else different than informing users</li>
                    </ul>
                </li>
                <li class="pb-3"><i class="fas fa-toggle-on"></i> Status
                    <ul>
                        <li>Status <b>1</b> means the message will be <b>active</b> the moment you submit it</li>
                        <li>Status <b>2</b> means this is a <b>draft</b> message and will remain untouched unless you edit it</li>
                        <li>Status <b>0</b> means the message have been <b>disabled</b>, due to date expiration or manual disabling</li>
                    </ul>
                </li>

                <li class="pb-3"><i class="fas fa-language"></i> Origin Language
                    <ul>
                        <li>The selected language will be chosen authomatically when there is no suitable language for session.</li>
                    </ul>
                </li>


            </ul>
        </div>
        </div>


        </div>
        </div>


        </div>
        </div>

    </div>



    <script>
        var createNewKeeper = '{{ route('createNewKeeper') }}';
    </script>
@endsection

@section('script')
    <script src="{{ asset('myjs/adminPanel.js') }}"></script>
    <script src="{{ asset('myjs/admin/keepertranslate.js') }}"></script>
@endsection
