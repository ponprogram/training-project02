
<?php
session_start();
$part = "../../";
include ($part."include/function.php"); 

switch ($_POST['temp_proc']) {
    case 'add':
        
				foreach($_FILES['file_upload']['name'] as $key=>$val){
					$file_size = $_FILES['file_upload']['size'][$key];
					$file_name = $_FILES['file_upload']['name'][$key];
					$file = $_FILES['file_upload']['tmp_name'][$key];
					$arr_file_type = $_FILES['file_upload']['type'][$key];

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
						//-----Start insert-----//
						unset($fields);
							$fields['temp_datetime']		= date('Y-m-d h:i:s');
							$fields['file_name_default']	= $filename;
							$fields['file_type']			= $arr_file_type;
							$fields['file_name_new']		= $file_name1;
							$fields['temp_user']			= $_SESSION['PER_ID'];
							$fields['temp_user_update']		= $_SESSION['PER_ID'];
							$fields['temp_code']			= $_POST['temp_code'];
							// $fields['tab_id']				= $per_id;
							// $fields['tab_name']				= 'machinery';
						$db->db_insert('file_uplode',$fields);
						//-----End insert-----//
					}
				}
				break;
    case 'edit':
	
				// unset($fields);
					// $fields['dep_name']			= $_POST['dep_name'];
					// $fields['active_status']	= $_POST['ACTVE_STATUS'];
				// $db->db_update('department',$fields,"dep_id = '".$_POST['dep_id']."'");
				break;
    case 'del':
				$db->db_delete('file_uplode',"temp_id = '".$_POST['temp_id']."'");
				break;
	default: echo "Not Process"; break;
}
?>
<script>
	self.location ='../all/uplode_file_form.php?temp_code=<?=$_POST["temp_code"];?>&tab_name=<?=$_POST["tab_name"];?>&tab_id=<?=$_POST["tab_id"];?>';
</script>