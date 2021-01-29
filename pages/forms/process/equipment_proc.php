<?php
session_start();
$part = "../../../";
include ($part."include/function.php"); 

$file_size = $_FILES['file_upload']['size'];
$file_name = $_FILES['file_upload']['name'];
$file = $_FILES['file_upload']['tmp_name'];
$arr_file_type = $_FILES['file_upload']['type'];

if($file_size > 0){
	
	$attachid = (random(40)).date('dmyhis'); 

	$F = explode(".",$file_name);
	$C = count($F);
	$CT = $C-1;
	$dir = strtolower($F[$CT]);
	$file_name1 = $attachid.".".$dir;
	copy($file,$part."file_uplode/".$file_name1);
	$file_date = date("Ymd");
	$file_time = date("H:i:s");
	
	$filename = $file_name; 
	$file_type1 = $F[count($F)-1]; 
	
	//ชื่อไฟล์ใหม่      $file_name1
	//ชื่อไฟล์เดิม      $filename
	//นามสกุลไฟล์   $file_type1
}


switch ($_POST['proc']) {
    case 'add':
        
				unset($fields);
					$fields['equ_number']	= $_POST['equ_number'];
					$fields['equ_name']		= $_POST['equ_name'];
					$fields['equ_gen']		= $_POST['equ_gen'];
					$fields['equ_year']		= $_POST['equ_year'];
					$fields['series_no']	= $_POST['series_no'];
					$fields['equ_type']		= $_POST['equ_type'];
					$fields['active_status']= $_POST['ACTVE_STATUS'];
				$equ_id = $db->db_insert('equipment',$fields);
				
				unset($fields);
					$fields['temp_datetime']		= date('Y-m-d h:i:s');
					$fields['file_name_default']	= $filename;
					$fields['file_type']			= $arr_file_type;
					$fields['file_name_new']		= $file_name1;
					$fields['temp_user']			= $_SESSION['PER_ID'];
					$fields['temp_user_update']		= $_SESSION['PER_ID'];
					$fields['tab_id']				= $equ_id;
					$fields['tab_name']				= 'equipment';
				$db->db_insert('file_uplode',$fields);
				$db->query("UPDATE equipment SET img = '{$file_name1}' WHERE equ_id = '{$equ_id}'");
				break;
    case 'edit':
	
				unset($fields);
					$fields['equ_number']	= $_POST['equ_number'];
					$fields['equ_name']		= $_POST['equ_name'];
					$fields['equ_gen']		= $_POST['equ_gen'];
					$fields['equ_year']		= $_POST['equ_year'];
					$fields['series_no']	= $_POST['series_no'];
					$fields['equ_type']		= $_POST['equ_type'];
					$fields['active_status']= $_POST['ACTVE_STATUS'];
				$db->db_update('equipment',$fields,"equ_id = '".$_POST['equ_id']."'");
				
				$db->db_delete('file_uplode',"tab_id = '".$_POST['equ_id']."' and tab_name = 'equipment'");
				unset($fields);
					$fields['temp_datetime']		= date('Y-m-d h:i:s');
					$fields['file_name_default']	= $filename;
					$fields['file_type']			= $arr_file_type;
					$fields['file_name_new']		= $file_name1;
					$fields['temp_user']			= $_SESSION['PER_ID'];
					$fields['temp_user_update']		= $_SESSION['PER_ID'];
					$fields['tab_id']				= $_POST['equ_id'];
					$fields['tab_name']				= 'equipment';
				$db->db_insert('file_uplode',$fields);
				$db->query("UPDATE equipment SET img = '{$file_name1}' WHERE equ_id = '{$_POST['equ_id']}'");
				break;
    case 'del':
				$db->db_delete('equipment',"equ_id = '".$_POST['equ_id']."'");
				break;
	default: echo "Not Process"; break;
}
echo "<script> window.location.href=\"../".$_POST['url_back']."\" </script> ";
?>
