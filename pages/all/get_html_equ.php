<?php
	$part = "../../";
	include ($part."include/function.php"); 
	$equ_arr = array();

	$sql_equ = "SELECT equ_id,equ_name FROM equipment GROUP BY equ_id,equ_name";
	$query_equ = $db->query($sql_equ);
	while($rec_equ = $db->db_fetch_array($query_equ)){
		$equ_arr[trim($rec_equ['equ_id'])] = $rec_equ['equ_name'];
	}
?>
<tr id="tr_<?=$_POST['on'];?>">
	<td style="text-align: center;"><?=$_POST['on'];?></td>
	<td style="text-align: center;">
		<select class="form-control select2" id="equ_id_<?=$_POST['on'];?>" name="equ_id[]">
		  <option value="">---เลือก---</option>
		  <?php
			foreach($equ_arr as $key_equ=>$val_equ){ ?>
			  <option value="<?=$key_equ;?>" ><?=$val_equ;?></option>
		  <?php
			}
		  ?>
		</select>
	</td>
	<td style="text-align: center;">
		<input type="text" class="form-control" id="equ_sum_<?=$_POST['on'];?>" name="equ_sum[]" value="">
	</td>
	<td style="text-align: center;"><button type="button" class="btn btn-gradient-danger  btn-md" onClick="remove('<?=$_POST['on'];?>');"><i class="mdi mdi-delete icon-lg"></i> ลบ</button></td>
</tr>
<script>
	$(document).ready(function() { 
		$(".select2").select2(); 
		$(".selectbox").select2(); 
	});
</script>