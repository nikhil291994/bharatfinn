<?php
require '../class/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

session_start();
error_reporting(0);
include('../class/config.php');

if (!isset($_SESSION['username'])) 
{
    header('location: ../index.php');
}

$selectId = "SELECT * FROM users WHERE username = '".$_SESSION['username']."' ";
$rowId = mysqli_query($con, $selectId);
$row1Id = mysqli_fetch_array($rowId);

$selectLead = "SELECT * FROM leads";
$rowselectLead = mysqli_query($con, $selectLead);
$rowselectLead1 = mysqli_fetch_assoc($rowselectLead);
    
if(isset($_POST['change'])) 
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

    $updateHot = "UPDATE leads SET hot_status_telecaller = '1' WHERE  id = '".$id."' ";
    mysqli_query($con, $updateHot);
}

$id = $_GET['id'];
$sqlDelete = "DELETE FROM leads WHERE id = $id"; 
mysqli_query($con, $sqlDelete);

$all = "SELECT * FROM users WHERE username = '".$_SESSION['username']."' ";
$run_all = mysqli_query($con, $all);
$show = mysqli_fetch_assoc($run_all);


$todaydate = date("d/m/Y");


        //Addtions for Ongoing Leads
        $q_ongoing_leads1 = mysqli_query($con, " SELECT COUNT(*) AS 'status1' FROM leads WHERE status = '1' AND assign_tele_id = '".$show['id']."' ");
        $row_ongoing_leads1 = mysqli_fetch_array($q_ongoing_leads1);

        $q_ongoing_leads3 = mysqli_query($con, " SELECT COUNT(*) AS 'status3' FROM leads WHERE status = '5' AND assign_tele_id = '".$show['id']."' ");
        $row_ongoing_leads3 = mysqli_fetch_array($q_ongoing_leads3);

        $q_ongoing_leads4 = mysqli_query($con, " SELECT COUNT(*) AS 'status4' FROM leads WHERE status = '6' AND assign_tele_id = '".$show['id']."' ");
        $row_ongoing_leads4 = mysqli_fetch_array($q_ongoing_leads4);

        $count_ongoing = $row_ongoing_leads1['status1'] + $row_ongoing_leads2['status2'] + $row_ongoing_leads3['status3'] + $row_ongoing_leads4['status4'];


$q_new_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE assign_tele_id = '".$show['id']."' AND status = 1 ");
$row_new_leads = mysqli_fetch_array($q_new_leads);

$q_rejected_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE status = '3' AND assign_tele_id = '".$show['id']."' ");
$row_rejected_leads = mysqli_fetch_array($q_rejected_leads);

$q_approved_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE status = '8' AND assign_tele_id = '".$show['id']."' ");
$row_approved_leads = mysqli_fetch_array($q_approved_leads);

$count_new = $row_new_leads['status'];
$count_rejected = $row_rejected_leads['status'];
$count_done = $row_approved_leads['status'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Sales Person | Dashboard | Bharat Finn</title>
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
                                            <li class="breadcrumb-item"><a href="index.php">Sales-Person</a></li>
                                            <li class="breadcrumb-item active">Shop List</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Shop List</h4></div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->
                        
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mt-0 header-title">All Shops</h4>
                                        <div class="table-rep-plugin">
                                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                                <table id="datatable-buttons" class="table table-striped mb-0">
                                                    <thead>
                                                        <tr> 
                                                            <th class="all">Sr. No.</th>
                                                            <th class="all">Shop ID</th>
                                                            <th class="all">Owner Name</th>
                                                            <th>Shop Name</th>
                                                            <!-- <th class="all">Shop Address</th> -->
                                                            <th>Phone</th>
                                                            <th>Email</th>
                                                            <!-- <th>PAN No.</th> -->
                                                            <!-- <th>Adhaar No.</th> -->
                                                            <th>Firm Type</th>
                                                            <th class="all">Status</th>
                                                            <th class="all">Created Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $x = 1;
                                                            $fetch = "SELECT * FROM shopdetails WHERE assign_tele_id = '".$show['id']."' ORDER BY shop_id  DESC";
                                                            
                                                            $row = mysqli_query($con, $fetch);
                                                            while ($run = mysqli_fetch_array($row)) 
                                                            {
                                                        ?>   
                                                        <tr>
                                                            <td><?php echo $x++; ?></td>
                                                            <td><?php echo $run['shop_id']; ?></td>
                                                            <td><?php echo $run['ownername']; ?></td>                
                                                            <td><?php echo $run['shopname']; ?></td>
                                                            <!-- <td><?php echo stripcslashes($run['shopaddress']); ?></td> -->
                                                            <td><?php echo $run['phone']; ?></td>
                                                            <td><?php echo $run['email']; ?></td>
                                                            <!-- <td><?php echo $run['pan_no']; ?></td>
                                                            <td><?php echo $run['addhar_no']; ?></td> -->
                                                            <td>
                                                                <?php 
                                                                    if($run['firm_type']==1)
                                                                    { 
                                                                        echo "Sole Proprietorship";
                                                                    }
                                                                    elseif ($run['firm_type']==2) {
                                                                        echo "Private Limited";
                                                                    }
                                                                    elseif ($run['firm_type']==3) {
                                                                        echo "Limited Liability Partnership";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    if($run['status']==1)
                                                                    { 
                                                                        echo "<div class='btn btn-new-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>New</div>";
                                                                    }
                                                                    elseif ($run['status']==3) {
                                                                        echo "<div class='btn btn-dnd-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Rejected</div>";
                                                                    }
                                                                    elseif ($run['status']==8) {
                                                                        echo "<div class='btn btn-bookingdone-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Approved</div>";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $run['submit_date'].'-'.$run['submit_time']; ?></td>
                                                            <td>
                                                                <button type="button" id="<?php echo $run["shop_id"]; ?>" class="btn btn-primary waves-effect waves-light viewData" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center" style='line-height: 16px;font-size: 12px;'><i class="fas fa-store"></i> View</button>
                                                            </td>
                                                        </tr>
                                                        <?php  }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Shop ID</th>
                                                            <th>Owner Name</th>
                                                            <th>Shop Name</th>
                                                            <!-- <th>Shop Address</th> -->
                                                            <th>Phone</th>
                                                            <th>Email</th>
                                                            <!-- <th>PAN No.</th>
                                                            <th>Adhaar No.</th> -->
                                                            <th>Firm Type</th>
                                                            <th>Status</th>
                                                            <th>Created Date</th>
                                                            <th>Action</th>
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

    <div class="modal fade bs-example-modal-center" id="PrimaryModalalert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Shop Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="change_detail">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
    <script src="../assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <script src=""></script>
    <!-- Datatable init js -->
    <script src="../assets/pages/datatables.init.js"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <!--    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->

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
/*$(document).ready(function() {
var table = $('.table').DataTable( {
    //responsive: true,
    // dom: 'lBfrtip',
   
        bStateSave: 'true'
       
} );
});*/

/*$('.table').DataTable({
        "bStateSave": true,
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem('offersDataTables', JSON.stringify(oData));
        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse(localStorage.getItem('offersDataTables'));
        }
    });*/
    
     

$(document).ready(function() 
{
   //responsive: true, 
  
    //bStateSave: 'true';
   /*$('.table').DataTable({
        "bStateSave": true,
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem('offersDataTables', JSON.stringify(oData));
        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse(localStorage.getItem('offersDataTables'));
        }
    });*/

    $('.table tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
    } );

    var table = $('.table').DataTable();
    //"bStateSave": true

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

$('table').on('click', '.viewData', function(){
      var id = $(this).attr("id");
      
      $.ajax({
           url:"ajax/viewShopDetails.php",
           method:"post",
           data:{id:id},
           success:function(data){
                $('#change_detail').html(data);
                $('#PrimaryModalalert').modal("show");
           }
      });
   });

/*if (window.history.replaceState) 
{
    window.history.replaceState(null, null, window.location.href);
}*/
</script>

</body>
</html>