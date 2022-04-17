<!DOCTYPE html>
<html>
    <head>
    	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
<body>
	<div class="col-lg-6">
		<h3>Halaman Login</h3>
		<form action="{{ route('login') }}" method="post" class="form-input">	
			@csrf
			<div class="form-group">
				<label for="exampleFormControlTextarea1">Email</label>
				<input type="text" class="form-control" id="exampleFormControlInput1x" name="username">
			</div>
			<div class="form-group">
				<label for="exampleFormControlTextarea1">Password</label>
				<input type="password" class="form-control" id="exampleFormControlInput1" name="password">
			</div>
			<button
				type="submit"
				class="btn btn-success">Login</button>
		</form>
	</div>

	<!-- <form action="{{ route('login') }}" method="post" class="form-input">	
    @csrf	
		<table>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="login" value="Log In"></td>
			</tr>
		</table>
	</form> -->
</body>
</html>