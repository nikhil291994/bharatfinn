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


        if(function_exists('date_default_timezone_set')) {
            date_default_timezone_set("Asia/Kolkata");
        }

        $submit_date = date("d/m/Y");
        $submit_time =  date("H:i a");        

        $query=mysqli_query($con,"INSERT INTO leads(name, mobile, email, enquiry, status, submit_date, submit_time, assign_tele_id) VALUES ('".$name."','".$phone."','".$email."', '".$project."', '1' ,'".$submit_date."','".$submit_time."','".$row1Id['id']."')") OR die(mysqli_error());
        
        if($query>0)
        {
            $msg = "<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    <strong>Success!</strong> New Lead Added.
                </div>";
            
        }
        else{
            $msg = "<div class='alert alert-danger alert-mg-b'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                <strong>Error!</strong> New Lead Not Added.
                            </div>";
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
    header('location: viewleads.php');
}

elseif(isset($_POST['upload'])) 
{
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["files"]["name"]);
        $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        if($FileType != "xlsx" && $FileType != "xls") 
        {
            $msg = "<div class='alert alert-danger fade in'>Upload Only Excel File.</div>";
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
                die('Erroe Loading file"'.pathinfo($inputfilename,PATHINFO_BASENAME).'":'.$e->getMessage());
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            for($row = 1; $row < $highestRow; $row++)
            {
                $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,TRUE);
                if($rowData[1][0] != '' && $rowData[1][0] != '0' && $rowData[1][1] != '' && $rowData[1][1] != '0' && 
                    $rowData[1][2] != '' && $rowData[1][2] != '0' && $rowData[1][3] != '' && $rowData[1][3] != '0')
                {
                    if(function_exists('date_default_timezone_set')) {
                        date_default_timezone_set("Asia/Kolkata");
                    }

                    $submit_date = date("d/m/Y");
                    $submit_time =  date("H:i a");

                    echo $query = mysqli_query($con, "INSERT INTO leads(name, mobile, email, enquiry, status, submit_date, submit_time, assign_tele_id) VALUES ('".$rowData[0][0]."','".$rowData[0][1]."','".$rowData[0][2]."', '".$rowData[0][3]."', '1' ,'".$submit_date."','".$submit_time."','".$row1Id['id']."')")OR die(mysqli_error());
                    
                    if($query>0)
                    {
                        $msg = "<div class='alert alert-success'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                <strong>Success!</strong> File Uploded.
                            </div>";
                        
                    }
                    else{
                        $msg = "<div class='alert alert-danger alert-mg-b'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            <strong>Danger!</strong> Not Uploded.
                                        </div>";
                        }
                }
            }
        }
}

/*$id = $_GET['id'];
$sql = "DELETE FROM fb WHERE ID = $id"; 
mysqli_query($con, $sql);*/

$all = "SELECT * FROM users WHERE username = '".$_SESSION['username']."' ";
$run_all = mysqli_query($con, $all);
$show = mysqli_fetch_assoc($run_all);

$q_new_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE assign_tele_id = '".$show['id']."' AND status = 1 ");
$row_new_leads = mysqli_fetch_array($q_new_leads);

$q_hot_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE status = '2' AND assign_tele_id = '".$show['id']."' ");
$row_hot_leads = mysqli_fetch_array($q_hot_leads);

$q_done_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE status = '8' AND assign_tele_id = '".$show['id']."' ");
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

/*$dataPoints = array(    array("label"=> "Dead Leads", "y"=> $count_dead),
                        array("label"=> "Hot Leads", "y"=> $count_hot),
                        array("label"=> "Ongoing Leads", "y"=> $count_ongoing)
                    );*/
$pieData = array(
              array('Quarter', 'Number'),
              array('New Leads', (double)$count_new),
              array('Hot Leads', (double)$count_hot),
              array('Ongoing Leads', (double)$count_ongoing),
              array('Leads Done', (double)$count_done)
);

 $jsonTable = json_encode($pieData);

?>
<!DOCTYPE html>
<html lang="en">
<!-- index.html  11:55:53 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Telecaller | View Leads | Bharat Finn</title>
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
    <link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
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
                                            <li class="breadcrumb-item"><a href="index.php">Telecaller</a></li>
                                            <li class="breadcrumb-item active">View Leads</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">View Leads</h4></div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->                        
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <h4 class="mt-0 header-title">New Leads</h4> -->
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>                                                    
                                                    <th class="all">Sr. No.</th>
                                                     <th class="all">Unique ID</th>
                                                    <th class="all">Name</th>
                                                    <th class="all">Phone</th>
                                                    <th>Project/Location</th>
                                                    <th class="all">Status</th>
                                                    <th class="all">Remark</th>
                                                    <th>Next Call</th>
                                                    <th class="all">Action</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $x = 1;
                                                    $fetch = "SELECT * FROM leads WHERE assign_tele_id = '".$show['id']."' AND status IN ('1','4','5','6') ORDER BY id DESC";
                                                    $row = mysqli_query($con, $fetch);
                                                    while ($run = mysqli_fetch_array($row)) 
                                                    {
                                                ?>   
                                                <tr>
                                                    <td><?php echo $x++; ?></td>
                                                    <td><?php echo $run['id']; ?></td>
                                                    <td><?php echo $run['name']; ?></td>
                                                    <td><?php echo $run['mobile']; ?></td>
                                                    <td><?php echo $run['enquiry']; ?></td>
                                                    <td>
                                                     <?php 
                                                            if($run['status']==1)
                                                            { 
                                                                echo "<div class='btn btn-new-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>New</div>";
                                                            }
                                                            elseif ($run['status']==2) {
                                                                echo "<div class='btn btn-hot-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Hot</div>";
                                                            }
                                                            elseif ($run['status']==3) {
                                                                echo "<div class='btn btn-dead-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Dead</div>";
                                                            }
                                                            elseif ($run['status']==4) {
                                                                echo "<div class='btn btn-dnd-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>DND</div>";
                                                            }
                                                            elseif ($run['status']==5) {
                                                                echo "<div class='btn btn-followup-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Follow-Up</div>";
                                                            }
                                                            elseif ($run['status']==6) {
                                                                echo "<div class='btn btn-attempted-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Attempted</div>";
                                                            }
                                                            elseif ($run['status']==7) {
                                                                echo "<div class='btn btn-following-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Following</div>";
                                                            }
                                                            elseif ($run['status']==8) {
                                                                echo "<div class='btn btn-bookingdone-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Booking Done</div>";
                                                            }
                                                            elseif ($run['status']==9) {
                                                                echo "<div class='btn btn-sitevisitplanned-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Site Visit Planned</div>";
                                                            }
                                                            elseif ($run['status']==10) {
                                                                echo "<div class='btn btn-callbacktoday-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Call Back Today</div>";
                                                            }
                                                            elseif ($run['status']==11) {
                                                                echo "<div class='btn btn-sitevisitdone-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Site Visit Done</div>";
                                                            }
                                                        ?>                                                   
                                                    </td>
                                                    <td><?php echo $run["remark"]; ?></td>
                                                    <td><?php echo $run["next_call"]; ?></td>
                                                    <td>
                                                        <div class="col-sm-6 col-md-3">
                                                <div class="text-center">                                       
                                                    <!-- Small modal -->
                                              
                                                    <button type="button" id="<?php echo $run["id"]; ?>" class="btn btn-primary waves-effect waves-light change_data" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center" style='line-height: 16px;font-size: 12px;'><i class="fas fa-user-edit"></i> Change</button>
                                                
                                                </div><!-- /.modal-header -->
                                            </div>
                                                    </td>
                                                    <td><?php echo $run['email']; ?></td>
                                                </tr>
                                                <?php  }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Unique ID</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Project/Location</th>
                                                    <th>Status</th>
                                                    <th>Remark</th>
                                                    <th>Next Call</th>
                                                    <th>Action</th>
                                                    <th>Email</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
                                                <!-- /.modal -->
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
	<script src="../assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
	
    <!-- Datatable init js -->
    <script src="../assets/pages/datatables.init.js"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->

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
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
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
</script>

</body>
</html>