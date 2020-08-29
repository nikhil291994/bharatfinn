<style type="text/css">
.buttons-pdf, .buttons-copy, .buttons-collection
{
    display: none;
}
</style>
<div class="topbar">
    <nav class="navbar-custom">
        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <!--onclick="showSideMenu()"-->
                <button class="button-menu-mobile open-left waves-light waves-effect" ><i class="mdi mdi-menu"></i></button>
            </li>
        </ul>
        <ul class="list-inline float-right mb-0">                            
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                	<img src="../uploads/<?php echo $row1Id1['imgPath'];?>" alt="user" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5>Welcome</h5>
                    </div>
                    <a class="dropdown-item" href="profile.php">
                        <i class="mdi mdi-account-circle m-r-6 text-muted"></i> Profile
                    </a> 
                    <a class="dropdown-item" href="changepass.php">
                        <i class="mdi mdi-wallet m-r-6 text-muted"></i> Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#logoutadmin" data-toggle="modal" class="dropdown-item"><i class="mdi mdi-logout m-r-6 text-muted"></i>Logout</a>
                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </nav>
</div>