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

// echo 'file_type1 =>'.$file_type1.'<br> filename=>'.$filename.'<br> $file_name1=>'.$file_name1;

switch ($_POST['proc']) {
    case 'add':
		
				unset($fields);
					$fields['perfix_id']	= $_POST['perfix_id'];
					$fields['f_name']		= $_POST['Fname'];
					$fields['l_name']		= $_POST['Lname'];
					$fields['address']		= $_POST['address'];
					$fields['phone_number']	= $_POST['phone_number'];
					$fields['email']		= $_POST['email'];
					$fields['com_id']		= $_POST['COM_ID'];
					$fields['dep_id']		= $_POST['DEP_ID'];
					$fields['pos_id']		= $_POST['POS_ID'];
					$fields['per_lavel']	= $_POST['per_lavel'];
					$fields['active_status']= $_POST['ACTVE_STATUS'];
					$fields['username']		= $_POST['username'];
					$fields['password']		= base64_encode($_POST['password']);
				$per_id = $db->db_insert('profile',$fields,'per_id');
				
				unset($fields);
					$fields['temp_datetime']		= date('Y-m-d h:i:s');
					$fields['file_name_default']	= $filename;
					$fields['file_type']			= $arr_file_type;
					$fields['file_name_new']		= $file_name1;
					$fields['temp_user']			= $_SESSION['PER_ID'];
					$fields['temp_user_update']		= $_SESSION['PER_ID'];
					$fields['tab_id']				= $per_id;
					$fields['tab_name']				= 'profile';
				$db->db_insert('file_uplode',$fields);
				$db->query("UPDATE profile SET img = '{$file_name1}' WHERE per_id = '{$per_id}'");
				break;
    case 'edit':
				unset($fields);
					$fields['perfix_id']	= $_POST['perfix_id'];
					$fields['f_name']		= $_POST['Fname'];
					$fields['l_name']		= $_POST['Lname'];
					$fields['address']		= $_POST['address'];
					$fields['phone_number']	= $_POST['phone_number'];
					$fields['email']		= $_POST['email'];
					$fields['com_id']		= $_POST['COM_ID'];
					$fields['dep_id']		= $_POST['DEP_ID'];
					$fields['pos_id']		= $_POST['POS_ID'];
					$fields['per_lavel']	= $_POST['per_lavel'];
					$fields['active_status']= $_POST['ACTVE_STATUS'];
					$fields['username']		= $_POST['username'];
					$fields['password']		= base64_encode($_POST['password']);
				$db->db_update('profile',$fields,"per_id = '".$_POST['per_id']."'");
				if($file_size > 0){
					$db->db_delete('file_uplode',"tab_id = '".$_POST['per_id']."' and tab_name = 'profile'");
					unset($fields);
						$fields['temp_datetime']		= date('Y-m-d h:i:s');
						$fields['file_name_default']	= $filename;
						$fields['file_type']			= $arr_file_type;
						$fields['file_name_new']		= $file_name1;
						$fields['temp_user']			= $_SESSION['PER_ID'];
						$fields['temp_user_update']		= $_SESSION['PER_ID'];
						$fields['tab_id']				= $_POST['per_id'];
						$fields['tab_name']				= 'profile';
					$db->db_insert('file_uplode',$fields);
					$db->query("UPDATE profile SET img = '{$file_name1}' WHERE per_id = '{$_POST['per_id']}'");
				}
				break;
    case 'editmain':
				unset($fields);
					$fields['perfix_id']	= $_POST['perfix_id'];
					$fields['f_name']		= $_POST['Fname'];
					$fields['l_name']		= $_POST['Lname'];
					$fields['phone_number']	= $_POST['phone_number'];
					$fields['email']		= $_POST['email'];
					$fields['username']		= $_POST['username'];
					$fields['password']		= base64_encode($_POST['password']);
				$db->db_update('profile',$fields,"per_id = '".$_POST['per_id']."'");

				if($file_size > 0){
					$db->db_delete('file_uplode',"tab_id = '".$_POST['per_id']."' and tab_name = 'profile'");
					unset($fields);
						$fields['temp_datetime']		= date('Y-m-d h:i:s');
						$fields['file_name_default']	= $filename;
						$fields['file_type']			= $arr_file_type;
						$fields['file_name_new']		= $file_name1;
						$fields['temp_user']			= $_SESSION['PER_ID'];
						$fields['temp_user_update']		= $_SESSION['PER_ID'];
						$fields['tab_id']				= $_POST['per_id'];
						$fields['tab_name']				= 'profile';
					$db->db_insert('file_uplode',$fields);
					$db->query("UPDATE profile SET img = '{$file_name1}' WHERE per_id = '{$_POST['per_id']}'");
				}
				break;
    case 'del':
				$db->db_delete('profile',"per_id = '".$_POST['per_id']."'");
				break;
	default: echo "Not Process"; break;
}
echo "<script> window.location.href=\"../".$_POST['url_back']."\" </script> ";
?>
