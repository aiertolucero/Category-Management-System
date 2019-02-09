<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Category Management System</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style type="text/css">
		.flex-container {
		  	display: -ms-flexbox;
		    display: -webkit-flex;
		    display: flex;
		    -webkit-flex-direction: column;
		    -ms-flex-direction: column;
		    flex-direction: column;
		    -webkit-flex-wrap: nowrap;
		    -ms-flex-wrap: nowrap;
		    flex-wrap: nowrap;
		    -webkit-justify-content: center;
		    -ms-flex-pack: center;
		    justify-content: center;
		    -webkit-align-content: stretch;
		    -ms-flex-line-pack: stretch;
		    align-content: stretch;
		    -webkit-align-items: center;
		    -ms-flex-align: center;
		    align-items: center;
		    height: 100vh;
	    }

		.flex-item-1 {
		    -webkit-order: 0;
		    -ms-flex-order: 0;
		    order: 0;
		    -webkit-flex: 0 1 auto;
		    -ms-flex: 0 1 auto;
		    flex: 0 1 auto;
		    -webkit-align-self: auto;
		    -ms-flex-item-align: auto;
		    align-self: auto;
	    }

		.flex-item-2 {
		    -webkit-order: 0;
		    -ms-flex-order: 0;
		    order: 0;
		    -webkit-flex: 0 1 auto;
		    -ms-flex: 0 1 auto;
		    flex: 0 1 auto;
		    -webkit-align-self: auto;
		    -ms-flex-item-align: auto;
		    align-self: auto;
	    }	
    </style>
</head>
<body>
		<div class="flex-container">
			<h4 class="flex-item-1">Category Management System</h4>
			<form class="flex-item-2" action="/login" method="post" accept-charset="UTF-8">
			  <input type="hidden" value="{{ csrf_token() }}" name="_token">
			  <hr>
			  <div class="form-group">
			    <label for="inputUsername">Username</label>
			    <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="username">
			  </div>
			  <div class="form-group">
			    <label for="inputPassword">Password</label>
			    <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
			  </div>
			  <button type="submit" class="btn btn-primary">Login <i class="glyphicon glyphicon-log-in"></i></button>
			</form>
		</div>
</body>
</html>