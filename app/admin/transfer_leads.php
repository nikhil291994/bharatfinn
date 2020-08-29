<?php
session_start();
error_reporting(0);
include('../class/config.php');


if (!isset($_SESSION['email'])) 
{
    header('location: ../index.php');
}

if(isset($_POST['transfer'])) 
{
    $from_user_id = mysqli_real_escape_string($con, $_POST['from_user_id']);
    $to_user_id = mysqli_real_escape_string($con, $_POST['to_user_id']);
    $swapValue = '2';

    if ($from_user_id == $to_user_id)
    {
        $msg = "<span class='alert' role='alert'><font color='red'>From and To must be different to transfer leads...!!!</font></span>";
    }
    else
    {
        function get_client_ip()
        {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_FORWARDED'])) {
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            } else if (isset($_SERVER['REMOTE_ADDR'])) {
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            } else {
                $ipaddress = 'UNKNOWN';
            }

            return $ipaddress;
        }
        $PublicIP = get_client_ip();
        $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
        $json     = json_decode($json, true);
        $country  = $json['country'];
        $region   = $json['region'];
        $city     = $json['city'];

        if(function_exists('date_default_timezone_set'))
        {
            date_default_timezone_set("Asia/Kolkata");
        }
        $submit_date = date("d/m/Y");
        $submit_time =  date("H:i a");
        $time = $submit_date.'-'.$submit_time;

        $myFile = "TransferLeadsLogs.txt";
        $message = $from_user_id." User Id Lead Transfer In User Id ".$to_user_id." - ".$time." - ".$country."/".$region."/".$city;
        if (file_exists($myFile))
        {
            $fh = fopen($myFile, 'a');
        }
        else
        {
            $fh = fopen($myFile, 'w');
        }
        fwrite($fh, $message."\n");
        fclose($fh);
        //UPDATE `leads` SET `assign_subadmin_id` = '29' WHERE `assign_subadmin_id` = '33'

        $update1 = "UPDATE leads SET assign_subadmin_id = '".$to_user_id."'  WHERE assign_subadmin_id = '".$from_user_id."'";
        $update2 = "UPDATE leads SET assign_tele_id = '".$to_user_id."'  WHERE assign_tele_id = '".$from_user_id."'";
        $update33 = "UPDATE users SET under_sub_admin_id = '".$to_user_id."'  WHERE under_sub_admin_id = '".$from_user_id."'";
        //$update3 = "UPDATE leads SET assign_tele_id = '".$to_user_id."'  WHERE assign_subadmin_id = '".$to_user_id."'";
        //$update4 = "UPDATE leads SET assign_subadmin_id = '".$to_user_id."'  WHERE assign_tele_id = '".$to_user_id."'";
        
        //$update1 = "UPDATE users SET id = '".$swapValue."'  WHERE id = '".$from_user_id."'";
        //$update2 = "UPDATE users SET id = '".$from_user_id."'  WHERE id = '".$to_user_id."'";
        //$update3 = "UPDATE users SET id = '".$to_user_id."'  WHERE id = '".$swapValue."'";

        mysqli_query($con, $update1);
        mysqli_query($con, $update2);
        mysqli_query($con, $update33);
        //mysqli_query($con, $update3);
        //mysqli_query($con, $update4);

        $msg = "<span class='alert' role='alert'><font color='green'>Lead Transfer Successfully..!!!</font></span>";
    }    
}    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Super Admin | Transfer Lead | Bharat Finn</title>
    <meta content="Admin Dashboard" name="description">
    <meta content="Mannatthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../assets/images/favicon.png">
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
    <link href="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <?php include 'sidebar.php'; ?>
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <div class="btn-group float-right">
                                        <ol class="breadcrumb hide-phone p-0 m-0">
                                            <li class="breadcrumb-item"><a href="index.php">Super Admin</a></li>
                                            <li class="breadcrumb-item active">Transfer Leads</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Transfer Leads</h4></div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->                        
<div class="col-md-6 row">
	<div class="card">
        <div class="card-body">
			<form method="POST">
			    <div class="col-md-12">
			        <table align="center" class="" style="table-layout: fixed;">
			            <tr>
                            <td>From: </td>
                            <td>
                                <select name="from_user_id" class="form-control" required>
                                    <option value="">Select Team Leader</option>
            			                <?php                  
            			                    $sql1 = 'SELECT * FROM users WHERE position = 3 ';
            			                    $query1 = mysqli_query($con,$sql1);
            			                    $x=1;
            			                    while($row1 = mysqli_fetch_assoc($query1))
            			                    {
                                        ?>
                                    <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name'].'-'.$row1['login_id']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> To: </td>
                            <td>
                                <select name="to_user_id" class="form-control" required>
                                    <option value="">Select Team Leader</option>
                                    <?php
                                        $sql1 = 'SELECT * FROM users WHERE position = 3 ';
                                        $query1 = mysqli_query($con,$sql1);
                                        $x=1;
                                        while($row1 = mysqli_fetch_assoc($query1))
                                        {
                                    ?>
                                    <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name'].'-'.$row1['login_id']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="transfer" class="btn btn-primary" value="Transfer">
                            </td>
                        </tr>
                    </table>
			    </div>
			</form>
            <br>
                <p id="msg" style="text-align: center; padding-bottom: 10px;"><?php echo $msg; ?></p>
		</div>
	</div>
</div>

                <div id="none" style="margin-top: 30px; font-size: 26pt; color: #8f959a; font-family: Montserrat; height:150px;">
                    <center>Transfer Leads From One To Another Team Leader</center>
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

    <!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
    <script src="../assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

<script type="text/javascript">
$(function()
{
    setTimeout(function()
    {
        $("#msg").fadeOut(1500);
    }, 5000)
    $('#msg').click(function()
    {
        $('#msg').show();
        setTimeout(function()
        {
            $("#msg").fadeOut(1500);
        }, 5000)
    })
})

if (window.history.replaceState)
{
    window.history.replaceState(null, null, window.location.href);
}
</script>

</body>
</html>