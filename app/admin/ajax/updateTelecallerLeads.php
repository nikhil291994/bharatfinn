<?php  
session_start();
error_reporting(0);
include('../../class/config.php');

$output = '';   
$query2 = "SELECT * FROM leads WHERE id = '".$_POST["id"]."'";  
$result2 = mysqli_query($con, $query2);  
$run2 = mysqli_fetch_array($result2);

?>
<form method="POST">
<table>

     <div class="row">
            <div class="col-md-3" style="text-align: center; padding-top: 7px;">
                <b style="">Name :</b>
            </div><div class="col-md-9" style="width: 281px;">
                <input type="text" maxlength="20"  class="form-control letter" name="name"  value="<?php echo $run2['name']; ?>" >
            </div>

      <div class="col-md-3" style="text-align: center; padding-top: 21px;">
          <b style="">Email :</b>
      </div>
      <div class="col-md-9" style="width: 281px; padding-top: 14px;">
          <input type="email" maxlength="35" name="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" class="form-control"  value="<?php echo $run2['email']; ?>" >
      </div>

      <div class="col-md-3" style="text-align: center; padding-top: 21px;">
          <b style="">Phone :</b>
      </div>
      <div class="col-md-9" style="width: 281px; padding-top: 14px;">
          <input type="number"  maxlength="12" minlength="10" class="form-control digit" name="phone"  value="<?php echo $run2['mobile']; ?>" >
      </div>

      <div class="col-md-3" style="text-align: center; padding-top: 21px;">
          <b style="">Project :</b>
      </div>
      <div class="col-md-9" style="width: 281px; padding-top: 14px;">
          <input type="text" maxlength="20" class="form-control letter" name="project"  value="<?php echo $run2['enquiry']; ?>" >
      </div>

      <div class="col-md-3" style="text-align: center; padding-top: 21px;">
          <b style="">Assigned To :</b>
      </div>
      <div class="col-md-9" style="width: 281px; padding-top: 14px;">
          <select name="assign_sales_id" class="form-control" required>
            <option selected disabled hidden>Not Assigned yet</option>
            <option disabled style="font-weight:600;color:#666;">TELECALLER</option>
            <?php                  
              $users = 'SELECT * FROM users WHERE position = 2 ';
              $resultusers = mysqli_query($con,$users);
              $x=1;
              while($rowresult = mysqli_fetch_assoc($resultusers))
              {
              ?>
              <option value="<?php echo $rowresult['id']; ?>"<?php if($run2['assign_tele_id']==$rowresult['id']) echo 'selected="selected"'; ?>><?php echo $rowresult['name']; ?></option>
              <?php } ?>
            <option disabled style="font-weight:600;color:#666;">SALESPERSON</option>
            <?php                  
              $users = 'SELECT * FROM users WHERE position = 3 ';
              $resultusers = mysqli_query($con,$users);
              $x=1;
              while($rowresult = mysqli_fetch_assoc($resultusers))
              {
              ?>
              <option value="<?php echo $rowresult['id']; ?>"<?php if($run2['assign_sales_id']==$rowresult['id']) echo 'selected="selected"'; ?>><?php echo $rowresult['name']; ?></option>
              <?php } ?>
          </select>
      </div>

      <div class="col-md-3" style="text-align: center; padding-top: 21px;">
          <b>Remark :</b>
      </div>
      <div class="col-md-9" style="width: 281px; padding-top: 14px;">
            <textarea class="form-control" name="remark" id="exampleTextarea1" rows="2"><?php echo $run2['remark']; ?></textarea>
      </div>

      <div class="col-md-3" style="width: 212px; padding-top: 29px;">
         <b>Status :</b>
      </div>
      <div class="col-md-9" style="width: 281px; padding-top: 14px;">
         <select class="form-control" name="status" onchange="Check(this);">
              <option value="1" <?php if($run2['status']=="1") echo 'selected="selected"'; ?> >New</option>
              <option value="2" onclick="return confirm('Are you sure ?')" <?php if($run['status']=="2") echo 'selected="selected"'; ?> >Hot</option>
              <option value="3" <?php if($run2['status']=="3") echo 'selected="selected"'; ?> >Dead</option>
              <option value="4" <?php if($run2['status']=="4") echo 'selected="selected"'; ?> >DND</option>
              <option value="5" <?php if($run2['status']=="5") echo 'selected="selected"'; ?> >Follow-Up</option>
              <option value="6" <?php if($run2['status']=="6") echo 'selected="selected"'; ?> >Attempted</option>             
         </select>         
      </div>

      <div class="col-md-3 ifYes" style="width: 212px; padding-top: 29px;">
          <b style="">Next call :</b>
      </div>
      <div class="col-md-9 ifYes" style="width: 281px; padding-top: 14px;">
          <input type="text" class="form-control letter" id="next_call" name="next_call"  value="<?php echo $run2['next_call']; ?>" >
      </div>
</div>  

 <div class="modal-footer">
   <input type="hidden" name="id" value="<?php echo $run2['id']; ?>">
    <button type="submit" class="btn btn-primary waves-effect waves-light" name="change"><span class="glyphicon glyphicon-edit"></span> Save Changes</button>
    <button type="button" class="btn btn-delete waves-effect waves-light" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> Cancel</button>
  </div>

</form>

  <script src="js/jquery-3.3.1.js" type="text/javascript"></script>
  <script src="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">

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
</script>
<script>
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

    function Check(that) {
        if (that.value == "5") {
            $(".ifYes").show();
        }
         else {
            $(".ifYes").hide();
        }
    }

</script>