<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: mainpage.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mobile_Kuku</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href=' ' rel='stylesheet' type='text/css'>
    <link href=' ' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/creative.css" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">M-KUKU</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <img src="img/logo2t.png" width = "4%">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    <li>
                        <a href="login.php">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <section class="bg-signup" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-lg-offset-4 text-center">
                    <h2 class="text-faded">Sign up to M-KUKU</h2>
                    <hr class="light">
                    <form action = "signupprocessor.php" method="post" class="text-faded">
                        Enter your name: <input class="form-control" name="name" placeholder = "Enter your name e.g. John Smith" required><br>
                        Enter a username: <input class="form-control" name="username" placeholder = "Enter a username e.g. johnsmith" required><br>
                        Enter your email: <input class="form-control" name="email" placeholder = "Enter your email e.g. johnsmith@example.com" required><br>
                        Enter a new password: <input class="form-control" name="password" type="password" placeholder = "Enter a new password" required><br>
                        <input type="submit" class="btn btn-success" value = "Submit" name="signup">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="bg-dark">
        <div class="container bg-dark">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                    <p>Want to talk to us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
                </div>
                <div class="col-lg-3 col-lg-offset-0 text-center">
                    <i class="fa fa-phone fa-3x wow bounceIn"></i>
                    <p>+254703175432</p>
                </div>
                <div class="col-lg-3 col-lg-offset-0 text-center">
                    <i class="fa fa-facebook-square  fa-3x wow bounceIn"></i>
                    <p>Facebook</p>
                </div>
                <div class="col-lg-3 col-lg-offset-0 text-center">
                    <i class="fa fa-twitter  fa-3x wow bounceIn"></i>
                    <p>Twitter</p>
                </div>
                <div class="col-lg-3 text-center">
                    <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                    <p><a href="mailto:info.onlinenoticeboard@gmail.com">For feedback, email us at: mobile_kukurd@gmail.com</a></p>
                </div>
                <footer>
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <p>Copyright &copy; M-KUKU 2016</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </section>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/jquery.fittext.js"></script>
    <script src="js/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/creative.js"></script>

</body>

</html>
