<?php  
session_start();
error_reporting(0);
include('../../class/config.php');

$output = '';   
$query2 = "SELECT * FROM users WHERE id = '".$_POST["id"]."'";  
$result2 = mysqli_query($con, $query2);  
$run2 = mysqli_fetch_array($result2);

?>
<form method="POST">
<table>
  <div class="row">
    <div class="col-md-3" style="padding-top: 7px;">
      <b style="">Name :</b>
    </div>
    <div class="col-md-9" style="">
      <input type="text" maxlength="20"  class="form-control letter" name="name"  value="<?php echo $run2['name']; ?>" >
    </div>

      <div class="col-md-3" style="padding-top: 21px;">
          <b style="">Email :</b>
      </div>
      <div class="col-md-9" style="padding-top: 14px;">
          <input type="email" maxlength="35" name="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" class="form-control"  value="<?php echo $run2['email']; ?>" >
      </div>

      <div class="col-md-3" style="padding-top: 21px;">
          <b style="">Phone :</b>
      </div>
      <div class="col-md-9" style="padding-top: 14px;">
          <input type="number"  maxlength="12" minlength="10" class="form-control digit" name="phone"  value="<?php echo $run2['contact']; ?>" >
      </div>

      <div class="col-md-3" style="padding-top: 29px;">
         <b>Assign Position :</b>
      </div>
      <div class="col-md-9" style="padding-top: 14px;">
         <select class="form-control" name="position" onchange="Check(this);" required>
          <option value="">Select Position</option>
          <option value="5" <?php if($run2['position']=="5") echo 'selected="selected"'; ?> >Area Sales Manager</option>
          <option value="3" <?php if($run2['position']=="3") echo 'selected="selected"'; ?> >Team Leader</option>
          <option value="2" <?php if($run2['position']=="2") echo 'selected="selected"'; ?> >Sales Person</option>
          <option value="4" <?php if($run2['position']=="4") echo 'selected="selected"'; ?> >User</option>
         </select>        
      </div>

</div>  

 <div class="modal-footer">
   <input type="hidden" name="id" value="<?php echo $run2['id']; ?>">
    <button type="submit" class="btn btn-primary waves-effect waves-light" name="change"><span class="glyphicon glyphicon-edit"></span> Save Changes</button>
    <button type="button" class="btn btn-delete waves-effect waves-light" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> Cancel</button>
  </div>

</form>

  <script src="js/jquery-3.3.1.js" type="text/javascript"></script>

<script type="text/javascript">
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