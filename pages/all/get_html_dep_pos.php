<?php
	$part = "../../";
	include ($part."include/function.php"); 
	$dep_arr = array();
	$pos_arr = array();
	
	$sql_dep = "SELECT dep_id,dep_name FROM department WHERE active_status = '1'";
	$query_dep = $db->query($sql_dep);
	while($rec_dep = $db->db_fetch_array($query_dep)){
		$dep_arr[trim($rec_dep['dep_id'])] = $rec_dep['dep_name'];
	}
	
	$sql_pos = "SELECT pos_id,pos_name FROM m_position WHERE active_status = '1'";
	$query_pos = $db->query($sql_pos);
	while($rec_pos = $db->db_fetch_array($query_pos)){
		$pos_arr[trim($rec_pos['pos_id'])] = $rec_pos['pos_name'];
	}
?>
<tr id="tr_<?=$_POST['on'];?>" on-count="<?=$_POST['on'];?>">
	<td style="text-align: center;"><?=$_POST['on'];?></td>
	<td style="text-align: center;">
		<select class="form-control select2" id="DEP_ID_<?=$_POST['on'];?>" name="DEP_ID[]">
		  <option value="">---เลือก---</option>
		  <?php
			foreach($dep_arr as $key_dep=>$val_dep){ ?>
			  <option value="<?=$key_dep;?>" ><?=$val_dep;?></option>
		  <?php
			}
		  ?>
		</select>
	</td>
	<td style="text-align: center;">
		<select class="form-control select2" id="POS_ID_<?=$_POST['on'];?>" name="POS_ID[]">
		  <option value="">---เลือก---</option>
		  <?php
			foreach($pos_arr as $key_pos=>$val_pos){ ?>
			  <option value="<?=$key_pos;?>" ><?=$val_pos;?></option>
		  <?php
			}
		  ?>
		</select>
	</td>
	<td style="text-align: center;"><button type="button" class="btn btn-gradient-danger  btn-md" onClick="remove('<?=$_POST['on'];?>');"><i class="mdi mdi-delete icon-lg"></i> ลบ</button></td>
</tr>
<script>
	$(document).ready(function() { 
		$(".select2").select2(); 
		$(".selectbox").select2(); 
	});
</script>