<?php
session_start();
error_reporting(0);
include('../class/config.php');

$selectId1 = "SELECT * FROM users WHERE username = '".$_SESSION['username']."' ";
$rowId1 = mysqli_query($con, $selectId1);
$row1Id1 = mysqli_fetch_array($rowId1);
?>
<div class="left side-menu" id="side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect"><i class="ion-close"></i></button>
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center bg-logo">
            <a href="index.php" class="logo">
                <img src="../assets/images/bharat_finn_logo.png" alt="logo" style="width: 171px; height: 128px;">
            </a>
        </div>
    </div>
    <div class="sidebar-user">
        <img src="../uploads/<?php echo $row1Id1['imgPath'];?>" alt="" class="rounded-circle img-thumbnail mb-1">
        <h6 class=""><?php echo $row1Id1['name'];?><br>(ID : <?php echo $row1Id1['login_id'];?>)</h6>
        <p class="online-icon text-dark">(Sales Person)</p>
        <ul class="list-unstyled list-inline mb-0 mt-2">
            <li class="list-inline-item"><a href="profile.php" class="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="dripicons-user text-blue"></i></a></li>
            <li class="list-inline-item"><a href="#logouttele" data-toggle="modal" data-placement="top" title="Log out">
                <i class="dripicons-power text-danger"></i></a></li><!--onclick="hidesideMenu();"-->
        </ul>
    </div>
    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>
                <li <?php if($_SERVER['SCRIPT_NAME']=="/index.php") {?> class="active" <?php } ?>>
                    <a href="index.php" class="waves-effect"><i class="dripicons-device-desktop"></i> 
                    <span>Dashboard</span>
                    <?php
                        $newLead = "SELECT COUNT(*) AS 'today' FROM leads WHERE assign_tele_id = '".$row1Id1['id']."' ORDER BY id DESC";
                        $rownewLead = mysqli_query($con, $newLead);
                        $runrownewLead = mysqli_fetch_array($rownewLead);
                    ?>
                    <span class="badge badge-pill badge-info float-right"><?php echo $runrownewLead['today'];?></span>
                </a>
                </li>

                <li <?php if($_SERVER['SCRIPT_NAME']=="/viewShops.php") {?> class="active" <?php } ?>>
                    <a href="viewShops.php" class="waves-effect"><i class="dripicons-device-desktop"></i>
                    <span> View Shop List</span>

                    <?php
                        $newShop = "SELECT COUNT(*) AS 'countAll' FROM shopdetails WHERE assign_tele_id = '".$row1Id1['id']."' ORDER BY shop_id DESC";
                        $rownewShop = mysqli_query($con, $newShop);
                        $runrownewShop = mysqli_fetch_array($rownewShop);
                    ?>
                    <span class="badge badge-pill badge-info float-right"><?php echo $runrownewShop['countAll'];?></span>
                    </a>
                </li>

                <li <?php if($_SERVER['SCRIPT_NAME']=="/addleads.php") {?> class="active" <?php } ?>>
                    <a href="addleads.php" class="waves-effect"><i class="dripicons-to-do"></i>
                    <span> Add New Leads</span></a>
                </li>

                <li <?php if($_SERVER['SCRIPT_NAME']=="/addshop.php") {?> class="active" <?php } ?>>
                    <a href="addshop.php" class="waves-effect"><i class="dripicons-to-do"></i>
                    <span> Add New Shop</span></a>
                </li>

                <li>
                    <a href="#logouttele" data-toggle="modal"><!--onclick="hidesideMenu();" -->
                        <i class="mdi mdi-logout"></i>
                        Logout
                    </a>
                </li>
                
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- end sidebarinner -->
</div>
<div id="logouttele" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Logout</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button><!--onclick="showSideMenu()" -->
            </div>
            <div class="modal-body">
                <input type="hidden" name="delete_id" value="<?php echo $id; ?>">
                <div class="alert alert-danger">Are you sure you want to logout
                    <strong>
                        <?php echo $_SESSION['username']; ?>?
                    </strong>
                </div>
                <div class="modal-footer">
                    <a href="logout.php">
                        <button type="button" class="btn btn-primary">YES </button>
                    </a>
                    <button type="button" class="btn btn-delete" data-dismiss="modal">No</button><!--onclick="showSideMenu()" -->
                </div>
            </div>
        </div>
    </div>
</div>
