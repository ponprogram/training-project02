<?php
session_start();
$part = "../../../";
include ($part."include/function.php"); 

switch ($_POST['proc']) {
    case 'add':
        
				unset($fields);
					$fields['pos_name']			= $_POST['pos_name'];
					$fields['active_status']	= $_POST['ACTVE_STATUS'];
				$db->db_insert('m_position',$fields,'pos_id');
				break;
    case 'edit':
	
				unset($fields);
					$fields['pos_name']			= $_POST['pos_name'];
					$fields['active_status']	= $_POST['ACTVE_STATUS'];
				$db->db_update('m_position',$fields,"pos_id = '".$_POST['pos_id']."'");
				break;
    case 'del':
				$db->db_delete('m_position',"pos_id = '".$_POST['pos_id']."'");
				break;
	default: echo "Not Process"; break;
}


if($_POST['proc']=='add' || $_POST['proc']=='edit'){
	echo "<script> window.location.href=\"../".$_POST['url_back']."\" </script> ";
}
?>
