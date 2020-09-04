<?php
require '../class/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

session_start();
//error_reporting(0);
include('../class/config.php');

if (!isset($_SESSION['username'])) 
{
    header('location: ../index.php');
}

$selectId = "SELECT * FROM users WHERE username = '".$_SESSION['username']."' ";
$rowId = mysqli_query($con, $selectId);
$row1Id = mysqli_fetch_array($rowId);

if(isset($_POST['submitData']))
{
    $ownername = mysqli_real_escape_string($con, $_POST['ownername']);
    $shopname = mysqli_real_escape_string($con, $_POST['shopname']);
    $shopaddress = mysqli_real_escape_string($con, $_POST['shopaddress']);
    $pan_no = mysqli_real_escape_string($con, $_POST['pan_no']);
    $firm_type = mysqli_real_escape_string($con, $_POST['firm_type']);
    $addhar_no = mysqli_real_escape_string($con, $_POST['addhar_no']);    
    $phone = mysqli_real_escape_string($con, $_POST['phone']);    
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $account_no = mysqli_real_escape_string($con, $_POST['account_no']);
    $ifsc_code = mysqli_real_escape_string($con, $_POST['ifsc_code']);
    $bank_name = mysqli_real_escape_string($con, $_POST['bank_name']);

    if(function_exists('date_default_timezone_set'))
    {
        date_default_timezone_set("Asia/Kolkata");
    }

    $submit_date = date("d/m/Y");
    $submit_time =  date("H:i a");

    $phoneCheck="SELECT * FROM leads WHERE mobile = '".$phone."' ";
    $phoners = mysqli_query($con,$phoneCheck);
    $phonedata = mysqli_fetch_array($phoners);

    if ($phonedata[0] > 1)
    {
        $msg = "<div class='alert bg-gradient1 text-white' role='alert'><strong>Error !</strong> Client Contact No already exist.</div>";
    }
    else
    {
        $query = mysqli_query($con,"INSERT INTO shopdetails(ownername, shopname, shopaddress, pan_no, firm_type, addhar_no, phone, email, account_no, ifsc_code, bank_name,  submit_date, submit_time, assign_tele_id, assign_tele_id_Org, assign_subadmin_id, assign_subadmin_id_Org, under_team_leader_id_Org, under_team_leader_id) VALUES ('".$ownername."','".$shopname."','".$shopaddress."', '".$pan_no."','".$firm_type."','".$addhar_no."','".$phone."','".$email."','".$account_no."', '".$ifsc_code."', '".$bank_name."','".$submit_date."','".$submit_time."','".$row1Id['id']."','".$row1Id['id']."','".$row1Id['under_sub_admin_id']."','".$row1Id['under_sub_admin_id']."','".$row1Id['under_team_leader']."','".$row1Id['under_team_leader']."')") OR die(mysqli_error());

        if($query>0)
        {
            $msg = "<div class='alert bg-gradient2 text-white' role='alert'><strong>Well done!</strong> New Shop Added.</div>";
        }
        else
        {
            $msg = "<div class='alert bg-gradient1 text-white' role='alert'><strong>Error!</strong> New Shop Not Added.</div>";
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
    <title>Team Leader | Add New Shop | Bharat Finn</title>
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
    <link href="../assets/plugins/dropify/css/dropify.min.css" rel="stylesheet">
    <link href="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    
</head>
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
                                            <li class="breadcrumb-item"><a href="index.php">Team Leader</a></li>
                                            <li class="breadcrumb-item active">Add New Shop</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add New Shop</h4></div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->
                        
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <span id="msg"><h7><?php echo $msg; ?></h7></span>
                                        <form method="POST">                                            
                                            <div class="form-group">
                                                <label>Owner Name</label>
                                                <div>
                                                    <input type="text" name="ownername" class="form-control" required placeholder="Enter Owner Name">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Shop Name</label>
                                                <div>
                                                    <input type="text" name="shopname" class="form-control" required placeholder="Enter Shop Name">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Shop Address</label>
                                                <div>
                                                    <textarea name="shopaddress" class="form-control" required placeholder="Enter Shop Address"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Business/Owner PAN No.</label>
                                                <div>
                                                    <input type="text" name="pan_no" class="form-control" required placeholder="Enter PAN Number">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Firm Type</label>
                                                <div>
                                                    <select name="firm_type" class="form-control" required>
                                                        <option value="">Select Firm Type</option>
                                                        <option value="1">Sole Proprietorship</option>
                                                        <option value="2">Private Limited</option>
                                                        <option value="3">Limited Liability Partnership</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Adhaar No.</label>
                                                <div>
                                                    <input type="text" name="addhar_no" class="form-control" required placeholder="Enter Addhar Number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label>Contact No.</label>
                                                <div>
                                                    <input type="text" name="phone" maxlength="12" minlength="10" class="form-control digit" required placeholder="Enter Contact Number">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>E-Mail</label>
                                                <div>
                                                    <input type="email" name="email" class="form-control" parsley-type="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" placeholder="Enter valid e-mail" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Account No.</label>
                                                <div>
                                                    <input type="text" name="account_no" class="form-control" required placeholder="Enter Account Number">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>IFSC Code</label>
                                                <div>
                                                    <input type="text" name="ifsc_code" class="form-control" required placeholder="Enter IFSC Code">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Bank Name</label>
                                                <div>
                                                    <input type="text" name="bank_name" class="form-control" required placeholder="Enter Bank Name">
                                                </div>
                                            </div>

                                            <div class="form-group mb-0">
                                                <div>
                                                    <button type="submit" name="submitData" class="btn btn-primary waves-effect waves-light">Submit</button>
                                                    <button type="reset" class="btn btn-delete waves-effect m-l-5">Clear</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
    <script src="../assets/plugins/dropify/js/dropify.min.js"></script>
    <script src="../assets/pages/dropify.init.js"></script>
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
    <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
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
           url:"ajax/updateView.php",
           method:"post",
           data:{id:id},
           success:function(data){
                $('#change_detail').html(data);
                $('#PrimaryModalalert').modal("show");
           }
      });
   });

$('.digit').keyup(function() {
var val = $(this).val();
if (isNaN(val)) {
    val = val.replace(/[^0-9]/g, '');
    if (val.split('.').length > 2)
        val = val.replace(/\.+$/, "");
}
$(this).val(val);
});

$(function() 
    {
    setTimeout(function() { $("#msg").fadeOut(1500); }, 5000)
    $('#msg').click(function() {
    $('#msg').show();
    setTimeout(function() { $("#msg").fadeOut(1500); }, 5000)
    });
    });

if (window.history.replaceState) 
{
    window.history.replaceState(null, null, window.location.href);
}
</script>

</body>
</html>