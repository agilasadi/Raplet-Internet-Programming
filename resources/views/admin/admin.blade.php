@extends('layouts.app')

@section('pageHeaders')
    <title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section('style')
    <link href="{{ asset('mycss/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="my-3 col-md-12 noSidePadding">
            @include('admin.includes.adminNavList')
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ADMIN Dashboard</div>

                    <div class="card-body">

                        <div class="row">

                            <!-- Tab butonlari -->
                            <!-- Tab butonlari -->
                            <!-- Tab butonlari -->
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Baslik Ekle</a>
                                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Dil Ekle</a>
                                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Admin Ekle</a>
                                    <a class="nav-link" id="v-pills-role-tab" data-toggle="pill" href="#v-pills-role" role="tab" aria-controls="v-pills-messages" aria-selected="false">Rol Ekle</a>
                                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Kategoriler</a>
                                    <a class="nav-link" id="v-pills-usermanage-tab" data-toggle="pill" href="#v-pills-usermanage" role="tab" aria-controls="v-pills-usermanage" aria-selected="false">Kullanici</a>
                                </div>
                            </div>



                            <!-- Tab icerikleri -->
                            <!-- Tab icerikleri -->
                            <!-- Tab icerikleri -->
                            <div class="col-9">
                                <div class="tab-content" id="v-pills-tabContent">

                                    <!-- Baslik ekle -->
                                    <!-- Baslik ekle -->
                                    <!-- Baslik ekle -->
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="form-group">
                                        <textarea class="form-control" id="postContent" rows="3" placeholder="baslik ekle..."></textarea>
                                        </div>
                                        <div class="form-group">
                                        <select class="formClasses form-control select2-multi" name="langs[]" id="langSelector" multiple="multiple">
                                            @if(count($langs)>0)
                                                @foreach($langs as $lang)
                                                    <option value="{{$lang->id}}">
                                                        {{$lang->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="typeSelector">
                                                <option>0</option>
                                                <option>1</option>
                                            </select>
                                        </div>
                                            <button type="submit" id="submitPost" class="btn btn-primary">Submit</button>

                                        <br>
                                        <hr>

                                        <div class="col noSidePadding">
                                        <table class="table">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Icerik</th>
                                                <th scope="col">Slug</th>
                                                <th scope="col">Etiklesim</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($posts as $post)
                                            <tr>
                                                <td>{{ $post->content }}</td>
                                                <td>{{ $post->slug }}</td>
                                                <td>etkilesim</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>


                                    <!-- Dil ekle -->
                                    <!-- Dil ekle -->
                                    <!-- Dil ekle -->
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                        <div class="input-group mb-3">
                                            <input type="text" id="langName" class="form-control" placeholder="Dil ismi">
                                            <input type="text" id="langShortName" class="form-control" placeholder="kisaltmasi">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" id="submitLang" type="button">Ekle</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Admin Olustur -->
                                    <!-- Admin Olustur -->
                                    <!-- Admin Olustur -->
                                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" placeholder="Mail">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="password" placeholder="Sifre">
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Ekle</button>
                                        </div>


                                    </div>

                                     <!-- Rol ekleme-->
                                     <!-- Rol ekleme-->
                                     <!-- Rol ekleme-->
                                    <div class="tab-pane fade" id="v-pills-role" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="rankName" placeholder="Rütbe ismi">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="rankReputationLimit" placeholder="Gerekli itibar puanı">
                                        </div>
                                         <div class="form-group">
                                            <input type="text" class="form-control" id="rankDefinition" placeholder="Açıklama">
                                        </div>
                                        <button id="submitRanksButton" class="btn btn-primary">Gönder</button>

                                        <hr>
                                        <div class="col noSidePadding">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Icerik</th>
                                                    <th scope="col">Slug</th>
                                                    <th scope="col">itibar gerksinimi</th>
                                                    <th scope="col">Etiklesim</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($ranks as $rank)
                                                    <tr>
                                                        <td>{{ $rank->name }}</td>
                                                        <td>{{ $rank->slug }}</td>
                                                        <td>{{ $rank->replimit }}</td>
                                                        <td>etkilesim</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>



                                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="addingCategoryName" placeholder="Category" aria-label="Recipient's username" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="addCategory">Add</button>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="tab-pane fade" id="v-pills-usermanage" role="tabpanel" aria-labelledby="v-pills-usermanage-tab">
                                         <table class="table">
                                             <thead class="thead-dark">
                                             <tr>
                                                 <th scope="col">#</th>
                                                 <th scope="col">Name</th>
                                                 <th scope="col">Slug</th>
                                                 <th scope="col">Email</th>
                                                 <th scope="col">Role</th>
                                                 <th scope="col">Action</th>
                                             </tr>
                                             </thead>
                                             <tbody>
                                             @foreach($users as $user)
                                                 <tr>
                                                     <th scope="row">{{ $user->id }}</th>
                                                     <td>{{ $user->name }}</td>
                                                     <td>{{ $user->userprofile->slug }}</td>
                                                     <td>{{ $user->email }}</td>
                                                     <td>{{ $user->userprofile->role_id }}</td>
                                                     <td><button type="button" class="makeItAdmin btn btn-primary" data-content_id="{{ $user->id }}">Adminlik ata</button></td>
                                                 </tr>
                                             @endforeach
                                             </tbody>
                                         </table>
                                     </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        var submitNewLang = "{{ Route('langCreate') }}";
        var submitNewPost = "{{ Route('postCreate') }}";
        var submitNewRole = "{{ Route('submitNewRole') }}";
        var makeItAdmin = "{{ Route('makeItAdmin') }}";


        $(document).on('click', '#submitLang', function () {

            var name = $('#langName').val();
            var short_name = $('#langShortName').val();


            $.ajax({
                url: submitNewLang,
                method: "POST",
                data: {
                    name: name,
                    short_name: short_name,
                    _token: token
                },
                success: function (message) {
                    $.toast({
                        text: message.message,
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'bottom-left',

                        textAlign: 'left', 
                        loader: true, 
                        loaderBg: '#5475b8' 
                    });
                },error:function (e) {
                    var k;
                    var res=JSON.parse(e.responseText);
                    for (k in res) {
                        $.toast({
                            text: res[k],
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
        });

        $(document).on('click', '#submitPost', function () {
            event.preventDefault();

            var content = $('textarea#postContent').val();
            var langs = $('#langSelector').val();
            var type = $('#typeSelector').val();

            $.ajax({
                url: submitNewPost,
                method: "POST",
                data: {
                    content: content,
                    langs: langs,
                    type: type,
                    _token: token
                },
                success: function (message) {
                    $("#evensIncludedHere").html(message.newEven);
                    $.toast({
                        text: message.message,
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'bottom-left',
                        textAlign: 'left',
                        loader: true,
                        loaderBg: '#5475b8',
                    });

                },error:function (e) {
                    var k;
                    var res=JSON.parse(e.responseText);
                    for (k in res) {
                        $.toast({
                            text: res[k],
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left', 
                            loader: true, 
                            loaderBg: 'red', 
                        });
                    }


                }

            })
        });



        $(document).on('click', '#submitRanksButton', function () {
            event.preventDefault();

            var name = $('#rankName ').val();
            var replimit = $('#rankReputationLimit ').val();
            var define = $('#rankDefinition').val();

            $.ajax({
                url: submitNewRole,
                method: "POST",
                data: {
                    name: name,
                    replimit: replimit,
                    define: define,
                    _token: token
                },
                success: function (data) {
                    if (data.success == 1){
                        $.toast({
                            text: data.message,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left', 
                            loader: true, 
                            loaderBg: '#5475b8', 
                        });
                    }
                    else {
                        $.toast({
                            text: data.message,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left', 
                            loader: true, 
                            loaderBg: 'red', 
                        });
                    }


                },error:function (e) {
                    var k;
                    var res=JSON.parse(e.responseText);
                    for (k in res) {
                        $.toast({
                            text: res[k],
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left', 
                            loader: true, 
                            loaderBg: 'red', 
                        });
                    }


                }

            })
        });

        $('.makeItAdmin').click(function () {

            var content_id = $(this).data('content_id');
            $.ajax({
                url: makeItAdmin,
                method: "POST",
                data: {
                    content_id: content_id,
                    _token: token
                },
                success: function (message) {
                    $.toast({
                        text: message,
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'bottom-left',

                        textAlign: 'left', 
                        loader: true, 
                        loaderBg: 'red', 
                    });
                },error:function (e) {
                    var k;
                    var res=JSON.parse(e.responseText);
                    for (k in res) {
                        $.toast({
                            text: res[k],
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left', 
                            loader: true, 
                            loaderBg: 'red', 
                        });
                    }


                }
            })
        });

    </script>
    <script>
        $('.select2-multi').select2();
    </script>
@endsection

@section('script')
    <script src="{{ asset('myjs/plugin/select2.min.js') }}"></script>
@endsection
