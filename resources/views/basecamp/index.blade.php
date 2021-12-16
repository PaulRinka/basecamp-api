<!doctype html>
<html lang="en">
  <head>
  	<title> Basecamp</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
  
	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Welcome {{$user->name}} </h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
						<table class="table table-responsive-xl">
						  <thead>
						    <tr>
						    	<th>&nbsp;</th>
						    	<th>{{$user->email}}</th>
						      <th>{{$user->name}}</th>
						      <!-- <th>Active</th> -->
						      <th>&nbsp;</th>
						    </tr>
						  </thead>
						  <tbody>
                         @foreach($allProjects as $allProject)
                                            <tr class="alert" role="alert">
                                                <td>
                                                    <label class="checkbox-wrap checkbox-primary">
                                                    @if($allProject->status=='active')
                                                        <input type="checkbox"  checked>
                                                    @else
                                                     <input type="checkbox"  >
                                                    @endif  
                                                        <span class="checkmark"></span>
                                                        </label>
                                                </td>
                                            <td class="d-flex align-items-center">
                                                <div class="img" style="background-image: url(images/person_1.jpg);"></div>
                                                <div class="pl-3 email">
                                                    <span>{{$allProject->name}} </span>
                                                    <span>{{$allProject->created_at}}</span>
                                                </div>
                                            </td>
                                            <td>{{$allProject->purpose}}</td>
                                            <td class="status"><span class="active">{{$allProject->status}}</span></td>
                                            <td>
                                            
											

												<form  method="post" action="{{url('todolist')}}">
												{{ csrf_field() }}                           
													<input type="hidden" value="{{$user->token}}" name="user_token">
												<input type="hidden" value="{{$allProject->id}}" name="projet_id" >
												<input type="hidden" value="{{$allProject->todoset()->url}}" name="url" >
												<input type="submit" value="TODOS LIST"/>
												</form>
										
			
                                            </td>
                                            </tr>
						   @endforeach
						  </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script>
  (function($) {

	"use strict";

	$('[data-toggle="tooltip"]').tooltip()

})(jQuery);

  
  </script>

	</body>
</html>

