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
								<a class="nav-link" href="{{ route('indexCategories') }}">Create</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active" href="#">Restore</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="col-9 mt-3 mb-3">
					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active" id="createCategories" role="tabpanel" aria-labelledby="v-pills-settings-tab">
							<div class="col-md-12">

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

										@foreach ($categories as $category)
											<tr>
												<th scope="row">{{ $category->id }}</th>
												<td>{{ $category->name }}</td>
												<td>{{ $category->slug }}</td>
												<td>{{ $category->interest }}</td>
												<td>
													<button class="forceDeleteCategory btn btn-warning btn-sm" data-content_id="{{ $category->id }}">Force Delete</button>
													<button class="restoreCategory btn btn-info btn-sm" data-content_id="{{ $category->id }}">Restore</button>
													<button class="editCategory btn btn-primary btn-sm" data-content_id="{{ $category->id }}">Edit</button>
												</td>
											</tr>
											<div class="mb-3 mt-3 displaynone categoryrows categoryrow{{ $category->id }}">
												<div class="form-row">
													<div class="col">
														<input type="text" class="form-control categoryName" placeholder="Category name" value="{{ $category->name }}">
													</div>
													<div class="col">
														<input type="text" class="form-control categorySlug" placeholder="Category slug" value="{{ $category->slug }}">
													</div>
													<div class="col">
														<input type="text" class="form-control categoryInterest" placeholder="Category interest" value="{{ $category->interest }}">
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
        var restoreCategory = "{{ Route('restoreCategory') }}";
        var forceDeleteCategory = "{{ Route('forceDeleteCategory') }}";
        var updateCategory = "{{ Route('updateCategory') }}";
        var selectedCategory;

        $('.forceDeleteCategory').click(function () {
            selectedCategory = $(this).data('content_id');
            $.ajax({
                url: forceDeleteCategory,
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

        $('.restoreCategory').click(function () {
            selectedCategory = $(this).data('content_id');
            $.ajax({
                url: restoreCategory,
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