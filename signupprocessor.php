<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>m_KUKU</title>

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
                <a class="navbar-brand page-scroll" href="index.php">M_KUKU</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <img src="img/logo2t.png" width = "4%">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if(isset($_SESSION['user'])){
                        $user = $_SESSION['user'];
                    ?>
                        <?php
                        include "dbConnect.php";
                        if(mysql_select_db("mkuku")){
                            
                        }else{
                            echo "Error connecting to the database!";
                        }
                        $sql6 = "SELECT * FROM messages WHERE recipient='".$user."' OR sender='".$user."' ORDER BY conversationnumber DESC";
                        $result6 = mysql_query($sql6);
                        $conversationnumbertemp = "-1";
                        $isthere = "no";
                        $unreadnumber = 0;
                        while($row6 = mysql_fetch_array($result6)){
                            if($conversationnumbertemp != $row6['conversationnumber']){
                                $conversationnumbertemp = $row6['conversationnumber'];
                                if($row6['recipient']==$user){
                                    if($row6['readstatus1']=="unread"){
                                        $unreadnumber = $unreadnumber + 1;
                                    }elseif(($row6['readstatus2']=="unread")&&($row6['readstatus1']!=$user)){
                                        $unreadnumber = $unreadnumber + 1;
                                    }
                                }elseif($row6['sender']==$user){
                                    if($row6['readstatus1']=="unread"){
                                        $unreadnumber = $unreadnumber + 1;
                                    }elseif(($row6['readstatus2']=="unread")&&($row6['readstatus1']!=$user)){
                                        $unreadnumber = $unreadnumber + 1;
                                    }
                                }
                            }
                        }
                        ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-envelope fa-fw"></i>
                                <i class="fa fa-caret-down">
                                    <?php
                                    if($unreadnumber!='0'){
                                    echo "(".$unreadnumber.")";
                                    }
                                    ?>
                                </i>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <?php
                                $sql6 = "SELECT * FROM messages WHERE recipient='".$user."' OR sender='".$user."' ORDER BY conversationnumber DESC";
                                $result6 = mysql_query($sql6);
                                $conversationnumbertemp = "-1";
                                $isthere = "no";
                                $loopnumber = 0;
                                while($row6 = mysql_fetch_array($result6)){
                                    if(($conversationnumbertemp != $row6['conversationnumber'])&&($loopnumber<3)){
                                        $loopnumber = $loopnumber + 1;
                                        $isthere = "yes";
                                        $conversationnumbertemp = $row6['conversationnumber'];
                                        $messagenumber = 0;
                                        $sql1 = "SELECT * FROM messages WHERE conversationnumber='".$conversationnumbertemp."'";
                                        $result1 = mysql_query($sql1);
                                        $messagenumber = 0;
                                        $tempid = 0;
                                        while($row1 = mysql_fetch_array($result1)){
                                            $messagenumber = $messagenumber + 1;
                                            if($tempid<$row1['index']){
                                                $message = $row1['message'];
                                                $tempsender = $row1['sender'];
                                                $tempid = $row1['index'];
                                            }
                                        }
                                        if($row6['recipient']==$user){
                                            echo "
                                            <li>
                                                <a href='messaging.php?recipient=".$row6['sender']."'>
                                                    <div>
                                                        <strong>
                                                            @".$row6['sender']."(".$messagenumber.")";
                                                            if($row6['readstatus1']=="unread"){
                                                                echo "<b>-UNREAD-</b>";
                                                            }elseif(($row6['readstatus2']=="unread")&&($row6['readstatus1']!=$user)){
                                                                echo "<b>-UNREAD-</b>";
                                                            }
                                                            echo "
                                                        </strong>
                                                        <span class=' text-muted'>
                                                            <em>".$row6['timesent']."</em>
                                                        </span>
                                                    </div>
                                            ";
                                            ?>
                                                <?php
                                                if($tempsender==$user){
                                                    echo "<div>Me: ";
                                                }else{
                                                    echo "<div>";
                                                }
                                                echo substr($message, 0, 60);
                                                if(strlen($message)>60){
                                                    echo "...";
                                                }
                                                echo "</div>
                                                    </a>
                                                </li>
                                                <li class='divider'></li>";
                                                ?>
                                            <?php
                                        }elseif($row6['sender']==$user){
                                            echo "<li>
                                                    <a href='messaging.php?recipient=".$row6['recipient']."'>
                                                        <div>
                                                            <strong>@".$row6['recipient']."(".$messagenumber.")";
                                            if($row6['readstatus1']=="unread"){
                                                echo "<b>-UNREAD-</b>";
                                            }elseif(($row6['readstatus2']=="unread")&&($row6['readstatus1']!=$user)){
                                                echo "<b>-UNREAD-</b>";
                                            }
                                            echo "</strong>
                                                       <span class=' text-muted'>
                                                            <em>".$row6['timesent']."</em>
                                                        </span>
                                                        </div>
                                            ";
                                            ?>
                                                <?php 
                                                if($tempsender==$user){
                                                    echo "<div>Me: ";
                                                }else{
                                                    echo "<div>";
                                                }
                                                echo substr($message, 0, 60);
                                                if(strlen($message)>60){
                                                    echo "...";
                                                }
                                                echo "</div>
                                                    </a>
                                                </li>
                                                <li class='divider'></li>";
                                                ?>
                                            </p>
                                            <?php
                                        }
                                    }else{
                                  
                                    }
                                }
                                if($isthere == "no"){
                                    echo "<h3>You have no messages</h3>";
                                }
                                ?>
                                <li>
                                    <a class="text-center" href="inbox.php">
                                        <strong>Read All Messages</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        <!-- /.dropdown-messages -->
                        </li>
                        <li>
                            <a class="page-scroll" href="#contact">Contact</a>
                        </li>
                        <li>
                            <a href="inbox.php">Inbox</a>
                        </li>
                        <li>
                            <a href="signout.php">Log out (<?php echo $user;?>)</a>
                        </li>
                    <?php
                    }else{
                        ?>
                        <li>
                            <a class="page-scroll" href="#contact">Contact</a>
                        </li>
                        <li>
                            <a href="login.php">Login</a>
                        </li>
                        <li>
                            <a href="signup.php">Sign Up</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <section class="bg-signup" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center text-faded">
                    <h2>Sign up to M-KUKU</h2>
                    <hr class="light">
                    <?php
                    include "dbConnect.php";
                    if(mysql_select_db("mkuku")){
                        
                    }else{
                        echo "Error connecting to the database!";
                    }
                    if((isset($_POST['username']))&&($_POST['signup'])){
                        $name = $_POST['name'];
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $password = md5($password);

                        $writedbauth = "yes";

                        $sql1 = "SELECT * FROM users";
                        $result1 = mysql_query($sql1);
                        while($row1 = mysql_fetch_array($result1)){
                            if($row1['username'] == $username){
                                $writedbauth = "no";
                            }
                        }
                        if($writedbauth == "yes"){
                            $sql2 = "INSERT INTO users (name, username, email, password, profilepicture)
                                VALUES ('".$name."', '".$username."', '".$email."', '".$password."', 'no')";
                            if(mysql_query($sql2)){
                                echo "<br><h3>Signup successfull.</h3><br>";
                                echo "<br><h3><a href = 'login.php'>Login</h3></a>";
                            }
                        }else{
                            echo "<h4>The username you entered exists!</h4>";
                            echo "<br><h3><a href = 'login.php'>Login</h3></a>";
                        }
                    }elseif((isset($_POST['name']))&&($_POST['editprofile'])&&(isset($_SESSION['user']))){
                        $name = $_POST['name'];
                        $user = $_SESSION['user'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $password = md5($password);

                        $writedbauth = "yes";
                        $sql1 = "UPDATE users SET name='".$name."', email='".$email."', password='".$password."' WHERE username='".$user."'";
                        if(mysql_query($sql1)){
                            
                        }
                        $imagename = basename($_FILES["imagetoupload"]["name"]);
                        if($imagename == ""){
                            echo "<br><h3>Profile changed successfully.</h3><br>";
                            echo "<br><h3><a href = 'index.php'>Home</h3></a>";
                        }else{
                            $targetdir = "profilepictures/";
                            $targetfile = $targetdir . basename($_FILES["imagetoupload"]["name"]);
                            $uploadok = 1;
                            $imagefiletype = pathinfo($targetfile,PATHINFO_EXTENSION);
                            $check = getimagesize($_FILES["imagetoupload"]["tmp_name"]);
                            if($check !== false) {
                                $uploadok = 1;
                            } else {
                                echo "<br>File is not an image.";
                                $uploadok = 0;
                                $writedbauth = "no";
                            }
                            $targetfile2 = $targetdir . $user.".jpg";
                            if ($_FILES["imagetoupload"]["size"] > 20000000) {
                                echo "<br>File is too large (limit 20mb>).";
                                $uploadok = 0;
                                $writedbauth = "no";
                            }
                            $imagefiletype = strtolower($imagefiletype);
                            if($imagefiletype != "jpg") {
                                echo "<br>Only JPG files are allowed.";
                                $uploadok = 0;
                                $writedbauth = "no";
                            }
                            if ($uploadok == 0) {
                                echo "<br><h4>File cannot be uploaded!<br>
                                    <a href='editprofile.php' class='btn btn-success>Back to edit profile</a></h4>";
                            }else{
                                if (move_uploaded_file($_FILES["imagetoupload"]["tmp_name"], $targetfile2)) {
                                    $sql1 = "UPDATE users SET profilepicture='yes' WHERE username='".$user."'";
                                    if(mysql_query($sql1)){
                                        echo "<br><h3>Profile changed successfully.</h3><br>";
                                        echo "<br><h3><a href = 'index.php'>Home</h3></a>";
                                    }
                                }else{
                                    $writedbauth = "no";
                                    echo "<br><h4>There was an error uploading the file!<br>
                                    <a href='editprofile.php' class='btn btn-success'>Back to notice board</a></h4>";   
                                }
                            }
                        }

                    } elseif(($_POST['removeprofilepicture'])&&(isset($_SESSION['user']))){
                        $sql1 = "UPDATE users SET profilepicture='no' WHERE username='".$_SESSION['user']."'";
                        if(mysql_query($sql1)){
                            echo "<br><h3>Profile picture removed.</h3><br>";
                            echo "<br><h3><a href = 'index.php'>Home</h3></a>";
                        }
                    } else{
                        header("Location: mainpage.php");
                    }
                    ?>
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
                    <p>+254700223146</p>
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
                    <p><a href="mailto:info.onlinenoticeboard@gmail.com">For feedback, email us at: info.mkuku@gmail.com</a></p>
                </div>
                <footer>
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <p>Copyright &copy; M-KUKU2016</p>
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
