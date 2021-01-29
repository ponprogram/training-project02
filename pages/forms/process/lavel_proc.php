<?php
session_start();
$part = "../../../";
include ($part."include/function.php"); 



switch ($_POST['proc']) {
    case 'add':
        
				unset($fields);
					$fields['lavel_name']		= $_POST['lavel_name'];
					$fields['active_status']	= $_POST['ACTVE_STATUS'];
				$db->db_insert('lavel_user',$fields);
				break;
    case 'edit':
	
				unset($fields);
					$fields['lavel_name']		= $_POST['lavel_name'];
					$fields['active_status']	= $_POST['ACTVE_STATUS'];
				$db->db_update('lavel_user',$fields,"lavel_id = '".$_POST['lavel_id']."'");
				break;
	case 'group':
				$sqlcount = "SELECT count(*) as sum FROM manu_set_groub WHERE lavel_id = '".$_POST['lavel_id']."'";
				$querycount = $db->query($sqlcount);
				$reccount = $db->db_fetch_array($querycount);
				if($reccount['sum']>0){
					$db->db_delete('manu_set_groub',"lavel_id = '".$_POST['lavel_id']."'");
				}
				foreach($_POST['add'] as $menu_sub=>$val){
					unset($fields);
					$fields['manu_id']			= $menu_sub;
					$fields['lavel_id']			= $_POST['lavel_id'];
					$fields['add_status']		= $val;
					if($_POST['edit'][$menu_sub]!=''){
						$fields['edit_status']		= $_POST['edit'][$menu_sub];
					}
					if($_POST['del'][$menu_sub]!=''){
						$fields['del_status']		= $_POST['del'][$menu_sub];
					}
					$db->db_insert('manu_set_groub',$fields,'lavel_id');
				}
				break;
    case 'del':
				$db->db_delete('lavel_user',"lavel_id = '".$_POST['lavel_id']."'");
				$db->db_delete('manu_set_groub',"lavel_id = '".$_POST['lavel_id']."'");
				break;
	default: echo "Not Process"; break;
}
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
if($_POST['proc']=='add' || $_POST['proc']=='edit' || $_POST['proc']=='group'){
	echo "<script> window.location.href=\"../".$_POST['url_back']."\" </script> ";
}
?>
