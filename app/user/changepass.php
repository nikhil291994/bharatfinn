<?php
 
session_start();
error_reporting(0);

include('../class/config.php');

if (!isset($_SESSION['clientUsername'])) 
{
    header('location: ../index.php');
}

if(isset($_POST['submit'])) 
{
$oldpass = mysqli_real_escape_string($con, md5($_POST['oldpass']));
$newpass = mysqli_real_escape_string($con, $_POST['newpass']);
$confirmpass = mysqli_real_escape_string($con, $_POST['confirmpass']);
$encPass = mysqli_real_escape_string($con, md5($_POST['newpass']));

$select= "SELECT password FROM users WHERE password='".$oldpass."' && username='".$_SESSION['clientUsername']."' ";
$check = mysqli_query($con, $select);

$row= mysqli_fetch_assoc($check);
$pass = $row['password'];

if ($encPass == $pass) 
{
$msg = "<span class='alert bg-gradient1 text-white' role='alert'>New Password is same as Current Password</span>";
}
else
{
if($oldpass==$pass)
{
    if ($newpass == $confirmpass) 
    {   
        $update = "UPDATE users SET password = '".$encPass."', or_pass = '".$newpass."' WHERE username = '".$_SESSION['clientUsername']."' ";
        mysqli_query($con, $update);
        $msg = "<span class='alert bg-gradient2 text-white' role='alert'><strong>Well done!&nbsp;&nbsp;Password Successfully Changed..!!!</strong></span>";
        
    }
    else
    {
        $msg = "<span class='alert bg-gradient1 text-white' role='alert'>New Password and Confirm Password does not match..!!!</span>";
    }
}
else
{
$msg = "<span class='alert bg-gradient1 text-white' role='alert'>Your Current Password is wrong..!!!</span>";
}
}
}

?>

<!DOCTYPE html>
<html lang="en">
<!-- index.html  11:55:53 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Client | Change_Password | Bharat Finn</title>
    <meta content="Admin Dashboard" name="description">
    <meta content="Mannatthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../assets/images/bharat_finn_logo.png">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="../assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <!-- Responsive datatable examples -->
    <link href="../assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css">

   <!--  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

        <style type="text/css">
            .pass_show{position: relative} 

    .pass_show .ptxt { 

    position: absolute; 

    top: 50%; 

    left: 67%;

    z-index: 1; 

    color: #339a95; 

    margin-top: -10px; 

    cursor: pointer; 

    transition: .3s ease all; 

    } 

    .pass_show .ptxt:hover{color: #333333;} 

    .form-control{
        width: 80%;
    }
        </style>
    
    <style type="text/css">
    input[type="password"]::-webkit-input-placeholder {
                color: #c4c4c4;
        }
        text{
            font-size: 16px !important; 
        }
        form{
                margin-left: 50px;
            }
    </style>

</head>



<body class="fixed-left">
    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div> -->
    <!-- Begin page -->
    <div id="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect"><i class="ion-close"></i></button>
            <!-- LOGO -->
            <div class="topbar-left">
                
            </div>
            <?php include 'sidebar.php'; ?>
            
            <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <!-- Top Bar Start -->
                <?php include 'navbar.php'; ?>
                <!-- Top Bar End -->
                <div class="page-content-wrapper">
                    <div class="container-fluid">
                        
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                            <!-- <div class="card" style="margin-left: 229px; margin-right: 272px;"> -->
                            <div class="card" style="">
                                    <div class="card-body">
                                       <div class="card-header">
                                            <strong>Change Password</strong> 
                                        </div> <br><br>
                                        <form method="POST" id="editprofile" class="form-horizontal" enctype="multipart/form-data">                                            
                                            <div class="form-group">
                                                <label>Current Password</label>
                                                <div class="pass_show">
                                    <input type="password" name="oldpass" class="form-control" placeholder="********" id="opassword" autofocus required> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <div class="pass_show">
                                    <input type="password" name="newpass" class="form-password form-control" placeholder="********" id="npassword" required> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <div class="pass_show">
                                    <input type="password"  name="confirmpass" class="form-password form-control" placeholder="********" id="cpassword"  required></div>
                                            </div>
                                            
                                            <div class="form-group mb-0">
                                                <div>
                                                    <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light">                         <i class="fa fa-dot-circle-o"></i>Change</button>
                                                    <button type="reset" class="btn btn-delete waves-effect m-l-5"><i class="fa fa-ban"></i> Clear</button>
                                                </div>
                                            </div>
                                        </form><br>

                                    <p id="msg" style="text-align: center; padding-bottom: 10px;"><?php echo $msg; ?></p>

                                        
                                    </div>
                                </div>
                            </div>
                            
                            <!-- end col -->
                        </div>
                        <!-- end row -->




                    </div>
                    <!-- container -->
                </div>
                <!-- Page content Wrapper -->
            </div>
            <!-- content -->
            <?php include 'footer.php'; ?>
        </div>
        <!-- End Right content here -->
    </div>
    <!-- END wrapper -->
    <!-- jQuery  -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/modernizr.min.js"></script>
    <script src="../assets/js/detect.js"></script>
    <script src="../assets/js/fastclick.js"></script>
    <script src="../assets/js/jquery.slimscroll.js"></script>
    <script src="../assets/js/jquery.blockUI.js"></script>
    <script src="../assets/js/waves.js"></script>
    <script src="../assets/js/jquery.nicescroll.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../assets/plugins/chart.js/chart.min.js"></script>
    <script src="../assets/pages/dashboard.js"></script>
    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/canvasjs.min.js"></script>
        <!-- Required datatable js -->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="../assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="../assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables/jszip.min.js"></script>
    <script src="../assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="../assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="../assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="../assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="../assets/plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="../assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="../assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="../assets/pages/datatables.init.js"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
   <!--  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->

<script type="text/javascript">
        $('.digit').keyup(function() {
            var val = $(this).val();
            if (isNaN(val)) {
                val = val.replace(/[^0-9]/g, '');
                if (val.split('.').length > 2)
                    val = val.replace(/\.+$/, "");
            }
            $(this).val(val);
            });

            if (window.history.replaceState) 
            {
                window.history.replaceState(null, null, window.location.href);
            }
    </script>
<script type="text/javascript">
    $(document).ready(function(){
$('.pass_show').append('<span class="ptxt">Show</span>');  
});
  

$(document).on('click','.pass_show .ptxt', function(){ 

$(this).text($(this).text() == "Show" ? "Hide" : "Show"); 

$(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

}); 

if (window.history.replaceState) 
{
    window.history.replaceState(null, null, window.location.href);
}




$(function() {
setTimeout(function() { $("#msg").fadeOut(1500); }, 5000)
$('#msg').click(function() {
$('#msg').show();
setTimeout(function() { $("#msg").fadeOut(1500); }, 5000)
})
})


</script>
</body>
</html>