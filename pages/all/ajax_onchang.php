<?php
error_reporting(E_ALL & ~E_NOTICE);
$part = "../../";
include ($part."include/function.php"); 
header('Content-Type: application/json');

if($_POST['PROC']=='DEP'){
	$COMPANY = $_POST['COM_ID'];
	$array_a = array();
	$sql_dep = "	SELECT
						ct.dep_id,
						dep.dep_name
					FROM
						company_temp ct
					INNER JOIN
						department dep ON dep.dep_id = ct.dep_id
					WHERE
						ct.com_id = '".$COMPANY."'
						AND dep.active_status = '1'
					GROUP BY
						ct.dep_id,
						dep.dep_name
					ORDER BY
						dep.dep_name ASC
				";
	$query_dep = $db->query($sql_dep);
	$i=0;
	while($rec_dep = $db->db_fetch_array($query_dep)){
		$array_a[$i]["id"] = $rec_dep["dep_id"]; 
		$array_a[$i]["text"] = $rec_dep["dep_name"]; 
		if($FR_NAME==$rec_dep["dep_id"]){
			$array_a[$i]["selected"] = "selected";
		}
		$i++;
	}
}
if($_POST['PROC']=='POS'){
	$DEPARTMENT = $_POST['E_DEP'];
	$COMPANY 	= $_POST['COM_ID'];
	$array_a 	= array();
		$sql_pos = "SELECT
						ct.pos_id,
						pos.pos_name
					FROM
						company_temp ct
					INNER JOIN
						m_position pos ON pos.pos_id = ct.pos_id
					WHERE
						ct.dep_id ='".$DEPARTMENT."'
						AND ct.com_id = '".$COMPANY."'
						AND pos.active_status = '1'
					GROUP BY
						ct.pos_id,
						pos.pos_name
					ORDER BY
						pos.pos_name ASC
				";
	$query_pos = $db->query($sql_pos);
	$i=0;
	while($rec_pos = $db->db_fetch_array($query_pos)){
		$array_a[$i]["id"] = $rec_pos["pos_id"]; 
		$array_a[$i]["text"] = $rec_pos["pos_name"]; 
		if($FR_NAME==$rec_pos["pos_id"]){
			$array_a[$i]["selected"] = "selected";
		}
		$i++;
	}
}
if($_POST['PROC']=='GET_MACHINERY'){
	$DEPARTMENT = $_POST['E_DEP'];
	$COMPANY 	= $_POST['COM_ID'];
	$array_a 	= array();
		$sql_mac = "SELECT
						mac_id,img,
						(CASE
								WHEN mac_number IS NULL THEN
									mac_name
								ELSE
									CONCAT('[',mac_number,'] ',mac_name)
							END) AS FullMacName
					FROM
						machinery
					WHERE
						1=1
						AND com_id = '".$COMPANY."'
						AND dep_id = '".$DEPARTMENT."'
					GROUP BY
						mac_id,
						mac_number,
						mac_name,
						img
					ORDER BY
						mac_number,mac_name ASC
				";
	$query_mac = $db->query($sql_mac);
	$i=0;
	while($rec_pos = $db->db_fetch_array($query_mac)){
		$array_a[$i]["id"] = $rec_pos["mac_id"]; 
		$array_a[$i]["text"] = $rec_pos["FullMacName"]; 
		if($FR_NAME==$rec_pos["mac_id"]){
			$array_a[$i]["selected"] = "selected";
		}
		$i++;
	}
}
echo json_encode($array_a); 	
?>