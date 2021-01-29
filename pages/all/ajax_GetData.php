<?php
// error_reporting(E_ALL & ~E_NOTICE);
$part = "../../";
include ($part."include/function.php"); 
// header('Content-Type: application/json');

if($_POST['PROC']=='GET_MACHINERY_IMG'){
	$DEPARTMENT = $_POST['E_DEP'];
	$COMPANY 	= $_POST['COM_ID'];
	$MAC_ID 	= $_POST['MAC_ID'];
	
	$sql_mac = "SELECT
						mac_id,img,CONCAT('[',mac_number,'] ',mac_name) AS FullMacName
					FROM
						machinery
					WHERE
						1=1
						AND mac_id = '".$MAC_ID."'
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
    $rec_mac = $db->db_fetch_array($query_mac);
    if(!empty($rec_mac['img'])){
        echo $rec_mac['img'];
    }else{
        echo "no-image.a4eb045.jpg";
    }
}	
?>