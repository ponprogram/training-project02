<?php
	$sql_macform = "SELECT
                        frm_id,
                        per_id,
                        frm_date,
                        frm_detail,
                        limid_date,
                        frm_status,
                        frm_remarks,
                        mai_id 
                    FROM
                        maintenance_from 
                    WHERE
                        mai_id = '".$_POST['mai_id']."'
					GROUP BY
                        per_id,
                        frm_date,
                        frm_detail,
                        limid_date,
                        frm_status,
                        frm_remarks,
                        frm_id,
                        mai_id 
					ORDER BY
                        frm_id ASC
				";
	$query_macform = $db->query($sql_macform);
?>
<style>
    th{
        text-align: center;
    }
</style>
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="table-info">
                    <th> ลำดับ </th>
                    <th> ชื่อ-สกุล </th>
                    <th> วันที่บันทึก </th>
                    <th> รายละเอียดตามช่าง </th>
                    <th> ระยะเวลาดำเนินงาน </th>
                    <th> สถานะ </th>
                    <th> หมายเหตุ </th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $n = 1;
                while($rec_macform = $db->db_fetch_array($query_macform)){

                    if($rec_macform['frm_status']=='Y'){
                        $frm_status = "ดำเนินการเสร็จสิ้น";
                    }else if($rec_macform['frm_status']=='B'){
                        $frm_status = "ดำเนินการไม่สำเร็จ";
                    }else{
                        $frm_status = "อยู่ระหว่างดำเนินการ";
                    }  ?>
                    <tr>
                        <td align="center"><?=$n;?></td>
                        <td><?= $per_arr[$rec_macform['per_id']];?></td>
                        <td align="center"><?=conv_date($rec_macform['frm_date']);?></td>
                        <td><?=$rec_macform['frm_detail'];?></td>
                        <td align="center"><?=$rec_macform['limid_date'].' วัน';?></td>
                        <td align="center"><?=$frm_status;?></td>
                        <td align="center"><?=$rec_macform['frm_remarks'];?></td>
                    </tr>
                <?php
                    $n++;
                }
                ?>
            </tbody>
        </table>
    </div>