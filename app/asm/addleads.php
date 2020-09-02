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
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $project = mysqli_real_escape_string($con, $_POST['project']);
        $id_proof = 'NULL'/*mysqli_real_escape_string($con, $_POST['id_proof'])*/;
        $pan_no = mysqli_real_escape_string($con, $_POST['pan_no']);
        $addhar_no = mysqli_real_escape_string($con, $_POST['addhar_no']);
        $loan_amount = mysqli_real_escape_string($con, $_POST['loan_amount']);
        $income_source = mysqli_real_escape_string($con, $_POST['income_source']);

        if(function_exists('date_default_timezone_set')) {
            date_default_timezone_set("Asia/Kolkata");
        }

        $submit_date = date("d/m/Y");
        $submit_time =  date("H:i a"); 

        $phoneCheck="SELECT * FROM leads WHERE mobile = '".$phone."' ";
        $phoners = mysqli_query($con,$phoneCheck);
        $phonedata = mysqli_fetch_array($phoners);

       /* $emailCheck="SELECT * FROM leads WHERE email = '".$email."' ";
        $emailrs = mysqli_query($con,$emailCheck);
        $emaildata = mysqli_fetch_array($emailrs);*/

        /* if ($emaildata[0] > 1) {
            $msg = "<div class='alert bg-gradient1 text-white' role='alert'><strong>Error !</strong> Client Email ID already exist.</div>";
        }
        else */
        if ($phonedata[0] > 1) {
            $msg = "<div class='alert bg-gradient1 text-white' role='alert'><strong>Error !</strong> Client Contact No already exist.</div>";
        }
        else
        {
            $query = mysqli_query($con,"INSERT INTO leads(name, mobile, email, enquiry, id_proof, pan_no, addhar_no, loan_amount, income_source, status, login_status,  submit_date, submit_time, assign_tele_id, assign_tele_id_Org, assign_subadmin_id ,assign_subadmin_id_Org) VALUES ('".$name."','".$phone."','".$email."', '".$project."','".$id_proof."','".$pan_no."','".$addhar_no."','".$loan_amount."','".$income_source."', '1' , '1' ,'".$submit_date."','".$submit_time."','".$row1Id['id']."','".$row1Id['id']."','".$row1Id['under_sub_admin_id']."','".$row1Id['under_sub_admin_id']."')") OR die(mysqli_error());
        
            if($query>0)
            {
                $msg = "<div class='alert bg-gradient2 text-white' role='alert'><strong>Well done!</strong> New Lead Added.</div>";
                
            }
            else{
                $msg = "<div class='alert bg-gradient1 text-white' role='alert'><strong>Error!</strong> New Lead Not Added.</div>";
            }
        }      

        
    }
elseif(isset($_POST['change'])) 
{
$id = mysqli_real_escape_string($con, $_POST['id']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$project = mysqli_real_escape_string($con, $_POST['project']);
$next_call = mysqli_real_escape_string($con, $_POST['next_call']);
$status = mysqli_real_escape_string($con, $_POST['status']);
$remark = mysqli_real_escape_string($con, $_POST['remark']);

    $update = "UPDATE leads SET name = '".$name."', email = '".$email."', mobile = '".$phone."', enquiry = '".$project."',next_call = '".$next_call."',status = '".$status."', remark = '".$remark."' WHERE id = '".$id."' ";
    mysqli_query($con, $update);
    header('location: addleads.php');
}

elseif(isset($_POST['upload'])) 
{
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["files"]["name"]);
        $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        if($FileType != "xlsx" && $FileType != "xls") 
        {
            $msgFile = "<div class='alert bg-gradient1 text-white' role='alert'><strong>Error !</strong> Upload only Excel file.</div>";
        }
        else
        {
            $inputfilename = $_FILES['files']['tmp_name'];
            $exceldata = array();

            try{
                $inputfiletype = PHPExcel_IOFactory::identify($inputfilename);
                $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
                $objPHPExcel = $objReader->load($inputfilename);
            }
            catch(Exception $e)
            {
                die('Error Loading file"'.pathinfo($inputfilename,PATHINFO_BASENAME).'":'.$e->getMessage());
            }

            $allDataInSheet = $objPHPExcel-> getActiveSheet()-> toArray(null, true, true, true);
            $arrayCount = count($allDataInSheet); // Here get total count of row in that Excel sheet
                        
            if(strtolower($allDataInSheet[1]['A']) =='name' && strtolower($allDataInSheet[1]['B']) =='mobile no.' && strtolower($allDataInSheet[1]['C']) =='email id' && strtolower($allDataInSheet[1]['D']) =='project/location')
            {
                $inserted_rows = 0;
            
                for ($i = 2; $i <= $arrayCount; $i++) {
                    $name = trim($allDataInSheet[$i]["A"]);
                    $mobile = trim($allDataInSheet[$i]["B"]);
                    $email = trim($allDataInSheet[$i]["C"]);
                    $enquiry = trim($allDataInSheet[$i]["D"]);
                    $submit_date = date("d/m/Y");
                    $submit_time =  date("H:i a");
                    
                    if(function_exists('date_default_timezone_set')) {
                        date_default_timezone_set("Asia/Kolkata");
                    }
                    
                    if(!empty($name) && !empty($mobile)){
                        $query = mysqli_query($con, "INSERT INTO leads(name, mobile, email, enquiry, status, submit_date, submit_time, assign_tele_id) VALUES ('".$name."','".$mobile."','".$email."', '".$enquiry."', '1' ,'".$submit_date."','".$submit_time."','".$row1Id['id']."')") OR die(mysqli_error()) OR die(mysqli_error());
                        if($query>0)
                        {
                            $inserted_rows++;
                            /* $msgFile = "<div class='alert bg-gradient2 text-white' role='alert'><strong>Well done!</strong> Excel file uploded successfully.</div>"; */
                            
                        }
                    }
                    
                }
                
                if($inserted_rows > 0){
                    $msgFile = "<div class='alert bg-gradient2 text-white alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button> <strong>Well done!</strong> Excel file with ".$inserted_rows." rows uploded successfully.</div>";
                }else{
                    $msgFile = "<div class='alert bg-gradient1 text-white alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button> <strong>Error !</strong> Excel file not uploded.</div>";
                }
                
            }else{
                $msgFile = "<div class='alert bg-gradient1 text-white alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button> <strong>Template Error !</strong> Kindly use Excel template same as provided.</div>";
            }
        }
    }

$all = "SELECT * FROM users WHERE username = '".$_SESSION['username']."' ";
$run_all = mysqli_query($con, $all);
$show = mysqli_fetch_assoc($run_all);

$q_new_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE assign_tele_id = '".$show['id']."' AND status = 1 ");
$row_new_leads = mysqli_fetch_array($q_new_leads);

$q_hot_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE status = '2' AND assign_tele_id = '".$show['id']."' ");
$row_hot_leads = mysqli_fetch_array($q_hot_leads);

$q_done_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE status = '7' AND assign_tele_id = '".$show['id']."' ");
$row_done_leads = mysqli_fetch_array($q_done_leads);

        //Addtions for Ongoing Leads
        $q_ongoing_leads1 = mysqli_query($con, " SELECT COUNT(*) AS 'status1' FROM leads WHERE status = '1' AND assign_tele_id = '".$show['id']."' ");
        $row_ongoing_leads1 = mysqli_fetch_array($q_ongoing_leads1);

        $q_ongoing_leads2 = mysqli_query($con, " SELECT COUNT(*) AS 'status2' FROM leads WHERE status = '2' AND assign_tele_id = '".$show['id']."' ");
        $row_ongoing_leads2 = mysqli_fetch_array($q_ongoing_leads2);

        $q_ongoing_leads3 = mysqli_query($con, " SELECT COUNT(*) AS 'status3' FROM leads WHERE status = '5' AND assign_tele_id = '".$show['id']."' ");
        $row_ongoing_leads3 = mysqli_fetch_array($q_ongoing_leads3);

        $q_ongoing_leads4 = mysqli_query($con, " SELECT COUNT(*) AS 'status4' FROM leads WHERE status = '6' AND assign_tele_id = '".$show['id']."' ");
        $row_ongoing_leads4 = mysqli_fetch_array($q_ongoing_leads4);

        $count_ongoing = $row_ongoing_leads1['status1'] + $row_ongoing_leads2['status2'] + $row_ongoing_leads3['status3'] + $row_ongoing_leads4['status4'];

$count_new = $row_new_leads['status'];
$count_dead = $row_dead_leads['status'];
$count_hot = $row_hot_leads['status'];
$count_done = $row_done_leads['status'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>ASM | Add Leads | Bharat Finn</title>
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
                                            <li class="breadcrumb-item active">Add New Leads</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add New Leads</h4></div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->
                        
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body" style="height:468px;">
                                        <span id="msg"><h7><?php echo $msg; ?></h7></span>
                                        <form method="POST" >                                            
                                            <div class="form-group">
                                                <label>Name</label>
                                                <div>
                                                    <input type="text" name="name" class="form-control" required placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Contact No.</label>
                                                <div>
                                                    <input type="text" name="phone" maxlength="12" minlength="10" class="form-control digit" required placeholder="Enter Contact Number">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>E-Mail</label>
                                                <div>
                                                    <input type="email" name="email" class="form-control" parsley-type="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" placeholder="Enter valid e-mail">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>PAN Card No.</label>
                                                <div>
                                                    <input type="text" name="pan_no" class="form-control" required placeholder="Enter PAN No.">
                                                </div>
                                            </div>
                                                                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body" style="height: 468px;">
                                        <div class="form-group">
                                            <label>Addhar No.</label>
                                            <div>
                                                <input type="text" name="addhar_no" class="form-control" required placeholder="Enter Addhar No.">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Loan Type</label>
                                            <div>
                                                <input name="project" type="text" class="form-control"  placeholder="Enter Loan Type">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Loan Amount</label>
                                            <div>
                                                <input type="text" name="loan_amount" class="form-control digit" required placeholder="Enter Loan Amount">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Income Source</label>
                                            <div>
                                                <input type="text" name="income_source" class="form-control" required placeholder="Enter Income Source">
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