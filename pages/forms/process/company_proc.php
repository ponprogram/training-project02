<?php
session_start();
$part = "../../../";
include ($part."include/function.php"); 

switch ($_POST['proc']) {
    case 'add':
        
				unset($fields);
					$fields['com_name']			= $_POST['com_name'];
					$fields['com_name_short']	= $_POST['com_name_short'];
					$fields['address']			= $_POST['address'];
					$fields['phone_number']		= $_POST['phone_number'];
					$fields['active_status']	= $_POST['ACTVE_STATUS'];
				$com_id = $db->db_insert('company',$fields,'com_id');
				foreach($_POST['DEP_ID'] as $key=>$DEP_ID){
					unset($fields1);
						$fields1['com_id']		= $com_id;
						$fields1['dep_id']		= $DEP_ID;
						$fields1['pos_id']		= $_POST['POS_ID'][$key];
					$db->db_insert('company_temp',$fields1);
				}
				break;
    case 'edit':
	
				unset($fields);
					$fields['com_name']			= $_POST['com_name'];
					$fields['com_name_short']	= $_POST['com_name_short'];
					$fields['address']			= $_POST['address'];
					$fields['phone_number']		= $_POST['phone_number'];
					$fields['active_status']	= $_POST['ACTVE_STATUS'];
				$db->db_update('company',$fields,"com_id = '".$_POST['com_id']."'");
				
				$db->db_delete('company_temp',"com_id = '".$_POST['com_id']."'");
				foreach($_POST['DEP_ID'] as $key=>$DEP_ID){
					unset($fields1);
						$fields1['com_id']		= $_POST['com_id'];
						$fields1['dep_id']		= $DEP_ID;
						$fields1['pos_id']		= $_POST['POS_ID'][$key];
					$db->db_insert('company_temp',$fields1);
				}
				break;
    case 'del':
				$db->db_delete('company',"com_id = '".$_POST['com_id']."'");
				$db->db_delete('company_temp',"com_id = '".$_POST['com_id']."'");
				break;
	default: echo "Not Process"; break;
}


if($_POST['proc']=='add' || $_POST['proc']=='edit'){
	echo "<script> window.location.href=\"../".$_POST['url_back']."\" </script> ";
}
?>
