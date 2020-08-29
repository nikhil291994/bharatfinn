<?php
session_start();
error_reporting(0);
include('../class/config.php');

if (!isset($_SESSION['email'])) 
{
    header('location: ../index.php');
}

if(isset($_POST['submit']))
    {
        $name = mysqli_real_escape_string($con, $_POST['name']);        
        $contact = mysqli_real_escape_string($con, $_POST['contact']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $username = mysqli_real_escape_string($con, $_POST['username']);

        $id_proof_type = mysqli_real_escape_string($con, $_POST['id_proof_type']);
        $id_proof_number = mysqli_real_escape_string($con, $_POST['id_proof_number']);

        $password = mysqli_real_escape_string($con, md5($_POST['password']));
        $or_pass = mysqli_real_escape_string($con, $_POST['password']);
        $conf_password = mysqli_real_escape_string($con, $_POST['conf_password']);

        $postion = mysqli_real_escape_string($con, $_POST['postion']);  

       if(function_exists('date_default_timezone_set')) 
        {
            date_default_timezone_set("Asia/Kolkata");
        }

        $submit_date = date("d/m/Y");
        $submit_time =  date("H:i a");
        $member_since = $submit_date.'-'.$submit_time;

        $FROM = 0; $TO = 'zzzz';
        $code = base_convert(rand( $FROM ,base_convert( $TO , 36,10)),10,36);

        $contactCheck="SELECT * FROM users WHERE contact = '".$contact."' ";
        $contactrs = mysqli_query($con,$contactCheck);
        $contactdata = mysqli_fetch_array($contactrs);

        $emailCheck="SELECT * FROM users WHERE email = '".$email."' ";
        $emailrs = mysqli_query($con,$emailCheck);
        $emaildata = mysqli_fetch_array($emailrs);

        $usernameCheck="SELECT * FROM users WHERE username = '".$username."' ";
        $usernamers = mysqli_query($con, $usernameCheck);
        $usernamedata = mysqli_fetch_array($usernamers);

        if($usernamedata > 1) 
        {
           
            $msg = "<div class='alert alert-danger alert-mg-b'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    <strong>Error !</strong> Username already exists.
                                </div>";
        }        
        elseif ($emaildata[0] > 1) 
        {
            
            $msg = "<div class='alert alert-danger alert-mg-b'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    <strong>Error !</strong> Email ID already exists.
                                </div>";
        }
        elseif ($contactdata[0] > 1) 
        {
            
            $msg = "<div class='alert alert-danger alert-mg-b'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    <strong>Error !</strong> Contact No. already exists.
                                </div>";
        }
        elseif ($conf_password != $or_pass) 
        {
            
            $msg = "<div class='alert alert-danger alert-mg-b'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    <strong>Error !</strong> Password and Confirm Password are not same.
                                </div>";
        }
        else
        {
            $FROM = 0; 
            $TO = 'zzzz';
            $code1 = base_convert(rand( $FROM ,base_convert( $TO , 36,10)),10,36);
            $code2 = strtoupper($code1);

            $query = "INSERT INTO users(login_id, name, contact, email, username, password, or_pass, id_proof_type, id_proof_number, position, active_status, member_since, imgPath) VALUES ('".$code2."','".$name."','".$contact."','".$email."', '".$username."','".$password."','".$or_pass."','".$id_proof_type."','".$id_proof_number."','".$postion."','1','".$member_since."','default.png')";
            if(mysqli_query($con, $query))
            {
                $msg = "<div class='alert alert-success'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        <strong>New Member Added.</strong>
                    </div>";
            }
            else
            {
                $msg = "<div class='alert alert-danger'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        <strong>Error... New Member Not Added.</strong>
                    </div>";
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
    <title>Super-Admin | Create Member | Bharat Finn</title>
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
    
        <style type="text/css">
            .pass_show{position: relative} 

    .pass_show .ptxt { 

    position: absolute; 

    top: 72%; 

    right: 21%;

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
    
        text{
            font-size: 16px !important; 
        }
        form{
                margin-left: 50px;
            }
    </style>
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
                                            <li class="breadcrumb-item"><a href="index.php">Super-Admin</a></li>
                                            <li class="breadcrumb-item active">Add New Member</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add New Member</h4></div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h7><?php echo $msg; ?></h7>
                                        <form method="POST" >

                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="username" class="form-control" required placeholder="Enter a Username">
                                        </div>

                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" required placeholder="Enter a Name">                     
                                        </div>

                                        <div class="form-group">  
                                            <label>E-Mail</label>
                                            <input type="email" name="email" class="form-control" required parsley-type="email" placeholder="Enter a valid e-mail">
                                        </div>
                                        <div class="form-group">
                                            <label>Contact No.</label>
                                            <input type="text" name="contact" maxlength="12" minlength="10" class="form-control digit" required placeholder="Enter Contact Number">
                                        </div>

                                        <div class="form-group">
                                            <label>ID Proof Type/Name</label>
                                            <input type="text" name="id_proof_type" class="form-control" required placeholder="Enter ID Proof Type/Name">                     
                                        </div>
                                        <div class="form-group">
                                            <label>ID Proof Number</label>
                                            <input type="text" name="id_proof_number" class="form-control" required placeholder="Enter ID Proof Number">                     
                                        </div>

                                        <div class="form-group">
                                                <label>Assign Position</label>                
                                                    <select name="postion" class="form-control" required>
                                                    <option value="">Select one positon</option>
                                                    <option value="2">Sales Person</option>
                                                </select>
                                           
                                        </div>
                                        <div class="form-group pass_show">
                                            <label>Set Password</label>
                                            
                                                <input name="password" type="password" class="form-control" required placeholder="Enter Password">
                                            
                                        </div>
                                        <div class="form-group pass_show">
                                            <label>Confirm Password</label>
                                           
                                                <input name="conf_password" type="password" class="form-control" required placeholder="Enter Confirm Password">
                                            
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">Clear</button>
                                        </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
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
<!-- 
    <script type="text/javascript" src="https://www.google.com/jsapi"></script> -->
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

if (window.history.replaceState) 
{
    window.history.replaceState(null, null, window.location.href);
}


    $(document).ready(function(){
$('.pass_show').append('<span class="ptxt">Show</span>');  
});
  

$(document).on('click','.pass_show .ptxt', function(){ 

$(this).text($(this).text() == "Show" ? "Hide" : "Show"); 

$(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

}); 


</script>

</body>
</html>