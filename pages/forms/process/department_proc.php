<?php
session_start();
$part = "../../../";
include ($part."include/function.php"); 

switch ($_POST['proc']) {
    case 'add':
        
				unset($fields);
					$fields['dep_name']			= $_POST['dep_name'];
					$fields['active_status']	= $_POST['ACTVE_STATUS'];
				$db->db_insert('department',$fields);
				break;
    case 'edit':
	
				unset($fields);
					$fields['dep_name']			= $_POST['dep_name'];
					$fields['active_status']	= $_POST['ACTVE_STATUS'];
				$db->db_update('department',$fields,"dep_id = '".$_POST['dep_id']."'");
				break;
    case 'del':
				$db->db_delete('department',"dep_id = '".$_POST['dep_id']."'");
				break;
	default: echo "Not Process"; break;
}


if($_POST['proc']=='add' || $_POST['proc']=='edit'){
	echo "<script> window.location.href=\"../".$_POST['url_back']."\" </script> ";
}
?>
