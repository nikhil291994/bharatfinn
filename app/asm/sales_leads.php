<?php
session_start();
error_reporting(0);
include('../class/config.php');


if (!isset($_SESSION['email'])) 
{
    header('location: ../index.php');
}

if(isset($_POST['change'])) 
{
$id = mysqli_real_escape_string($con, $_POST['id']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$assign_sales_id = mysqli_real_escape_string($con, $_POST['assign_sales_id']);
//$assign_tele_id = mysqli_real_escape_string($con, $_POST['assign_sales_id']);
$project = mysqli_real_escape_string($con, $_POST['project']);
$next_call = mysqli_real_escape_string($con, $_POST['next_call']);
$status = mysqli_real_escape_string($con, $_POST['status']);
$remark = mysqli_real_escape_string($con, $_POST['remark']);

$update = "UPDATE leads SET name = '".$name."',email = '".$email."', mobile = '".$phone."', enquiry = '".$project."', assign_sales_id = '".$assign_sales_id."',next_call = '".$next_call."',status = '".$status."', remark = '".$remark."' WHERE id = '".$id."' ";
mysqli_query($con, $update);

header('location: sales_leads.php?user_id='.$_GET['user_id'].' ');
}    
?>
<!DOCTYPE html>
<html lang="en">
<!-- index.html  11:55:53 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>ASM | Salesperson Leads | Bharat Finn</title>
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
                                            <li class="breadcrumb-item"><a href="index.php">Admin</a></li>
                                            <li class="breadcrumb-item active">Salesperson Leads</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Salesperson Leads</h4></div>
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
			            	<select name="user_id" class="form-control" required>
			                <option value="">Select Sales Person Name</option>
			                <?php                  
			                    $sql1 = 'SELECT * FROM users WHERE position = 3 ';
			                    $query1 = mysqli_query($con,$sql1);
			                    $x=1;
			                    while($row1 = mysqli_fetch_assoc($query1))
			                    {
			                ?>            
			                <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
			                <?php } ?>
			                </select>
			            </td>
			            <td>

			                <input type="submit" name="search" class="btn btn-primary" value="Search">

			                <?php 
			                    $sql2=" SELECT * FROM users WHERE id = '".$_GET['user_id']."' ";
			                    $query2=mysqli_query($con,$sql2);
			                    $run2=mysqli_fetch_assoc($query2);
			                ?>
			                </td></tr><br>
			                <tr style="text-align: center;"><td><h4><?php echo $run2['name']; ?></h4></td>
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
    <center>Please Select Salesperson</center>
</div>
<?php  }
?>

<?php if($_GET['user_id'] !='' && $_GET['user_id'])
{?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">                                    	
                                        <!-- <h4 class="mt-0 header-title">New Leads</h4> -->
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="checkAll"><span id="delete" style="padding-left:8px;color: #696969;" title="Delete"><i class="fas fa-trash-alt"></i></span></th>
                                                    <th class="all">Sr. No.</th>
                                                    <th class="all">Unique ID</th>
                                                    <th class="all">Name</th>
                                                    <th class="all">Phone</th>
                                                    <th>Project</th>
                                                    <th class="all">Remark</th>
                                                    <th class="all">Status</th>
                                                    <th>Next Call</th>
                                                    <th class="all">Action</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <?php
                                                    $x = 1;
                                                    $fetch = "SELECT * FROM leads WHERE assign_sales_id = '".$_GET['user_id']."'AND assign_sales_id != '0' ORDER BY id DESC";
                                                    $row = mysqli_query($con, $fetch);
                                                    while ($run = mysqli_fetch_array($row)) 
                                                    {
                                                ?>   
                                                <tr>
                                                     <td><input class="checkbox leads" value="<?php echo $run['id']; ?>" type="checkbox" id="lead<?php echo $run['id']; ?>" name="leads[]"></td>
                                                    <td><?php echo $x++; ?></td>
                                                     <td><?php echo $run['id']; ?></td>
                                                    <td><?php echo $run['name']; ?></td>
                                                    <td><?php echo $run['mobile']; ?></td>
                                                    <td><?php echo $run['enquiry']; ?></td>
                                                    <td><?php echo $run['remark']; ?></td>
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
                                                    <td><?php echo $run['next_call']; ?></td>
                                                    <td>
                                                        <div class="col-sm-6 col-md-3">
                                                <div class="text-center">                                       
                                                    <!-- Small modal -->
                                                    <button type="button" id="<?php echo $run["id"]; ?>" class="btn btn-primary waves-effect waves-light change_data" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center" style='line-height: 16px;font-size: 12px;'><i class="fas fa-user-edit"></i> Change</button>
                                                </div>
<!-- /.modal-header -->                                                
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
                                            </div>
                                                    </td>
                                                    <td><?php echo $run['email']; ?></td>
                                                </tr>
                                                <?php  }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>Sr. No.</th>
                                                    <th>Unique ID</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Project</th>
                                                    <th>Remark</th>
                                                    <th>Status</th>
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
                    <?php } 
                    else{ ?>
                        <div id="none" style="margin-top: 30px; font-size: 36pt; color: #8f959a; font-family: Montserrat; height:150px;">
                        <center>Please Select Salesperson</center>
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

    <!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
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
           url:"ajax/sales_leads.php",
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
		   var x = confirm("Are you sure you want to Delete the selected leads?");
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
         alert('No lead(s) selected');
       }

    });  

  });
</script>
</body>
</html>