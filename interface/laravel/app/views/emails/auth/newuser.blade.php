<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>McMaster FMS Account Created</h2>

		<div>
            You have been granted an account on the McMaster Fumehood Monitoring System. 
            To log in, visit {{ URL::to('login') }} and use the following credentials:
            <ul>
              <li><b>Email:</b> {{$email}}</li>
              <li><b>Password:</b> {{$password}}</li>
            </ul>
            Once logged in, visit your Profile page in the top-right to change your password.
		</div>
	</body>
</html>
