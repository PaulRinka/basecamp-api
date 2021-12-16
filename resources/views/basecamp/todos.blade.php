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
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
					 Description
						<table class="table table-responsive-xl">
						  <thead>
						    
						  </thead>
						  <tbody>
                         @foreach($TodoSets as $TodoSet)
						
                                            <tr class="alert" role="alert">
                                                <td>
                                                {{$loop->iteration}}
                                                </td>
                                                <td>  {{$TodoSet['description']}}</td>
                                            <td class="d-flex align-items-center">
                                               {{$TodoSet['title']}}                                                 
                                                
                                            </td>
                                            <td> {{$TodoSet['content']}} </td>
                                            <td>  {{$TodoSet['creator']}}   </td>
                                            <td>
                                            <form  method="post" action="{{url('comment')}}">
												{{ csrf_field() }}                           
												
												<input type="hidden" value="{{$TodoSet['id']}}" name="todo_set_id" >
												<input type="hidden" value="{{$TodoSet['comments_url']}}" name="url" >
												<input type="submit" value="COMMENT"/>
												</form>
                                                </td>
                                            <td class="status"><span class="active"></span></td>
                                            <td>
                                        
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

