<?php
session_start();
error_reporting(0);

include('../class/config.php');

if (!isset($_SESSION['email'])) 
{
    header('location: ../index.php');
}

$all = "SELECT * FROM users WHERE email = '".$_SESSION['email']."' ";
$run_all = mysqli_query($con, $all);
$show = mysqli_fetch_assoc($run_all);

if(isset($_POST['submit']))
    {
        $userName=mysqli_real_escape_string($con,$_POST['name']);
        $email=mysqli_real_escape_string($con,$_POST['email']);
        $contact=mysqli_real_escape_string($con,$_POST['contact']);
         //path = $_POST['imgpath'];

        $photo = $_FILES['avatar']['name'];
        $photo_tmp = $_FILES['avatar']['tmp_name'];

        $update=mysqli_query($con,"UPDATE users SET name='$userName',email='$email',contact='$contact' WHERE id = '".$show['id']."' ");

         if($update>0)
        {
            echo "<script>window.alert('Updated Successfully...')</script>";
            echo "<script>window.location.href='profile.php'</script>";
        }
        else
        {
            echo "<script>window.alert('Not updated ')</script>";
        }

        if(file_exists("../uploads/".$photo))
        {
            $newimgname = renameimage($photo);
            move_uploaded_file($photo_tmp,"../uploads/".$newimgname);
        
            $imgpath = "../uploads/".$newimgname;

            $update=mysqli_query($con,"UPDATE users SET name='$userName',email='$email',contact='$contact', imgPath='$imgpath' WHERE id = '".$show['id']."' ");
        }   
        else
        {
            move_uploaded_file($photo_tmp,"../uploads/".$photo);
        
            $imgpath = "../uploads/".$photo;

            $update=mysqli_query($con,"UPDATE users SET name='$userName',email='$email',contact='$contact', imgPath='$imgpath' WHERE id = '".$show['id']."' ");
        }    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>ASM | Profile | Bharat Finn</title>
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

    <style type="text/css">
        text{
            font-size: 16px !important; 
        }
        body{
            overflow: hidden;
        }
    </style>

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
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect"><i class="ion-close"></i></button>
            <!-- LOGO -->
            <div class="topbar-left">
                
            </div>
            <?php include 'sidebar.php'; ?>
            
            <!-- end sidebarinner -->
        </div>
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
                        
 <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <form method="POST" id="editprofile" class="form-horizontal" enctype="multipart/form-data">                                            
                                            <div class="form-group">
                                                <label>Name</label>
                                                <div>
                                                   <input type="text" maxlength="20" name="name" value="<?php echo $show['name'];?>" placeholder="Enter Your Fullname" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>E-Mail</label>
                                                <div>
                                                   <input type="email" maxlength="40" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" class="form-control" readonly value="<?php echo $show['email'];?>" name="email" id="email" placeholder="Enter Your Email-Id" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Contact No.</label>
                                                <div>
                                                    <input type="text" class="form-control digit" maxlength="12"  minlength="10"  value="<?php echo $show['contact'];?>" name="contact" id="phone"  placeholder="Enter Your Contact Number" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Avatar</label>
                                                <?php if(!empty($show['imgPath']!='')) { ?>
					                                <div class=""> 
					                                    <input type="file" id="field-file" name="avatar" class="form-control" placeholder="Upload Your Avatar" accept="image/jpeg, image/png">
					                                    <span class="help-block">Uploading new Image will replace current Image
					                                        
					                                    </span>
					                                </div>
					                                
					                                <?php } else { ?>
					                                <div class="col-6 col-md-4"> 
					                                    <input type="file" id="field-file" name="avatar" class="form-control" placeholder="Upload Your Avatar" accept="image/jpeg, image/png">
					                                    <span class="help-block">You can upload PNG/JPEG image file</span>
					                                </div>
					                                <?php } ?>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div>
                                                    <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-dot-circle-o"></i>Submit</button>
                                                    <button type="reset" class="btn btn-secondary waves-effect m-l-5"> Clear</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body" style="padding: 1.25rem;">
                                    	<div class="card-body" style="padding: 1.25rem;height: 420px;">
                                    		<img src='../uploads/<?php echo $show['imgPath'];?>' class='avatar' style="height:260px;width:260px;"  alt='Profile'>
                                    	</div>
                                    </div>                                    
                                </div>                                
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    

                        
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

    <script type="text/javascript">
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
    </script>

</body>
</html>