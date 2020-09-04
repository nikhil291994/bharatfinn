<?php  
session_start();
error_reporting(0);
include('../../class/config.php');

$output = '';   
$query = "SELECT * FROM shopdetails WHERE shop_id = '".$_POST["id"]."'";  
$result = mysqli_query($con, $query);  
$run = mysqli_fetch_array($result);

?>

<form method="POST" action="index.php">

    <div class="row">

        <div class="col-md-3" style="padding-top: 21px;">
            <b>Shop ID :</b>
        </div>
        <div class="col-md-9" style="padding-top: 21px;">
            <span><?php echo $run['shop_id']; ?></span>
        </div>

        <div class="col-md-3" style="padding-top: 21px;">
            <b>Owner Name :</b>
        </div>
        <div class="col-md-9" style="padding-top: 21px;">
            <span><?php echo $run['ownername']; ?></span>
        </div>

        <div class="col-md-3" style="padding-top: 21px;">
            <b>Bank Name :</b>
        </div>
        <div class="col-md-9" style="padding-top: 21px;">
            <span><?php echo $run['bank_name']; ?></span>
        </div>

        <div class="col-md-3" style="padding-top: 21px;">
            <b style="">Account No. :   </b>
        </div>
        <div class="col-md-9" style="padding-top: 21px;">
            <span><?php echo $run['account_no']; ?></span>
        </div>

        <div class="col-md-3" style="padding-top: 21px;">
            <b style="">IFSC Code :</b>
        </div>
        <div class="col-md-9" style="padding-top: 21px;">
            <span><?php echo $run['ifsc_code']; ?></span>
        </div>

        <div class="col-md-3" style="padding-top: 21px;">
            <b style="">PAN No. :</b>
        </div>
        <div class="col-md-9" style="padding-top: 21px;">
            <span><?php echo $run['pan_no']; ?></span>
        </div>

        <div class="col-md-3" style="padding-top: 21px;">
            <b style="">Adhaar No. :</b>
        </div>
        <div class="col-md-9" style="padding-top: 21px;">
            <span><?php echo $run['addhar_no']; ?></span>
        </div>

        <div class="col-md-3" style="padding-top: 21px;">
            <b>Address :</b>
        </div>
        <div class="col-md-9" style="padding-top: 21px;">
            <span><?php echo $run['shopaddress']; ?></span>
        </div>

        <div class="col-md-3" style="padding-top: 29px;">
            <b>Status :</b>
        </div>
        <div class="col-md-9" style="padding-top: 14px;">
            <select class="form-control" name="status" required>
                <option value="">Select Any One Status</option>
                <option value="1" <?php if($run['status']=="1") echo 'selected="selected"'; ?> >New</option>
                <option value="3" <?php if($run['status']=="3") echo 'selected="selected"'; ?> >Rejected</option>
                <option value="8" <?php if($run['status']=="8") echo 'selected="selected"'; ?> >Approved</option>
            </select>
        </div>

        <div class="col-md-3" style="padding-top: 21px;">
            <b>Added by :</b>
        </div>
        <div class="col-md-9" style="padding-top: 21px;">
            <span>
                <?php
                    $selectId = "SELECT login_id, position, email, username FROM users WHERE id = '".$run['assign_tele_id']."' ";
                    $rowId = mysqli_query($con, $selectId);
                    $row1Id = mysqli_fetch_array($rowId);
                    echo $row1Id['username']." - (".$row1Id['login_id'].") - ";

                    if ($_SESSION['email'] == $row1Id['email'])
                    {
                        echo " Self";
                    }
                    else if ($row1Id['position'] == '1')
                    {
                        echo " Super Admin";
                    }
                    else if ($row1Id['position'] == '2')
                    {
                        echo " Sales Person";
                    }
                    else if ($row1Id['position'] == '3')
                    {
                        echo " Team Leader";
                    }
                    else if ($row1Id['position'] == '4')
                    {
                        echo " Client";
                    }
                    else if ($row1Id['position'] == '5')
                    {
                        echo " ASM";
                    }
                ?>
            </span>
        </div>

    </div>  

    <div class="modal-footer">
        <input type="hidden" name="id" value="<?php echo $run['shop_id']; ?>">
        <button type="submit" class="btn btn-primary waves-effect waves-light" name="changeShop">
            <span class="glyphicon glyphicon-edit"></span> Save Changes
        </button>

      <button type="button" class="btn btn-cancel" data-dismiss="modal">
        <span class="glyphicon glyphicon-remove-circle"></span> Cancel</button>
    </div>
</form>


<script src="js/jquery-3.3.1.js" type="text/javascript"></script>
<script src="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
var status_value = '<?php echo $run['status']; ?>';
if(status_value==5){
	$(".ifYes").show();
    $("#next_call").prop('required', true);
}

function Check(that) {
        if (that.value == "5") {
            $(".ifYes").show();
        }
         else {
            $(".ifYes").hide();
        }
    }
    
var date = new Date();
date.setDate(date.getDate());
jQuery('#next_call').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: "dd/mm/yyyy",
    startDate: date
});

$('.letter').keyup(function() {
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[0-9!@#$%^&*(),.?":{}|<>]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);
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


function Check(that) {
    if (that.value == "5") {
        $(".ifYes").show();
        $("#next_call").prop('required', true);
    } else if (that.value == "2" || that.value == "3") {
		$(".ifYes").hide();
		$("#next_call").prop('required', false);
        Swal({
            title: 'Are you sure?',
			text: 'You will no longer see the lead!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                Swal(
                    'Cool !',
                    '',
                    'success'
                )
            }else{
				$(".status").val(status_value);
			}
        });
    } else {
        $(".ifYes").hide();
        $("#next_call").prop('required', false);
    }
}
</script>