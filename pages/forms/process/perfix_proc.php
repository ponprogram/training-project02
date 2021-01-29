<?php
session_start();
$part = "../../../";
include ($part."include/function.php"); 

switch ($_POST['proc']) {
    case 'add':
        
				unset($fields);
					$fields['perfix_name_th']			= $_POST['perfix_name_th'];
					$fields['perfix_name_en']			= $_POST['perfix_name_en'];
					$fields['active_status']			= $_POST['ACTVE_STATUS'];
				$db->db_insert('perfix',$fields);
				break;
    case 'edit':
	
				unset($fields);
					$fields['perfix_name_th']			= $_POST['perfix_name_th'];
					$fields['perfix_name_en']			= $_POST['perfix_name_en'];
					$fields['active_status']			= $_POST['ACTVE_STATUS'];
				$db->db_update('perfix',$fields,"perfix_id = '".$_POST['perfix_id']."'");
				break;
    case 'del':
				$db->db_delete('perfix',"perfix_id = '".$_POST['perfix_id']."'");
				break;
	default: echo "Not Process"; break;
}


if($_POST['proc']=='add' || $_POST['proc']=='edit'){
	echo "<script> window.location.href=\"../".$_POST['url_back']."\" </script> ";
}
?>
