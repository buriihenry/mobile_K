<?php
session_start();
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}else{
    header("Location: login.php");
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

    <title>M_KUKU</title>

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
                    <?php
                    include "dbConnect.php";
                    if(mysql_select_db("mkuku")){
                        
                    }else{
                        echo "Error connecting to the database!";
                    }
                    ?>
                <a class="navbar-brand page-scroll" href="#page-top">
                    M-KUKU</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <img src="img/logo2t.png" width = "4%">
                <ul class="nav navbar-nav navbar-right">
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
                        <a class="page-scroll" href="#about">Latest posts</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Popular posts</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#portfolio">General</a>
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
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner text-dark">
                <h1>Welcome to M-KUKU</h1>
                <hr>
                <a href="#portfolio" class="btn btn-primary btn-xl page-scroll">Jump right in</a>
            </div>
        </div>
    </header>

    <section class="bg-image1" id="about">
        <div class="container text-center">

            <div class="row text-center">
                <div class="col-lg-12 col-lg-offset-0 text-center text-faded">
                    <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading text-faded">Latest posts</h2>    
                    <hr class="light">

                    <div >

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" class="text-white">Posters</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active text-dark" id="home">
                            <?php
                            $postsnumber = 0;
                            $sql4 = "SELECT * FROM posts ORDER BY `index` DESC";
                            $result4 = mysql_query($sql4);
                            while($row4 = mysql_fetch_array($result4)){
                                $noticeboardid = $row4['noticeboardid'];
                                $sql1 = "SELECT * FROM noticeboards WHERE noticeboardid='".$noticeboardid."'";
                                $result1 = mysql_query($sql1);
                                while($row1 = mysql_fetch_array($result1)){
                                    $privacy = $row1['privacy'];
                                    $owner = $row1['user'];
                                }
                                $canview = "no";
                                if($privacy == "private"){
                                    $sql7 = "SELECT * FROM authorizedusers WHERE noticeboardid='".$noticeboardid."'";
                                    $result7 = mysql_query($sql7);
                                    if(isset($_SESSION['user'])){
                                        while($row7 = mysql_fetch_array($result7)){
                                            if($row7['user'] == $user){
                                                $canview = "yes";
                                            }
                                        }
                                    }
                                    if($user == $owner){
                                        $canview = "yes";
                                    }
                                }else{
                                    $canview = "yes";
                                }
                                if(($canview == "yes")&&($postsnumber!=3)){
                                    if($row4['active']=="active"){
                                        $postsnumber = $postsnumber + 1;
                                        if($row4['imageid']=="none"){
                                            ?>
                                            <div class="col-lg-4">
                                                <div class="panel panel-green">
                                                    <div class="panel-heading">
                                                        <h4><?php echo $row4['postheading']; ?></h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p>
                                                            <?php 
                                                            echo substr($row4['postmessage'], 0, 60);
                                                            if(strlen($row4['postmessage'])>60){
                                                                echo "...";
                                                            }
                                                            ?>
                                                        </p>
                                                        <?php
                                                        $noticeboardid = $row4['noticeboardid'];
                                                        $sql1 = "SELECT * FROM noticeboards WHERE noticeboardid='".$noticeboardid."'";
                                                        $result1 = mysql_query($sql1);
                                                        while($row1 = mysql_fetch_array($result1)){
                                                            $noticeboardname = $row1['noticeboardname'];
                                                        }
                                                        ?>
                                                        <a href=<?php echo "'viewnoticeboard.php?noticeboardid=".$row4['noticeboardid']."'";?>><h4><?php echo $noticeboardname; ?></h4></a>
                                                        <a href=<?php echo "'viewpost.php?noticeboardid=".$row4['noticeboardid']."&postid=".$row4['postid']."'"; ?> class="btn btn-outline btn-info btn-block">More details</a>
                                                        Views: <?php echo $row4['views']; ?>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <i class="glyphicon fa-1x glyphicon-ok-sign wow bounceIn text-info"><?php echo $row4['noticednumber']; ?></i>
                                                        <i class="glyphicon fa-1x glyphicon-option-vertical "></i>
                                                        <?php
                                                        $noticed = "no";
                                                        $sql6 = "SELECT * FROM noticedposts WHERE postid='".$row4['postid']."'";
                                                        $result6 = mysql_query($sql6);
                                                        while($row6 = mysql_fetch_array($result6)){
                                                            if($user == $row6['user']){
                                                                $noticed = "yes";
                                                            }
                                                        }
                                                        if($noticed=="no"){
                                                            echo" 
                                                            <a href='deactivatepost.php?postid=".$row4['postid']."&noticed=".$noticed."&noticeboardid=".$row4['noticeboardid']."' class='wow bounceIn text-info'>Notice</a>"
                                                            ;
                                                        }else{
                                                            echo" 
                                                            <a href='deactivatepost.php?postid=".$row4['postid']."&noticed=".$noticed."&noticeboardid=".$row4['noticeboardid']."' class='wow bounceIn text-info'>Unnotice</a>"
                                                            ;   
                                                        }
                                                        ?>
                                                        <i class="fa fa-1x fa-barcode"></i>
                                                        <a href=<?php echo "'viewpost.php?noticeboardid=".$row4['noticeboardid']."&postid=".$row4['postid']."'"; ?>><i class="fa fa-1x fa-comments wow bounceIn text-info"><?php echo $row4['commentnumber']; ?></i></a>
                                                    </div>
                                                </div>
                                                <!-- /.col-lg-4 -->
                                            </div>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="col-lg-4">
                                                <div class="panel panel-green">
                                                    <div class="panel-heading">
                                                        <h4><?php echo $row4['postheading']; ?></h4>
                                                    </div>
                                                    <a href=<?php echo "'postimages/".$row4['imageid'].".jpg'"; ?>><img src = <?php echo "'postimages/".$row4['imageid'].".jpg'"; ?> width = "100%"></a>
                                                    <div class="panel-body">
                                                        <p>
                                                            <?php 
                                                            echo substr($row4['postmessage'], 0, 60);
                                                            if(strlen($row4['postmessage'])>60){
                                                                echo "...";
                                                            }
                                                            ?>
                                                        </p>
                                                        <?php
                                                        $noticeboardid = $row4['noticeboardid'];
                                                        $sql1 = "SELECT * FROM noticeboards WHERE noticeboardid='".$noticeboardid."'";
                                                        $result1 = mysql_query($sql1);
                                                        while($row1 = mysql_fetch_array($result1)){
                                                            $noticeboardname = $row1['noticeboardname'];
                                                        }
                                                        ?>
                                                        <a href=<?php echo "'viewnoticeboard.php?noticeboardid=".$row4['noticeboardid']."'";?>><h4><?php echo $noticeboardname; ?></h4></a>
                                                        <a href=<?php echo "'viewpost.php?noticeboardid=".$row4['noticeboardid']."&postid=".$row4['postid']."'"; ?> class="btn btn-outline btn-info btn-block">More details</a>
                                                        Views: <?php echo $row4['views']; ?>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <i class="glyphicon fa-1x glyphicon-ok-sign wow bounceIn text-info"><?php echo $row4['noticednumber']; ?></i>
                                                        <i class="glyphicon fa-1x glyphicon-option-vertical "></i>
                                                        <?php
                                                        $noticed = "no";
                                                        $sql6 = "SELECT * FROM noticedposts WHERE postid='".$row4['postid']."'";
                                                        $result6 = mysql_query($sql6);
                                                        while($row6 = mysql_fetch_array($result6)){
                                                            if($user == $row6['user']){
                                                                $noticed = "yes";
                                                            }
                                                        }
                                                        if($noticed=="no"){
                                                            echo" 
                                                            <a href='deactivatepost.php?postid=".$row4['postid']."&noticed=".$noticed."&noticeboardid=".$row4['noticeboardid']."' class='wow bounceIn text-info'>Notice</a>"
                                                            ;
                                                        }else{
                                                            echo" 
                                                            <a href='deactivatepost.php?postid=".$row4['postid']."&noticed=".$noticed."&noticeboardid=".$row4['noticeboardid']."' class='wow bounceIn text-info'>Unnotice</a>"
                                                            ;   
                                                        }
                                                        ?>
                                                        <i class="fa fa-1x fa-barcode"></i>
                                                        <a href=<?php echo "'viewpost.php?noticeboardid=".$row4['noticeboardid']."&postid=".$row4['postid']."'"; ?>><i class="fa fa-1x fa-comments wow bounceIn text-info"><?php echo $row4['commentnumber']; ?></i></a>
                                                    </div>
                                                </div>
                                                <!-- /.col-lg-4 -->
                                            </div>
                                            <?php
                                        }
                                    }else{

                                    }
                                }
                            }
                            if($postsnumber == '0'){
                                echo "<h3 class='text-faded'>No existing posts!</h3>";
                            }
                            ?>
                        </div>
                      </div>
                    </div>
                </div>
                
                </div>
            </div>
        <a href="latestposts.php" class="btn  btn-info btn-xl">Expand</a>
        </div>
    </section>

    <section id="services" class="bg-popular">
        <div class="container text-center">

            <div class="row text-center">
                <div class="col-lg-12 col-lg-offset-0 text-center text-faded">
                    <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading text-faded">Popular posts</h2>
                    <hr class="light">

                    <div >

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" class="text-white">Posters</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active text-dark" id="home">
                            <?php
                            $control = "no";
                            $postsnumber = 0;
                            $sql4 = "SELECT * FROM posts ORDER BY noticednumber DESC";
                            $result4 = mysql_query($sql4);
                            while($row4 = mysql_fetch_array($result4)){
                                $noticeboardid = $row4['noticeboardid'];
                                $sql1 = "SELECT * FROM noticeboards WHERE noticeboardid='".$noticeboardid."'";
                                $result1 = mysql_query($sql1);
                                while($row1 = mysql_fetch_array($result1)){
                                    $privacy = $row1['privacy'];
                                    $owner = $row1['user'];
                                }
                                $canview = "no";
                                if($privacy == "private"){
                                    $sql7 = "SELECT * FROM authorizedusers WHERE noticeboardid='".$noticeboardid."'";
                                    $result7 = mysql_query($sql7);
                                    if(isset($_SESSION['user'])){
                                        while($row7 = mysql_fetch_array($result7)){
                                            if($row7['user'] == $user){
                                                $canview = "yes";
                                            }
                                        }
                                    }
                                    if($user == $owner){
                                        $canview = "yes";
                                    }
                                }else{
                                    $canview = "yes";
                                }
                                if(($canview == "yes")&&($postsnumber!=3)){
                                    if($row4['active']=="active"){
                                        $postsnumber = $postsnumber + 1;
                                        if($row4['imageid']=="none"){
                                            ?>
                                            <div class="col-lg-4">
                                                <div class="panel panel-green">
                                                    <div class="panel-heading">
                                                        <h4><?php echo $row4['postheading']; ?></h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p>
                                                            <?php 
                                                            echo substr($row4['postmessage'], 0, 60);
                                                            if(strlen($row4['postmessage'])>60){
                                                                echo "...";
                                                            }
                                                            ?>
                                                        </p>
                                                        <?php
                                                        $noticeboardid = $row4['noticeboardid'];
                                                        $sql1 = "SELECT * FROM noticeboards WHERE noticeboardid='".$noticeboardid."'";
                                                        $result1 = mysql_query($sql1);
                                                        while($row1 = mysql_fetch_array($result1)){
                                                            $noticeboardname = $row1['noticeboardname'];
                                                        }
                                                        ?>
                                                        <a href=<?php echo "'viewnoticeboard.php?noticeboardid=".$row4['noticeboardid']."'";?>><h4><?php echo $noticeboardname; ?></h4></a>
                                                        <a href=<?php echo "'viewpost.php?noticeboardid=".$row4['noticeboardid']."&postid=".$row4['postid']."'"; ?> class="btn btn-outline btn-info btn-block">More details</a>
                                                        Views: <?php echo $row4['views']; ?>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <i class="glyphicon fa-1x glyphicon-ok-sign wow bounceIn text-info"><?php echo $row4['noticednumber']; ?></i>
                                                        <i class="glyphicon fa-1x glyphicon-option-vertical "></i>
                                                        <?php
                                                        $noticed = "no";
                                                        $sql6 = "SELECT * FROM noticedposts WHERE postid='".$row4['postid']."'";
                                                        $result6 = mysql_query($sql6);
                                                        while($row6 = mysql_fetch_array($result6)){
                                                            if($user == $row6['user']){
                                                                $noticed = "yes";
                                                            }
                                                        }
                                                        if($noticed=="no"){
                                                            echo" 
                                                            <a href='deactivatepost.php?postid=".$row4['postid']."&noticed=".$noticed."&noticeboardid=".$row4['noticeboardid']."' class='wow bounceIn text-info'>Notice</a>"
                                                            ;
                                                        }else{
                                                            echo" 
                                                            <a href='deactivatepost.php?postid=".$row4['postid']."&noticed=".$noticed."&noticeboardid=".$row4['noticeboardid']."' class='wow bounceIn text-info'>Unnotice</a>"
                                                            ;   
                                                        }
                                                        ?>
                                                        <i class="fa fa-1x fa-barcode"></i>
                                                        <a href=<?php echo "'viewpost.php?noticeboardid=".$row4['noticeboardid']."&postid=".$row4['postid']."'"; ?>><i class="fa fa-1x fa-comments wow bounceIn text-info"><?php echo $row4['commentnumber']; ?></i></a>
                                                    </div>
                                                </div>
                                                <!-- /.col-lg-4 -->
                                            </div>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="col-lg-4">
                                                <div class="panel panel-green">
                                                    <div class="panel-heading">
                                                        <h4><?php echo $row4['postheading']; ?></h4>
                                                    </div>
                                                    <a href=<?php echo "'postimages/".$row4['imageid'].".jpg'"; ?>><img src = <?php echo "'postimages/".$row4['imageid'].".jpg'"; ?> width = "100%"></a>
                                                    <div class="panel-body">
                                                        <p>
                                                            <?php 
                                                            echo substr($row4['postmessage'], 0, 60);
                                                            if(strlen($row4['postmessage'])>60){
                                                                echo "...";
                                                            }
                                                            ?>
                                                        </p>
                                                        <?php
                                                        $noticeboardid = $row4['noticeboardid'];
                                                        $sql1 = "SELECT * FROM noticeboards WHERE noticeboardid='".$noticeboardid."'";
                                                        $result1 = mysql_query($sql1);
                                                        while($row1 = mysql_fetch_array($result1)){
                                                            $noticeboardname = $row1['noticeboardname'];
                                                        }
                                                        ?>
                                                        <a href=<?php echo "'viewnoticeboard.php?noticeboardid=".$row4['noticeboardid']."'";?>><h4><?php echo $noticeboardname; ?></h4></a>
                                                        <a href=<?php echo "'viewpost.php?noticeboardid=".$row4['noticeboardid']."&postid=".$row4['postid']."'"; ?> class="btn btn-outline btn-info btn-block">More details</a>
                                                        Views: <?php echo $row4['views']; ?>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <i class="glyphicon fa-1x glyphicon-ok-sign wow bounceIn text-info"><?php echo $row4['noticednumber']; ?></i>
                                                        <i class="glyphicon fa-1x glyphicon-option-vertical "></i>
                                                        <?php
                                                        $noticed = "no";
                                                        $sql6 = "SELECT * FROM noticedposts WHERE postid='".$row4['postid']."'";
                                                        $result6 = mysql_query($sql6);
                                                        while($row6 = mysql_fetch_array($result6)){
                                                            if($user == $row6['user']){
                                                                $noticed = "yes";
                                                            }
                                                        }
                                                        if($noticed=="no"){
                                                            echo" 
                                                            <a href='deactivatepost.php?postid=".$row4['postid']."&noticed=".$noticed."&noticeboardid=".$row4['noticeboardid']."' class='wow bounceIn text-info'>Notice</a>"
                                                            ;
                                                        }else{
                                                            echo" 
                                                            <a href='deactivatepost.php?postid=".$row4['postid']."&noticed=".$noticed."&noticeboardid=".$row4['noticeboardid']."' class='wow bounceIn text-info'>Unnotice</a>"
                                                            ;   
                                                        }
                                                        ?>
                                                        <i class="fa fa-1x fa-barcode"></i>
                                                        <a href=<?php echo "'viewpost.php?noticeboardid=".$row4['noticeboardid']."&postid=".$row4['postid']."'"; ?>><i class="fa fa-1x fa-comments wow bounceIn text-info"><?php echo $row4['commentnumber']; ?></i></a>
                                                    </div>
                                                </div>
                                                <!-- /.col-lg-4 -->
                                            </div>
                                            <?php
                                        }
                                    }else{

                                    }
                                }
                            }
                            if($postsnumber == '0'){
                                echo "<h3 class='text-faded'>No existing posts!</h3>";
                            }
                            ?>
                        </div>
                      </div>
                    </div>
                </div>
                
                </div>
            </div>
        <a href="popularposts.php" class="btn  btn-info btn-xl">Expand</a>
        </div>
    </section>

    <section class="no-padding bg-dark" id="portfolio">
        <div class="container-fluid">
            <div class="row no-gutter">
                <div class="col-lg-4 col-sm-6">
                    <a href="createnew.php" class="portfolio-box">
                        <img src="img/1.jpg" width="100%" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-name">
                                    Create a new notice board
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="othernoticeboards.php" class="portfolio-box">
                        <img src="img/2.jpg" width="100%" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-name">
                                    View other notice boards
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="taggednoticeboards.php" class="portfolio-box">
                        <img src="img/3.jpg" width="100%" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-name">
                                    View notice boards you have taged
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="yournoticeboards.php" class="portfolio-box">
                        <img src="img/4.jpg" width="100%" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-name">
                                    View your notice boards
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="yourpopularposts.php" class="portfolio-box">
                        <img src="img/5.jpg" width="100%" alt="" width="100%">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-name">
                                    View your popular posts
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="editprofile.php" class="portfolio-box">
                        <?php
                        $sql2 = "SELECT * FROM users WHERE username='".$user."'";
                        $result2 = mysql_query($sql2);
                        while($row2 = mysql_fetch_array($result2)){
                            if($row2['profilepicture']=="yes"){
                                ?>
                                <img src=<?php echo "'profilepictures/".$user.".jpg'";?>"profilepicture/header.jpg" alt="Avatar" width="100%"/>
                                <?php
                            }else{
                                ?>
                                <img src="img/header.jpg" alt="Avatar" width="100%"/>
                                <?php
                            }
                        }
                        ?>
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-name">
                                    Edit your profile
                                </div>
                            </div>
                        </div>
                    </a>
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
                    <p><a href="mailto:info.onlinenoticeboard@gmail.com">For feedback, email us at: info.mkuku@gmail.com</a></p>
                </div>
                <footer>
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <p>Copyright &copy; mkuku2016</p>
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
