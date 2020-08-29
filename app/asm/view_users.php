<?php
session_start();
error_reporting(0);
include('../class/config.php');


if (!isset($_SESSION['email'])) 
{
    header('location: ../index.php');
}

if (isset($_POST['disable'])) 
{
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $update = "UPDATE users SET active_status = '".$status."' WHERE id ='".$id."' ";
    mysqli_query($con, $update);
    header('location: view_users.php?position_id='.$_GET['position_id'].' ');
}
elseif(isset($_POST['enable'])) 
{
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $update = "UPDATE users SET active_status = '".$status."' WHERE id ='".$id."' ";
    mysqli_query($con, $update);
    header('location: view_users.php?position_id='.$_GET['position_id'].' ');
}
elseif(isset($_POST['set_pass'])) 
{
    $FROM = 0; $TO = 'zzzz';
    $code1 = base_convert(rand( $FROM ,base_convert( $TO , 36,10)),10,36);
    $code2 = strtoupper($code1);
    $code = $code2;
    $enCode = md5($code2);

    $id = mysqli_real_escape_string($con, $_POST['id']);
    $login_id = mysqli_real_escape_string($con, $_POST['login_id']);

    $select = "SELECT * FROM users WHERE login_id ='".$login_id."' ";
    $rowSelect = mysqli_query($con, $select);
    $runSelect = mysqli_fetch_assoc($rowSelect);
    $email = $runSelect['email'];

    $header = "From: Bharat Finn\r\n";
    $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $header .= "Reply-To: contact@bharatfinn.in\r\n";
    $message = "Hi ".$runSelect['name'].",<br><br>";
    $message .= "You requested for New Password. Your New Password is <b>".$code."</b><br>";
    $message .= "<br>-Akshay_CRM";
    $subject = "Bharat Finn Password Change Request";
    $message = wordwrap($message, 200);

    $update = "UPDATE users SET password = '".$enCode."', or_pass = '".$code."' WHERE id ='".$id."' AND login_id = '".$login_id."' ";
    mysqli_query($con, $update);

     if(mail($email, $subject, $message, $header) )
      {
         $msg = "<div class='alert bg-gradient2 text-white' role='alert'><strong></strong> Password sent on registered Email ID</div>";
      }
      else
      {
         $msg = "<span class='alert bg-gradient1 text-white' role='alert'>Password not sent.</span>";
      }
}  

?>

<?php 
if(isset($_POST['change'])) 
{

$id = mysqli_real_escape_string($con, $_POST['id']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);

$update = "UPDATE users SET name = '".$name."',email = '".$email."', contact = '".$phone."'  WHERE id = '".$id."' ";
mysqli_query($con, $update);

header('location: view_users.php?position_id='.$_GET['position_id'].' ');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>ASM | View Users | Bharat Finn</title>
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
    <link href="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
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
                                            <li class="breadcrumb-item"><a href="index.php">Area Sales Manager</a></li>
                                            <li class="breadcrumb-item active">List of Members</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">List Of Members</h4></div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->                        
<div class="col-md-6 row">
    <div class="card">
        <div class="card-body">
            <form method="GET">
                <div class="col-md-12">
                    <table align="center" class="" style="table-layout: fixed;">
                        <tr>
                        <td>
                            <select name="position_id" class="form-control" required>
                                <option value="">Select any one</option>                           
                                <!-- <option value="2">Telecaller</option> -->
                                <!-- <option value="2">Sales Person</option> -->
                                <option value="3">Team Leader</option>
                            </select>
                        </td>
                        <td>

                            <input type="submit" name="search" class="btn btn-primary" value="Search">

                            <?php 
                                $sql2=" SELECT * FROM users WHERE position = '".$_GET['position_id']."' ";
                                $query2=mysqli_query($con,$sql2);
                                $run2=mysqli_fetch_assoc($query2);
                            ?>
                            </td></tr>
                            <tr style="text-align:center;"><td>
                                <h4>
                                    <?php
                                        if ($run2['position'] == 3) 
                                        {
                                            echo 'Team Leader';
                                        }
                                        elseif ($run2['position'] == 2) 
                                        {
                                            echo 'Sales Person';
                                        }  
                                    ?>                                 
                             </h4></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if($_GET['user_id'] =='' && $_GET['user_id'])
{?>
<div id="none" style="margin-top: 50px; font-size: 36pt; color: #8f959a; font-family: Montserrat;display:none;">
    <center>Please Select Users</center>
</div>
<?php  }
?>

<?php if($_GET['position_id'] !='' && $_GET['position_id'])
{?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">     
                                    <h7><?php echo $msg; ?></h7>                                
                                        <!-- <h4 class="mt-0 header-title">New Leads</h4> -->
                                        <div class="table-rep-plugin">
                                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="all">Sr. No.</th>
                                                             <th class="all">Sharable User ID</th>
                                                            <th class="all">Username</th>
                                                            <th class="all">Name</th>
                                                            <th class="all">Contact No.</th>
                                                            <th>Email</th>
                                                            <th>User Since</th>
                                                            <th class="all">Status</th>
                                                            <!-- <th>Change Password</th> -->
                                                            <!-- <th>Action</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $x = 1;
                                                            $fetch = "SELECT * FROM users WHERE position = '".$_GET['position_id']."' AND under_sub_admin_id = '".$_SESSION['subadmin_id']."' ORDER BY id DESC";
                                                            $row = mysqli_query($con, $fetch);
                                                            while ($run = mysqli_fetch_array($row)) 
                                                            {
                                                        ?>   
                                                        <tr>
                                                            <td><?php echo $x++; ?></td>
                                                             <td><?php echo $run['login_id']; ?></td>
                                                            <td><?php echo $run['username']; ?></td>
                                                            <td><?php echo $run['name']; ?></td>
                                                            <td><?php echo $run['contact']; ?></td>
                                                            <td><?php echo $run['email']; ?></td>
                                                            <td><?php echo $run['member_since']; ?></td>
                                                            <!-- <td>
                                                                <?php 
                                                                if($run['active_status'] == 1)
                                                                { 
                                                                    echo "<div class='btn' style='color:#fff;background: linear-gradient(#95d8ff, #002cc7);width:100%;font-weight:700;'>Active</div>";
                                                                }
                                                                elseif ($run['active_status']==0) {
                                                                    echo "<div class='btn' style='color:#fff;background: linear-gradient(#f3d338, #dc6723);width:100%;font-weight:700;'>In-active</div>";
                                                                }
                                                                ?>                            
                                                            </td> -->
                                                            <td>
                                                                <?php if ($run['active_status']=='0') { ?>
                                                                        <form method="POST">
                                                                            <input type="hidden" name="status" value="1">
                                                                            <input type="hidden" value="<?php echo $run['id'] ?>" name="id">
                                                                            <button type="submit" name="enable" style="color: red; border: none; padding: 0; background: none; font-size: 14px; margin: auto;">
                                                                                <div class='btn btn-dnd-info' style='color:#fff;width:100%;padding: 4px 10px;'>In-active</div>
                                                                            </button> 
                                                                        </form>
                                                                <?php } else { ?>
                                                                   <form method="POST">
                                                                            <input type="hidden" name="status" value="0">
                                                                            <input type="hidden" name="id" value="<?php echo $run['id'] ?>">
                                                                            <button type="submit" title="Click to In-activate" name="disable" value="Enable" style="color: red; border: none; padding: 0; background: none; font-size: 14px; margin: auto;">
                                                                                <div class='btn btn-bookingdone-info' style='color:#fff;width:100%; padding: 2px 5px;'>Active</div>
                                                                            </button>
                                                                            <button type="button" id="<?php echo $run["id"]; ?>" class="btn btn-primary waves-effect waves-light change_data" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center" style='line-height: 16px;font-size: 12px;'><i class="fas fa-user-edit"></i> </button>

                    <div class="modal fade bs-example-modal-center" id="PrimaryModalalert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" id="change_detail">
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
            </div>
                                                                        </form>
                                                                <?php } ?>
                                                            </td>
                                                            <!-- <td>
                                                                <form method="POST">
                                                                    <input type="hidden" name="id" value="<?php echo $run['id'] ?>">
                                                                    <input type="hidden" name="login_id" value="<?php echo $run['login_id'] ?>">
                                                                    <button type="submit" name="set_pass" class="btn btn-primary">Click To Update Password</button>
                                                                </form>
                                                            </td> -->


                                                        </tr>
                                                        <?php  }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Unique ID</th>
                                                            <th>Username</th>
                                                            <th>Name</th>
                                                            <th>Contact No.</th>
                                                            <th>Email</th>
                                                            <th>User Since</th>
                                                            <th>Status</th>
                                                            <!-- <th>Change Password</th> -->
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                    <?php }
                    else{  ?>
                        <div id="none" style="margin-top: 50px; font-size: 36pt; color: #8f959a; font-family: Montserrat;height:150px;">
                        <center>Please Select Users</center>
                        </div>
                  <?php  } ?>
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
   <script src="../assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

<script type="text/javascript">
/*window.onload = function () 
{ 
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        exportEnabled: true,        
        data: [{
            type: "pie",        
            indexLabelFontSize: 16,
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render(); 
}*/

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
  function drawChart() 
  {
    var data = google.visualization.arrayToDataTable(<?php  echo $jsonTable; ?>);
    var options = {
                    is3D: true,
                    };
    var chart = new google.visualization.PieChart(document.getElementById("piechart"));
    chart.draw(data, options);
  }
</script>
<script type="text/javascript">
$(document).ready(function() 
{
    $('.table tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );

    var table = $('.table').DataTable();

    table.columns().every( function () {
        var that = this;
         
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
});

$('table').on('click', '.change_data', function(){
      var id = $(this).attr("id");
      //alert(id);
      $.ajax({
           url:"ajax/updateUsers.php",
           method:"post",
           data:{id:id},
           success:function(data){
                $('#change_detail').html(data);
                $('#PrimaryModalalert').modal("show");
           }
      });
   });

if (window.history.replaceState) 
{
    window.history.replaceState(null, null, window.location.href);
}
</script>

</body>
</html>