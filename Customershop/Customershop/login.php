<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap-icons.css">
</head>
<body>

	<form method="post" onsubmit="myaction.collect_data(event, 'login')">
		<div class="col-md-4 border rounded mx-auto mt-5 p-4 shadow">
			
			<div class="h2">Login</div>

			<div><small class="my-1 js-error js-error-email text-danger"></small></div>

			<div class="input-group mb-3">
			  <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
			  <input name="email" type="text" class="form-control p-3" placeholder="Email" >
			</div>
			<div class="input-group mb-3">
			  <span class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
			  <input name="password" type="password" class="form-control p-3" placeholder="Password" >
			</div>

			<div class="progress my-3 d-none">
			  <div class="progress-bar" role="progressbar" style="width: 50%;" >Working... 25%</div>
			</div>

			<button class="btn btn-primary col-12">Login</button>

			<div class="m-2">
				Dont have an account? <a href="signup.php">signup here</a>
			</div>
		</div>
	</form>

	<style>
		body {
			background-image : url('product_images/shopping-07.jpg');
		}
	</style>

</body>
</html>

<script>
	
	var myaction  = 
	{
		collect_data: function(e, data_type)
		{
			e.preventDefault();
			e.stopPropagation();

			var inputs = document.querySelectorAll("form input, form select");
			let myform = new FormData();
			myform.append('data_type',data_type);

			for (var i = 0; i < inputs.length; i++) {

				myform.append(inputs[i].name, inputs[i].value);
			}

			myaction.send_data(myform);
		},

		send_data: function (form)
		{

			var ajax = new XMLHttpRequest();

			document.querySelector(".progress").classList.remove("d-none");

			document.querySelector(".progress-bar").style.width = "0%";
			document.querySelector(".progress-bar").innerHTML = "Working... 0%";

			ajax.addEventListener('readystatechange', function(){

				if(ajax.readyState == 4)
				{
					if(ajax.status == 200)
					{
						
						myaction.handle_result(ajax.responseText);
					}else{
						console.log(ajax);
						alert("An error occurred");
					}
				}
			});

			ajax.upload.addEventListener('progress', function(e){

				let percent = Math.round((e.loaded / e.total) * 100);
				document.querySelector(".progress-bar").style.width = percent + "%";
				document.querySelector(".progress-bar").innerHTML = "Working..." + percent + "%";
			});

			ajax.open('post','ajax.php', true);
			ajax.send(form);
		},

		handle_result: function (result)
		{
			console.log(result);
			var obj = JSON.parse(result);
			if(obj.success)
			{
				alert("Login successfull!");
				window.location.href = 'home.php';
			}else{

				
				let error_inputs = document.querySelectorAll(".js-error");

				
				for (var i = 0; i < error_inputs.length; i++) {
					error_inputs[i].innerHTML = "";
				}

				
				for(key in obj.errors)
				{
					document.querySelector(".js-error-"+key).innerHTML = obj.errors[key];
				}
			}
		}
	};

</script>
