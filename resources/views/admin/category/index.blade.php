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
					<div class="nav flex-column nav-pills pl-3" id="v-pills-tab" role="tablist"
					     aria-orientation="vertical">
						<ul class="nav flex-column">
							<li class="nav-item">
								<a class="nav-link active" href="#">Create</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('restore_view') }}">Restore</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="col-9 mt-3 mb-3">
                    <div class="tab-content" id="v-pills-tabContent">
					    <div class="tab-pane fade show active" id="createCategories" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                <h4 class="mb-3">Create Category</h4>
					    	        <div class="input-group mb-3">
					    	        	<input type="text" class="form-control" id="addingCategoryName" placeholder="Category" aria-label="Recipient's username" aria-describedby="button-addon2">
					    	        	<div class="input-group-append">
					    	        		<button class="btn btn-outline-secondary" type="button" id="addCategory">Add</button>
					    	        	</div>
                                    </div>
                                </div>    

                                <div class="col-md-12 mt-5">
                                    <h4 class="mb-3">Categories</h4>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">@slug</th>
                                                <th scope="col">Interest</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($cats as $cat)                                                
                                                <tr>
                                                    <th scope="row">{{ $cat->id }}</th>
                                                    <td>{{ $cat->name }}</td>
                                                    <td>{{ $cat->slug }}</td>
                                                    <td>{{ $cat->interest }}</td>
                                                    <td>
                                                        <button class="softDeleteCategory btn btn-danger btn-sm" data-content_id="{{ $cat->id }}">Delete</button>  
                                                        <button class="editCategory btn btn-primary btn-sm" data-content_id="{{ $cat->id }}">Edit</button>
                                                    </td>
                                                </tr>
                                                <div class="mb-3 mt-3 displaynone categoryrows categoryrow{{ $cat->id }}">
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <input type="text" class="form-control categoryName" placeholder="Category name" value="{{ $cat->name }}">
                                                            </div>
                                                            <div class="col">
                                                                <input type="text" class="form-control categorySlug" placeholder="Category slug" value="{{ $cat->slug }}">
                                                            </div>
                                                            <div class="col">
                                                                <input type="text" class="form-control categoryInterest" placeholder="Category interest" value="{{ $cat->interest }}">
                                                            </div>
                                                            <div class="col">
                                                                <button type="submit" class="btn btn-primary updateCategory">Update</button>
                                                                <button type="button" class="btn btn-light closeUpdateForm"><i class="fas fa-times"></i></button>
                                                            </div>
                                                        </div>
                                                </div>
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



	<script>
        var submitNewCategory = "{{ Route('submitNewCategory') }}";
        var deleteCategory = "{{ Route('softDeleteCategory') }}";
        var updateCategory = "{{ Route('updateCategory') }}";
        var selectedCategory;

        $(document).on('click', '#addCategory', function () {
            var name = $('#addingCategoryName').val();
            $.ajax({
                url: submitNewCategory,
                method: "POST", data: {name: name, _token: token}, success: function (message) {
                    $.toast({
                        text: message.message, 
                        showHideTransition : 'fade', 
                        allowToastClose: true,
                        hideAfter: 3000, 
                        stack: 5,
                        position: 'bottom-left',
                        textAlign: 'left',
                        loader: true,
                        loaderBg: '#5475b8'
                })
                    ;
                }, error: function (e) {
                    var k;
                    var res = JSON.parse(e.responseText);
                    for (k in res) {
                        $.toast({
                            text: res[k],
                            showHideTransition: 'fade',
                            allowToastClose:true,
                            hideAfter: 3000, 
                            stack: 5, 
                            position: 'bottom-left',
                            textAlign:'left',
                            loader: true,
                            loaderBg: 'red'
                        }); 
                    } 
                } 
            }) 
        });

        $('.softDeleteCategory').click(function () {
            selectedCategory = $(this).data('content_id');
            $.ajax({
                url: deleteCategory,
                method: "POST", data: {content_id: selectedCategory, _token: token}, success: function (message) {
                    $.toast({
                        text: message.message, 
                        showHideTransition : 'fade', 
                        allowToastClose: true,
                        hideAfter: 3000, 
                        stack: 5,
                        position: 'bottom-left',
                        textAlign: 'left',
                        loader: true,
                        loaderBg: '#5475b8'
                })
                    ;
                }, error: function (e) {
                    var k;
                    var res = JSON.parse(e.responseText);
                    for (k in res) {
                        $.toast({
                            text: res[k],
                            showHideTransition: 'fade',
                            allowToastClose:true,
                            hideAfter: 3000, 
                            stack: 5, 
                            position: 'bottom-left',
                            textAlign:'left',
                            loader: true,
                            loaderBg: 'red'
                        }); 
                    } 
                } 
            }) 
        });

        $('.updateCategory').click(function () {
            var name = $(".categoryrow"+selectedCategory).find( ".categoryName" ).val();
            var slug = $(".categoryrow"+selectedCategory).find( ".categorySlug" ).val();
            var interest = $(".categoryrow"+selectedCategory).find( ".categoryInterest" ).val();


            $.ajax({
                url: updateCategory,
                method: "POST", data: {
                    content_id: selectedCategory,
                    name: name,
                    slug: slug,
                    interest: interest,
                    _token: token
                },
                success: function (message) {
                    $.toast({
                        text: message.message,
                        showHideTransition : 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'bottom-left',
                        textAlign: 'left',
                        loader: true,
                        loaderBg: '#5475b8'
                    })
                    ;
                }, error: function (e) {
                    var k;
                    var res = JSON.parse(e.responseText);
                    for (k in res) {
                        $.toast({
                            text: res[k],
                            showHideTransition: 'fade',
                            allowToastClose:true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',
                            textAlign:'left',
                            loader: true,
                            loaderBg: 'red'
                        });
                    }
                }
            })
        });



        // |----- Extra javascript with no request options

        $(".editCategory").click(function (){
            selectedCategory = $(this).data('content_id');

            $(".categoryrows").css("display", "none");
            $(".categoryrow"+selectedCategory).css("display", "block");
        });

        $(".closeUpdateForm").click(function (){
            $(".categoryrow"+selectedCategory).css("display", "none");
        });

	</script>
@endsection

@section('script')
	<script src="{{ asset('myjs/adminPanel.js') }}"></script>
	<script src="{{ asset('myjs/admin/keepertranslate.js') }}"></script>
@endsection