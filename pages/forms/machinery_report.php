<?php
  $Show_Header = 1;
  $part = "../../";
  include ($part."include/include.php"); 
  $page_name = ($_POST['proc']=='add')?'เพิ่มข้อมูล':'แก้ไขข้อมูล';
  
  $sql_main = "SELECT * FROM machinery WHERE mac_id = '".$_POST['mac_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);
  
  $img_view = ($rec_main['img']!='')?'<img class="file-upload-image" style="width: 380px;" src="'.$part.'file_uplode/'.$rec_main['img'].'" alt="your image">':'ไม่พบรูปเครื่องจักร';
  
  $com_arr = get_company('1');
  $dep_arr = get_department('1');
?>
<style>
table, th, td, tr {
  border: 1px solid black;
  border-collapse: collapse;
  padding-top: 10px;
  padding-bottom: 10px;
}
</style>
<h2>Logo Company</h2>
<h2 style="text-align: center;">ประวัติเครื่องจักร หน้าปก</h2>
<table style="width:1000px; align: center; margin:20px;">
	<tr>
		<th colspan="4" width="60%"  style="text-align: center;"><?=$com_arr[$rec_main['com_id']];?></th>
		<td rowspan="9" width="40%" style="text-align: center;"><?=$img_view;?></td>
	</tr>
	<tr>
		<th>ชื่อเครื่องจักร</th>
		<td colspan="3" style="text-align: center;"><?=$rec_main['mac_name'];?></td>
	</tr>
	<tr>
		<th>รหัสเครื่องจักร</th>
		<td colspan="3" style="text-align: center;"><?=$rec_main['mac_number'];?></td>
	</tr>
	<tr>
		<th>สถานที่เครื่องจักร</th>
		<td colspan="3" style="text-align: center;"><?=$com_arr[$rec_main['com_id']].' แผนก '.$dep_arr[$rec_main['dep_id']];?></td>
	</tr>
	<tr>
		<th width="15%">ยี่ห้อ</th>
		<td width="15%"><?=$rec_main['mac_brand'];?></td>
		<th width="10%">รุ่น/แบบ</th>
		<td width="20%"><?=$rec_main['mac_gen'];?></td>
	</tr>
	<tr>
		<th>วันที่ผลิต</th>
		<td><?=$rec_main['mac_date'];?></td>
		<th>วันที่ซื้อ</th>
		<td><?=$rec_main['date_shop'];?></td>
	</tr>
	<tr>
		<th>ผู้ผลิต</th>
		<td><?=$rec_main['mac_com_main'];?></td>
		<th>TEL</th>
		<td></td>
	</tr>
	<tr>
		<th>ที่อยู่</th>
		<td colspan="3" style="text-align: center;"><?=$com_arr[$rec_main['com_id']].' แผนก '.$dep_arr[$rec_main['dep_id']];?></td>
	</tr>
	<tr>
		<th>ข้อกำหนด</th>
		<td colspan="3" style="text-align: center;"><?=$rec_main['mac_comment'];?></td>
	</tr>
</table>
<script>
	var css = '@page { size: landscape; }',
		head = document.head || document.getElementsByTagName('head')[0],
		style = document.createElement('style');

	style.type = 'text/css';
	style.media = 'print';

	if (style.styleSheet){
	style.styleSheet.cssText = css;
	} else {
	style.appendChild(document.createTextNode(css));
	}

	head.appendChild(style);

	window.print(); 
</script>