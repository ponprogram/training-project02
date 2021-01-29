<?php
session_start();
$part = "../../../";
include ($part."include/function.php"); 

$com_id = 1;
$n = 0;
$sql = "SELECT
            dep.dep_id,
            dep.dep_name,
            s1.f2
        FROM
            department dep 
        JOIN
            sheet1 s1 ON dep.dep_id = s1.dep_id
        WHERE
            dep.dep_id IN (295,296,297,298,299,300,301,302,303,304)
        GROUP BY
            dep.dep_name,
            s1.f2,
            dep.dep_id";
    $query = $db->query($sql);
    $num = $db->db_num_rows($query);
    if($num>0){
        while($rec = $db->db_fetch_array($query)){
            //insert m_position
            unset($fields);
                $fields['mac_name']			= $rec['f2'];
                $fields['com_id']			= $com_id;
                $fields['dep_id']			= $rec['dep_id'];
                $fields['active_status']	= 1;
            $db->db_insert('machinery',$fields,'mac_id');
            // unset($fields);
            //     $fields['com_id']			= $com_id;
            //     $fields['dep_id']	        = $rec['dep_id'];
            //     $fields['pos_id']	        = $pos_id;
            // $db->db_insert('company_temp',$fields);
            $n++;
        }
    }
    echo 'insert from '.$num.' to '.$n;

// switch ($_POST['proc']) {
//     case 'add':
        
// 				unset($fields);
// 					$fields['pos_name']			= $_POST['pos_name'];
// 					$fields['active_status']	= $_POST['ACTVE_STATUS'];
// 				$db->db_insert('m_position',$fields,'pos_id');
// 				break;
//     case 'edit':
	
// 				unset($fields);
// 					$fields['pos_name']			= $_POST['pos_name'];
// 					$fields['active_status']	= $_POST['ACTVE_STATUS'];
// 				$db->db_update('m_position',$fields,"pos_id = '".$_POST['pos_id']."'");
// 				break;
//     case 'del':
// 				$db->db_delete('m_position',"pos_id = '".$_POST['pos_id']."'");
// 				break;
// 	default: echo "Not Process"; break;
// }
?>
