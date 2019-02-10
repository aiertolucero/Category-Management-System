<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Category Management System</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
		<div class="flex-container">
			<h4 class="flex-item-1">Category Management System</h4>
			<form class="flex-item-2" action="/login" method="post" accept-charset="UTF-8">
			  <input type="hidden" value="{{ csrf_token() }}" name="_token">
			  <hr>
			  <p class="text-danger text-center">{{isset($login_error) ? $login_error : ''}}</p>
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