<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xflix - Online Movie,Vedio and TV Show</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Favicon Icon -->
    {{-- <link rel="icon" type="image/png" href="{{asset('assets/img/favcion.png')}}" /> --}}
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}" media="all" />
    <!-- Main style CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}" media="all" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}" media="all" />
    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
<body>
  <div class="container login">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form onsubmit="event.preventDefault()" class="box">
                  <img src="{{asset('assets/img/xflix-logo.png')}}" alt="">
                    <h1>Registration</h1>
                    <p class="text-muted"> Please enter your Information!</p>
                 
                     <input type="text" name="" placeholder="Username"> 
                     <input type="text" name="" placeholder="phone"> 
                     <input type="text" name="" placeholder="Email"> 
                     <input type="password" name="" placeholder="Password"> 
                     {{-- <a class="forgot " href="#">Forgot password?</a> <input type="submit" name="" value="Register" href="#"> --}}
                     <p>Login With</p>
                    <div class="col-md-12">
                        <ul class="social-network social-circle">
                            <li><a href="#" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" class="icoGoogle" title="Google +"><i class="fab fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                     <div class="bottom">
                  <p>Already Have An Account ?</p>
                  <a href="{{url('/login')}}">Login Now</a>
                </div>
                </form>
               
            </div>
        </div>
    </div>
</div>
</body>
</html>
