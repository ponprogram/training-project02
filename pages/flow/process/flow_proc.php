<?php
session_start();
$part = "../../../";
include ($part."include/function.php"); 

// if($_POST['mai_id']!=''){
//     $sql_num = "SELECT step_flow FROM maintenance WHERE mai_id = '".$_POST['mai_id']."'";
//     $query_num = $db->query($sql_num);
//     $rec_num = $db->db_fetch_array($query_num);
// }


// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit;
switch ($_POST['proc']) {
    case 'add':
				$sql_mac = "SELECT
									mac_number
								FROM
									machinery
								WHERE
									mac_id = '".$_POST['MAC_ID']."'
							";
				$query_mac = $db->query($sql_mac);
				$rec_mac = $db->db_fetch_array($query_mac);
				
				unset($fields);
					$fields['mai_date']		= date('Y-m-d');
					$fields['com_id']		= $_POST['COM_ID'];
					$fields['dep_id']		= $_POST['DEP_ID'];
					$fields['mac_id']		= $_POST['MAC_ID'];
					$fields['mac_number']	= $rec_mac['mac_number'];
					$fields['mai_detail']	= $_POST['DETAIL'];
					$fields['severity']		= $_POST['severity'];
					$fields['user_id']		= $_SESSION['PER_ID'];
					$fields['mai_year']		= date('Y')+543;
                    $fields['mai_type']		= $_POST['flow_type'];

                    if($_POST['next_step']=='Y'){ //บันทึกและส่ง
                        $fields['step_flow']	= 2;
                        $fields['mai_run']		= Maxrun($_POST['flow_type']);
                        $fields['mai_number']	= RunFlowNumber($_POST['flow_type']);
                    }else{ //บันทึก
                        $fields['step_flow']	= 1;
                    }
					
				$mai_id = $db->db_insert('maintenance',$fields,'mai_id');

				unset($fields);
					$fields['temp_code']		= '';
					$fields['temp_user_update']	= $_SESSION['PER_ID'];
					$fields['tab_id']			= $mai_id;
					$fields['tab_name']			= 'maintenance';
				$db->db_update('file_uplode',$fields,"temp_code = '".$_POST['temp_code']."'");

				break;
    case 'edit':
	
				$sql_mac = "SELECT
									mac_number
								FROM
									machinery
								WHERE
									mac_id = '".$_POST['MAC_ID']."'
							";
				$query_mac = $db->query($sql_mac);
				$rec_mac = $db->db_fetch_array($query_mac);
				
				unset($fields);
					$fields['mai_date']		= date('Y-m-d');
					$fields['com_id']		= $_POST['COM_ID'];
					$fields['dep_id']		= $_POST['DEP_ID'];
					$fields['mac_id']		= $_POST['MAC_ID'];
					$fields['mac_number']	= $rec_mac['mac_number'];
					$fields['severity']		= $_POST['severity'];
					$fields['mai_detail']	= $_POST['DETAIL'];
                    $fields['user_id']		= $_SESSION['PER_ID'];

                    if($_POST['next_step']=='Y'){ //บันทึกและส่ง
                        $fields['step_flow']	= 2;
                        $fields['mai_run']		= Maxrun($_POST['flow_type']);
                        $fields['mai_number']	= RunFlowNumber($_POST['flow_type']);
                    }else{ //บันทึก
                        $fields['step_flow']	= 1;
                    }

				$db->db_update('maintenance',$fields,"mai_id = '".$_POST['mai_id']."'");
				
				unset($fields);
					$fields['temp_code']		= '';
					$fields['temp_user_update']	= $_SESSION['PER_ID'];
					$fields['tab_id']			= $_POST['mai_id'];
					$fields['tab_name']			= 'maintenance';
				$db->db_update('file_uplode',$fields,"temp_code = '".$_POST['temp_code']."'");

				break;
    case 'next_step':
                    $sql_mac = "SELECT
                            mai_number,mai_type
                        FROM
                            maintenance
                        WHERE
                            mai_id = '".$_POST['mai_id']."'
                    ";
                    $query_mac = $db->query($sql_mac);
                    $rec_mac = $db->db_fetch_array($query_mac);
                    unset($fields);
                        $fields['step_flow']	= 2;
                        if($rec_mac['mai_number']==''){
                            $fields['mai_run']		= Maxrun($rec_mac['mai_type']);
                            $fields['mai_number']	= RunFlowNumber($rec_mac['mai_type']);
                        }
                    $db->db_update('maintenance',$fields,"mai_id = '".$_POST['mai_id']."'");
                  
				break;
    case 'return_step':
                    unset($fields);
                        $fields['step_flow']	= 1;
                    $db->db_update('maintenance',$fields,"mai_id = '".$_POST['mai_id']."'");
				break;
	case 'assign':
                unset($fields);
                    $fields['frm_date']		= date('Y-m-d');
                    $fields['mai_id']		= $_POST['mai_id'];
                    $fields['per_id']		= $_POST['per_id'];
                    $fields['limid_date']	= $_POST['limid_date'];
                    $fields['user_id']		= $_SESSION['PER_ID'];
                    $fields['frm_status']	= "N";
                $db->db_insert('maintenance_from',$fields,'frm_id');

                unset($fields);
                    $fields['step_flow']	= 3;
                $db->db_update('maintenance',$fields,"mai_id = '".$_POST['mai_id']."'"); 
				break;
	case 'reply':
				
				unset($fields);
					$fields['frm_detail']		= $_POST['DETAIL'];
					$fields['frm_hour']			= $_POST['hour_work'];
					$fields['frm_type']			= $_POST['detail_type'];
				$db->db_update('maintenance_from',$fields,"frm_id = '".$_POST['frm_id']."'");

				$db->db_delete('equipment_temp',"mai_id = '".$_POST['mai_id']."'");
				foreach($_POST['equ_id'] as $key=>$val){
					unset($fields);
						$fields['equ_id']		= $val;
						$fields['mai_id']		= $_POST['mai_id'];
						$fields['equ_sum']		= $_POST['equ_sum'][$key];
					$db->db_insert('equipment_temp',$fields,'temp_id');
				}
				if($_POST['next_step']=='Y'){
					unset($fields);
						$fields['step_flow']	= 4;
					$db->db_update('maintenance',$fields,"mai_id = '".$_POST['mai_id']."'");
				}
				break;
	case 'approve':
				if($_POST['approve_status']=='Y'){
					unset($fields);
						$fields['step_flow']	= 5;
					$db->db_update('maintenance',$fields,"mai_id = '".$_POST['mai_id']."'");
				}else if($_POST['approve_status']=='B'){
					unset($fields);
						$fields['step_flow']	= 2;
					$db->db_update('maintenance',$fields,"mai_id = '".$_POST['mai_id']."'");
				}
				unset($fields);
					$fields['frm_status']			= $_POST['approve_status'];
					$fields['frm_remarks']			= $_POST['remarks'];
				$db->db_update('maintenance_from',$fields,"frm_id = '".$_POST['frm_id']."'");

				break;
	case 'Endjob':
				if($_POST['approve_status']=='Y'){
					unset($fields);
						$fields['step_flow']	= 0;
					$db->db_update('maintenance',$fields,"mai_id = '".$_POST['mai_id']."'");
				}else if($_POST['approve_status']=='B'){
					unset($fields);
						$fields['step_flow']	= 2;
					$db->db_update('maintenance',$fields,"mai_id = '".$_POST['mai_id']."'");
				}
				break;
    case 'del':
				$db->db_delete('maintenance',"mai_id = '".$_POST['mai_id']."'");
				break;
	default: echo "Not Process"; break;
}
echo "<script> window.location.href=\"../".$_POST['url_back']."\" </script> ";
?>
