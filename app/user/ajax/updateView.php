<?php  
session_start();
error_reporting(0);
include('../../class/config.php');

$output = '';   
$query = "SELECT * FROM leads WHERE id = '".$_POST["id"]."'";  
$result = mysqli_query($con, $query);  
$run = mysqli_fetch_array($result);

?>

<form class="form" method="POST">

    <div class="row">
        <div class="col-md-3" style="text-align: center; padding-top: 7px;">
            <b style="">Name :</b>
        </div>
        <div class="col-md-9" style="width: 281px;">
            <input type="text" maxlength="20"  class="form-control letter" name="name"  value="<?php echo $run['name']; ?>" >
        </div>

        <div class="col-md-3" style="text-align: center; padding-top: 21px;">
            <b style="">Email :</b>
        </div>
        <div class="col-md-9" style="width: 281px; padding-top: 14px;">
            <input type="email" maxlength="35" name="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" class="form-control"  value="<?php echo $run['email']; ?>" >
        </div>

        <div class="col-md-3" style="text-align: center; padding-top: 21px;">
            <b style="">Phone :	</b>
        </div>
        <div class="col-md-9" style="width: 281px; padding-top: 14px;">
            <input type="text"  maxlength="12" class="form-control digit" name="phone"  value="<?php echo $run['mobile']; ?>" required>
        </div>

        <div class="col-md-3" style="text-align: center; padding-top: 21px;">
            <b style="">Project :</b>
        </div>
        <div class="col-md-9" style="width: 281px; padding-top: 14px;">
            <input type="text" maxlength="20" class="form-control letter" name="project"  value="<?php echo $run['enquiry']; ?>" >
        </div>

        <div class="col-md-3" style="text-align: center; padding-top: 21px;">
            <b>Remark :</b>
        </div>
        <div class="col-md-9" style="width: 281px; padding-top: 14px;">
            <textarea class="form-control" required name="remark" id="exampleTextarea1" rows="2"><?php echo $run['remark']; ?></textarea>
        </div>

        <div class="col-md-3" style="text-align: center; padding-top: 21px;">
           <b>Status :</b>
        </div>
        <div class="col-md-9" style="width: 281px; padding-top: 14px;">
           <select class="form-control status" name="status" onchange="Check(this);" required>
              <option value="1" <?php if($run['status']=="1") echo 'selected="selected"'; ?> >New</option>
              <!--<option value="" selected disabled hidden>New</option>-->
              <option value="2" <?php if($run['status']=="2") echo 'selected="selected"'; ?> >Hot</option>
              <option value="3" <?php if($run['status']=="3") echo 'selected="selected"'; ?> >Dead</option>
              <option value="4" <?php if($run['status']=="4") echo 'selected="selected"'; ?> >DND</option>
              <option value="5" <?php if($run['status']=="5") echo 'selected="selected"'; ?> >Follow-Up</option>
              <option value="6" <?php if($run['status']=="6") echo 'selected="selected"'; ?> >Attempted</option>
           </select>           
        </div>

        <div class="col-md-3 ifYes" style="text-align: center;width: 212px; padding-top: 29px; padding-bottom: 20px; display:none">
            <b style="">Next call :</b>
        </div>
        <div class="col-md-9 ifYes" style="width: 281px; padding-top: 14px;display:none">
            <input type="text" class="form-control letter" id="next_call" name="next_call"  value="<?php echo $run['next_call']; ?>" >
        </div>
    </div>  

    <div class="modal-footer">
     <input type="hidden" name="id" value="<?php echo $run['id']; ?>">
      <button type="submit" class="btn btn-save" name="change">
        <span class="glyphicon glyphicon-edit"></span> Save Changes</button>
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