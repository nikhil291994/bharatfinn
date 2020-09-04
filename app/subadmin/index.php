<?php
require '../class/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

session_start();
error_reporting(0);
include('../class/config.php');

if (!isset($_SESSION['email'])) 
{
    header('location: ../index.php');
}
    
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

        $query=mysqli_query($con,"INSERT INTO leads(name, mobile, email, enquiry, status, submit_date, submit_time) VALUES ('".$name."','".$phone."','".$email."', '".$project."', '1' ,'".$submit_date."','".$submit_time."')")OR die(mysqli_error());
        
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
                                <strong>Danger!</strong> New Lead Not Added.
                            </div>";
            }
    }
elseif(isset($_POST['change'])) 
{
$id = mysqli_real_escape_string($con, $_POST['id']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$status = mysqli_real_escape_string($con, $_POST['status']);
$login_status = mysqli_real_escape_string($con, $_POST['login_status']);
$remark = mysqli_real_escape_string($con, $_POST['remark']);

$update1 = "UPDATE leads SET name = '".$name."', email = '".$email."', mobile = '".$phone."', status = '".$status."', login_status = '".$login_status."', remark = '".$remark."' WHERE id = '".$id."' ";
mysqli_query($con, $update1);

$update = "UPDATE leads SET hot_status_admin = '1' WHERE  id = '".$id."' ";
mysqli_query($con, $update);

header('location: index.php');
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

            for($row = 1; $row <= $highestRow; $row++)
            {
                $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,TRUE);
                if($rowData[0][0] != '' && $rowData[0][0] != '0' && $rowData[0][1] != '' && $rowData[0][1] != '0' && $rowData[0][2] != '' && $rowData[0][2] != '0' && $rowData[0][3] != '' && $rowData[0][3] != '0')
                {
                    if(function_exists('date_default_timezone_set')) {
                        date_default_timezone_set("Asia/Kolkata");
                    }

                    $submit_date = date("d/m/Y");
                    $submit_time =  date("H:i a");

                    echo $query=mysqli_query($con, "INSERT INTO leads(name, mobile, email, enquiry, status, submit_date, submit_time) VALUES ('".$rowData[0][0]."','".$rowData[0][1]."','".$rowData[0][2]."', '".$rowData[0][3]."', '1' ,'".$submit_date."','".$submit_time."')")OR die(mysqli_error());
                    
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

$q_new_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE (assign_subadmin_id = '".$_SESSION['subadmin_id']."' OR assign_tele_id = '".$_SESSION['subadmin_id']."') AND status = '1' ");
$row_new_leads = mysqli_fetch_array($q_new_leads);

$q_rejected_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE (assign_subadmin_id = '".$_SESSION['subadmin_id']."' OR assign_tele_id = '".$_SESSION['subadmin_id']."') AND status = '3' ");
$row_rejected_leads = mysqli_fetch_array($q_rejected_leads);

$q_done_leads = mysqli_query($con, " SELECT COUNT(*) AS 'status' FROM leads WHERE (assign_subadmin_id = '".$_SESSION['subadmin_id']."' OR assign_tele_id = '".$_SESSION['subadmin_id']."') AND status = '8' ");
$row_done_leads = mysqli_fetch_array($q_done_leads);

$count_new = $row_new_leads['status'];
$count_rejected = $row_rejected_leads['status'];
$count_done = $row_done_leads['status'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Team Leader | Dashboard | Bharat Finn</title>
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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4></div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body justify-content-center">
                                                <div class="icon-contain">
                                                    <div class="row">
                                                        <div class="col-2 align-self-center"><i class="fa fa-file-signature text-gradient-new"></i></div>
                                                        <div class="col-10 text-right">
                                                            <h5 class="mt-0 mb-1"><?php echo $count_new; ?></h5>
                                                            <p class="mb-0 font-12 text-muted">New Leads</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="icon-contain">
                                                    <div class="row">
                                                        <div class="col-2 align-self-center"><i class="fa fa-fire text-gradient-hot"></i></div>
                                                        <div class="col-10 text-right">
                                                            <h5 class="mt-0 mb-1"><?php echo $count_rejected; ?></h5>
                                                            <p class="mb-0 font-12 text-muted">Rejected Leads</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="icon-contain">
                                                    <div class="row">
                                                        <div class="col-2 align-self-center"><i class="fas fa-check-circle text-gradient-successful"></i></div>
                                                        <div class="col-10 text-right">
                                                            <h5 class="mt-0 mb-1"><?php echo $count_done; ?></h5>
                                                            <p class="mb-0 font-12 text-muted">Approved Leads</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mt-0 header-title">All Leads</h4>
                                        <div class="table-rep-plugin">
                                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                                <table id="datatable-buttons" class="table eg table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    
                                                    <thead>
                                                        <tr>
                                                            <th class="all">Sr No.</th>
                                                            <th class="all">Name</th>
                                                            <th>Phone</th>
                                                            <th>Remark</th>
                                                            <th class="all">Login Status</th>
                                                            <th class="all">Loan Status</th>
                                                            <th>Email</th>
                                                            <th>PAN No.</th>
                                                            <th>Addhar No.</th>
                                                            <th class="all">Loan Type</th>
                                                            <th class="all">Loan Amount</th>
                                                            <th class="all">Income Source</th>
                                                            <!-- <th class="all">Change</th> -->
                                                            <th>Created Date</th>
                                                            <th>Added By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $x = 1;
                                                            $fetch = "SELECT * FROM leads WHERE assign_subadmin_id = '".$_SESSION['subadmin_id']."' OR assign_tele_id = '".$_SESSION['subadmin_id']."' ORDER BY id DESC";
                                                            $row = mysqli_query($con, $fetch);
                                                            while ($run = mysqli_fetch_array($row)) 
                                                            {
                                                        ?>   
                                                        <tr>
                                                            <td><?php echo $x++; ?></td>
                                                            <td><?php echo wordwrap($run['name'],10,"<br>\n",TRUE); ?></td>
                                                            <td><?php echo $run['mobile']; ?></td>
                                                            <td><?php echo $run['remark']; ?></td>
                                                            <td>
                                                                <?php 
                                                                    if($run['status']==1)
                                                                    { 
                                                                        echo "<div class='btn btn-new-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>New</div>";
                                                                    }
                                                                    elseif ($run['status']==3)
                                                                    {
                                                                        echo "<div class='btn btn-dnd-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Rejected</div>";
                                                                    }
                                                                    elseif ($run['status']==8)
                                                                    {
                                                                        echo "<div class='btn btn-bookingdone-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Approved</div>";
                                                                    }
                                                                ?>                                                       
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    if($run['login_status']==1)
                                                                    { 
                                                                        echo "<div class='btn btn-new-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Pending</div>";
                                                                    }
                                                                    elseif ($run['login_status']==2)
                                                                    {
                                                                        echo "<div class='btn btn-bookingdone-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Approved</div>";
                                                                    }
                                                                    elseif ($run['login_status']==3)
                                                                    {
                                                                        echo "<div class='btn btn-dnd-info waves-effect waves-light' style='line-height: 16px;font-size: 12px;'>Rejected</div>";
                                                                    }
                                                                ?>                                                       
                                                            </td>                                                    
        													<td><?php echo $run['email']; ?></td>
                                                            <td><?php echo $run['pan_no']; ?></td>
                                                            <td><?php echo $run['addhar_no']; ?></td>
                                                            <td><?php echo $run['enquiry']; ?></td>
                                                            <td><?php echo $run['loan_amount']; ?></td>
                                                            <td><?php echo wordwrap($run['income_source'],10,"<br>\n",TRUE); ?></td>
                                                            <td><?php echo $run['submit_date'].'-'.$run['submit_time']; ?></td>
                                                            <td><?php 
                                                                    $selectId = "SELECT login_id, position, email FROM users WHERE id = '".$run['assign_tele_id']."' ";
                                                                    $rowId = mysqli_query($con, $selectId);
                                                                    $row1Id = mysqli_fetch_array($rowId);
                                                                    echo $row1Id['login_id'];

                                                                    if ($_SESSION['email'] == $row1Id['email'])
                                                                    {
                                                                        echo " (Self)";
                                                                    }
                                                                    else if ($row1Id['position'] == '1')
                                                                    {
                                                                        echo " (Super Admin)";
                                                                    }
                                                                    else if ($row1Id['position'] == '2')
                                                                    {
                                                                        echo " (Sales Person)";
                                                                    }
                                                                    else if ($row1Id['position'] == '3')
                                                                    {
                                                                        echo " (Team Leader)";
                                                                    }
                                                                    else if ($row1Id['position'] == '4')
                                                                    {
                                                                        echo " (Client)";
                                                                    }
                                                                    else if ($row1Id['position'] == '5')
                                                                    {
                                                                        echo " (ASM)";
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php  }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>search Sr. No.</th>
                                                            <th>search Name</th>
                                                            <th>search Phone</th>
                                                            <th>Remark</th>
                                                            <th>Login Status</th>
                                                            <th>Loan Status</th>
                                                            <th>Email</th>
                                                            <th>PAN No.</th>
                                                            <th>Addhar No.</th>
                                                            <th>Loan Type</th>
                                                            <th>Loan Amount</th>
                                                            <th>Income Source</th>
                                                            <!-- <th></th> -->
                                                            <th>Created Date</th>
                                                            <th>Search Added By</th>
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
    <!-- END wrapper -->

    <div class="modal fade bs-example-modal-center"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
    <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
    <script src="../assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

<script type="text/javascript">

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
        $(this).html( '<input type="text" class="form-control" placeholder=" '+title+'" />' );
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
           url:"ajax/updateHot.php",
           method:"post",
           data:{id:id},
           success:function(data){
                $('#change_detail').html(data);
                $('#PrimaryModalalert').modal("show");
                 window.setTimeout(table, 10000);
                 $('table').load(page);
           }
      
      });
   });

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

/*if (window.history.replaceState) 
{
    window.history.replaceState(null, null, window.location.href);
}*/
</script>

<script>
  
  $(document).ready(function(){
      $('#checkAll').click(function(){
         if(this.checked){
             $('.checkbox').each(function(){
                this.checked = true;
             });   
         }else{
            $('.checkbox').each(function(){
                this.checked = false;
             });
         } 
      });


    $('#delete').click(function(){
       if($('input:checkbox:checked').length > 0){
		   var x = confirm("Are you sure you want to Delete the selected lead(s)?");
			if (x==true)
			{
				$.ajax({
					type:"POST",
					data:$('.leads:checked').serialize(),
					url:"function.php",
					success: function(response){
						if(response==1){
							alert('Lead(s) deleted successfully');
							location.reload();
						}else{
							alert('Something went wrong. Try again');
						}
					}
				
				});
				
			}
			else
			{
				return false;
			}
			
       }else{
         alert('No Lead(s) selected');
       }

    });  

  });
</script>

<!--<script>
  
  $(document).ready(function(){
      $('#checkAll').click(function(){
         if(this.checked){
             $('.checkbox').each(function(){
                this.checked = true;
             });   
         }else{
            $('.checkbox').each(function(){
                this.checked = false;
             });
         } 
      });


    $('#select').on('click', '.select', function(){
      var id = $(this).attr("id");
      //alert(id);
      $.ajax({
           url:"ajax/selectAll.php",
           method:"post",
           data:{id:id},
           success:function(data){
                $('#change').html(data);
                $('#PrimaryModalalert').modal("show");
           }
      });
   });
    
  
</script>-->

</body>
</html>