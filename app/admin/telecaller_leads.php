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
$status = mysqli_real_escape_string($con, $_POST['status']);
$remark = mysqli_real_escape_string($con, $_POST['remark']);

$update = "UPDATE leads SET name = '".$name."', email = '".$email."', mobile = '".$phone."', status = '".$status."', remark = '".$remark."' WHERE id = '".$id."' ";
mysqli_query($con, $update);

header('location: telecaller_leads.php?user_id='.$_GET['user_id'].' ');
}    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Super Admin | Sales-Person Leads | Bharat Finn</title>
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
                                            <li class="breadcrumb-item active">Sales-Person Leads</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Sales-Person Leads</h4></div>
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
                                <option value="">Select Sales-Person Name</option>
        			                <?php                  
        			                    $sql1 = 'SELECT * FROM users WHERE position = 2 ';
        			                    $query1 = mysqli_query($con,$sql1);
        			                    $x=1;
        			                    while($row1 = mysqli_fetch_assoc($query1))
        			                    {
        			                ?>
                                <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name'].'-'.$row1['login_id']; ?></option>
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
                    </td>
                    </tr>
                    <br>
                    <tr style="text-align: center;">
                        <td><h4><?php echo $run2['name']; ?></h4></td>
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
    <center>Please Select Telecaller</center>
</div>
<?php  }
?>

<?php if($_GET['user_id'] !='' && $_GET['user_id'])
{?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="overflow-x: auto; overflow-y: auto;">
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            
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
                                                    <th class="all">Change</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $x = 1;
                                                    $fetch = "SELECT * FROM leads WHERE assign_tele_id = '".$_GET['user_id']."'AND assign_tele_id != '0' ORDER BY id DESC";
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
                                                    <td>
                                                        <div class="col-sm-6 col-md-3">           
                                                                <!-- Small modal -->
                                                                <button type="button" id="<?php echo $run["id"]; ?>" class="btn btn-primary waves-effect waves-light change_data" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center" style='font-size: 12px;'><i class="fas fa-user-edit"></i> Change</button>
                                                                <!-- /.modal -->
                                                        </div>
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
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    <?php } 
                    else{ ?>
                        <div id="none" style="margin-top: 30px; font-size: 36pt; color: #8f959a; font-family: Montserrat; height:150px;">
                        <center>Please Select Sales-Person</center>
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
           url:"ajax/telecaller_leads.php",
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
       if($('input:checkbox:checked').length > 0)
       {
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
			
       }
       else
       {
         alert('No lead(s) selected');
       }
   });
});
</script>
</body>
</html>