<?php
session_start();
//error_reporting(0);
include('class/config.php');

if(isset($_POST['submit'])) 
{
  $login_id = mysqli_real_escape_string($con, $_POST['login_id']);
  $password = mysqli_real_escape_string($con, md5($_POST['password']));

    $verify = "SELECT * FROM users WHERE BINARY username ='".$login_id."' AND BINARY password = '".$password."' AND active_status = 1";
    $result = mysqli_query($con, $verify);
    $row = mysqli_num_rows($result);
    $show = mysqli_fetch_assoc($result);

  if ($row==1) 
  {
    $_SESSION['position'] = $show['position'];

    if ($_SESSION['position'] == 1) 
    {
        $_SESSION['email'] = $show['email'];
        $_SESSION['username'] = $show['username'];
        
        //header('location: admin/index.php');
        echo "<script>window.location.href='admin/index.php';</script>";
        exit;
    }
    elseif ($_SESSION['position'] == 2) 
    {
        $_SESSION['username'] = $show['username'];
        
        //header('location: telecaller/index.php');
        echo "<script>window.location.href='telecaller/index.php';</script>";
        exit;
    }
    elseif ($_SESSION['position'] == 3) 
    {
        $_SESSION['username'] = $show['username'];
        $_SESSION['email'] = $show['email'];
        $_SESSION['subadmin_id'] = $show['id'];
        
        //header('location: subadmin/index.php');
        echo "<script>window.location.href='subadmin/index.php';</script>";
        exit;
    }
    elseif ($_SESSION['position'] == 4) 
    {
        $_SESSION['clientUsername'] = $show['username'];
        
        //header('location: user/index.php');
        echo "<script>window.location.href='user/index.php';</script>";
        exit;
    }
    elseif ($_SESSION['position'] == 5) 
    {
        $_SESSION['username'] = $show['username'];
        $_SESSION['email'] = $show['email'];
        $_SESSION['subadmin_id'] = $show['id'];
        
        //header('location: subadmin/index.php');
        echo "<script>window.location.href='asm/index.php';</script>";
        exit;
    }

  }
  else {
         $error = "<h6><font color='red'>Your Username or Password is invalid</font></h6>";
      }
}
elseif (isset($_POST['setPass'])) 
{
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $select = " SELECT email FROM users WHERE email = '".$email."' ";
    $row = mysqli_query($con, $select);
    $run = mysqli_fetch_assoc($row);
    $run1 = mysqli_fetch_array($row);

    if ($email == $run['email'])
    {
        $select = "SELECT * FROM users WHERE email = '".$email."' ";
        $rowSelect = mysqli_query($con, $select);
        $runSelect = mysqli_fetch_assoc($rowSelect);

        $FROM = 0;
        $TO = 'zzzz';
        $code1 = base_convert(rand( $FROM ,base_convert( $TO , 36,10)),10,36);
        $code2 = strtoupper($code1);
        $code = $code2;
        $enCode = md5($code2);

        $header = "From: Bharat_Finn\r\n";
        $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $header .= "Reply-To: contact@bharatfinn.in\r\n";
        $message = "Hi ".$runSelect['name'].",<br>\n\r";
        $message .= "You requested for New Password, Your New Reset Password is <b>".$code."</b>\n\r";
        $message .= "<br>-Password Reset\n\r";
        $subject = "Bharat Finn";
        $message = wordwrap($message, 200);
    
        $update = "UPDATE users SET password = '".$enCode."', or_pass = '".$code."' WHERE email ='".$email."' ";
        mysqli_query($con, $update);
    
        if(mail($email, $subject, $message, $header) )
        {
            $msg = "<font color='green'> Password sent on registered Email ID</font>";
        }
        else
        {
            $msg = "<font color='red'>Password not sent.</font>";
        }
    }
    else
    {
        $msg = "<font color='red'>Email ID is Not Registered.</font>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Bharat Finn Services | Login | Lead Management System</title>
    <meta content="Admin Dashboard" name="description">
    <meta content="Mannatthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/bharat_finn_logo.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>

<body class="fixed-left">
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body" style="padding: 0.25rem;">
                <div class="text-center">
                    <a href="index.php" class="logo logo-admin">
                        <img src="assets/images/bharat_finn_logo.png" alt="logo" style="width: 171px; height: 128px;">
                    </a>
                </div>
                <div class="p-3">
                    <form class="form-horizontal m-t-20" method="POST" id="loginForm">
                        <div class="form-group row">
                            <div class="col-12">
                                <span class="help-block small">Your unique username</span>
                                <input type="text" title="Please enter your uername" class="form-control" name="login_id" id="login_id" placeholder="User name" autofocus required="required">                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <span class="help-block small">Your strong password</span>
                                <input class="form-control" type="password" title="Please enter your password" required="required" name="password" id="password" placeholder="Password">
                                <input type="checkbox" onclick="showHidePass()"> <span class="help-block small">Show Password</span>
                            </div>
                        </div>                      
                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button name="submit" class="btn btn-danger btn-block waves-effect waves-light" type="submit">Log In</button>
                            </div>
                        </div>
                    </form>

                    <div class="form-group row" id="forgetHidePass" style="">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <a href="#" id="button1">Forget Password ?</a><br>
                                <a href="user/client_registration.php">Sign Up</a>
                            </div>
                        </div>                            
                    </div>

                    <div class="col-md-12" id="forgetPass" style="display: none;">
                        <div class="" style="font-size: 11px;">
                            <form method="POST">
                                
                                <div class="form-group text-center row m-t-20">
                                    <div class="col-12">
                                        <input type="email" name="email" placeholder="Enter Registered Email ID" class="form-control" required>
                                    </div>
                                </div>
                            
                                <div class="form-group text-center row m-t-20">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-danger btn-block waves-effect waves-light" name="setPass" style="border: none;">Send Password</button>
                                    </div>
                                </div>
                            
                                <div class="form-group row" id="forgetPass" style="margin-left:50%;">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <a href="#" id="back" style="font-size: 14px;">Back</a>
                                        </div>
                                    </div>                            
                                </div>
                                       
                            </form>
                        </div>
                    </div>
                    <span id="msg" style="text-align: center; padding-bottom: 10px;">
                        <?php 
                            echo $error;
                            echo $msg; 
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <!--
            # Site Developed By: Mr. Nikhil M. Dange
        -->
        <footer class="footer">Copyright &copy; <script>document.write(new Date().getFullYear());</script>. Bharat Finn Services.</footer>
    </div>

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.nicescroll.zoojs"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <script type="text/javascript">
    function showHidePass()
    {
        var x = document.getElementById("password");
        if (x.type === "password")
        {
            x.type = "text";
        }
        else
        {
            x.type = "password";
        }
    }

        $(function()
        {
            setTimeout(function() { $("#msg").fadeOut(1500); }, 5000)
            $('#msg').click(function() {
            $('#msg').show();
            setTimeout(function() { $("#msg").fadeOut(1500); }, 5000)
            });
            });        

        $(document).on('click', '#button1', function()
        { 
            $('#loginForm').hide();
            $('#forgetHidePass').hide();

            $('#forgetPass').show();
        });

        $(document).on('click', '#back', function()
        { 
            $('#loginForm').show();
            $('#forgetHidePass').show();

            $('#forgetPass').hide();
        });

        $('.pass_show').append('<span class="ptxt">Show</span>');

        $(document).on('click','.pass_show .ptxt', function()
        {
            $(this).text($(this).text() == "Show" ? "Hide" : "Show");
            $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; });
        });


        if (window.history.replaceState) 
        {
            window.history.replaceState(null, null, window.location.href);
        }

</script>
</body>

</html>