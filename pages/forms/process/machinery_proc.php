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

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

switch ($_POST['proc']) {
    case 'add':
        
				unset($fields);
					$fields['mac_number']	= $_POST['mac_number'];
					$fields['mac_name']		= $_POST['mac_name'];
					$fields['mac_gen']		= $_POST['mac_gen'];
					$fields['mac_year']		= $_POST['mac_year'];
					// $fields['series_no']	= $_POST['series_no'];
					$fields['com_id']		= $_POST['COM_ID'];
					$fields['dep_id']		= $_POST['DEP_ID'];
					$fields['mac_date']		= $_POST['mac_date'];
					$fields['date_shop']	= $_POST['date_shop'];
					$fields['mac_com_main']	= $_POST['mac_com_main'];
					$fields['mac_comment']	= $_POST['mac_comment'];
					$fields['mac_brand']	= $_POST['mac_brand'];
					$fields['active_status']= $_POST['ACTVE_STATUS'];
				$mac_id = $db->db_insert('machinery',$fields,'mac_id');
				
				unset($fields);
					$fields['temp_datetime']		= date('Y-m-d h:i:s');
					$fields['file_name_default']	= $filename;
					$fields['file_type']			= $arr_file_type;
					$fields['file_name_new']		= $file_name1;
					$fields['temp_user']			= $_SESSION['PER_ID'];
					$fields['temp_user_update']		= $_SESSION['PER_ID'];
					$fields['tab_id']				= $per_id;
					$fields['tab_name']				= 'machinery';
				$db->db_insert('file_uplode',$fields);
				$db->query("UPDATE machinery SET img = '{$file_name1}' WHERE mac_id = '{$mac_id}'");
				break;
    case 'edit':
	
				unset($fields);
					$fields['mac_number']	= $_POST['mac_number'];
					$fields['mac_name']		= $_POST['mac_name'];
					$fields['mac_gen']		= $_POST['mac_gen'];
					$fields['mac_year']		= $_POST['mac_year'];
					// $fields['series_no']	= $_POST['series_no'];
					$fields['com_id']		= $_POST['COM_ID'];
					$fields['dep_id']		= $_POST['DEP_ID'];
					$fields['mac_date']		= $_POST['mac_date'];
					$fields['date_shop']	= $_POST['date_shop'];
					$fields['mac_com_main']	= $_POST['mac_com_main'];
					$fields['mac_comment']	= $_POST['mac_comment'];
					$fields['mac_brand']	= $_POST['mac_brand'];
					$fields['active_status']= $_POST['ACTVE_STATUS'];
				$db->db_update('machinery',$fields,"mac_id = '".$_POST['mac_id']."'");
				
				$db->db_delete('file_uplode',"tab_id = '".$_POST['mac_id']."' and tab_name = 'machinery'");
				unset($fields);
					$fields['temp_datetime']		= date('Y-m-d h:i:s');
					$fields['file_name_default']	= $filename;
					$fields['file_type']			= $arr_file_type;
					$fields['file_name_new']		= $file_name1;
					$fields['temp_user']			= $_SESSION['PER_ID'];
					$fields['temp_user_update']		= $_SESSION['PER_ID'];
					$fields['tab_id']				= $_POST['mac_id'];
					$fields['tab_name']				= 'machinery';
				$db->db_insert('file_uplode',$fields);
				$db->query("UPDATE machinery SET img = '{$file_name1}' WHERE mac_id = '{$_POST['mac_id']}'");
				break;
    case 'del':
				$db->db_delete('machinery',"mac_id = '".$_POST['mac_id']."'");
				break;
	default: echo "Not Process"; break;
}
echo "<script> window.location.href=\"../".$_POST['url_back']."\" </script> ";
?>
