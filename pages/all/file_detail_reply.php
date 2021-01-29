<?php
	$sql_frm = "SELECT * FROM maintenance_from WHERE frm_id = '".$_POST['frm_id']."'";
	$query_frm = $db->query($sql_frm);
    $rec_frm = $db->db_fetch_array($query_frm);

    $sql_tempr = "SELECT temp_id,equ_id,mai_id,equ_sum FROM equipment_temp WHERE mai_id = '".$_POST['mai_id']."'";
    $query_tempr = $db->query($sql_tempr);
    
    $equarr = array();

    $sqlequ = "SELECT equ_id,equ_name FROM equipment GROUP BY equ_id,equ_name";
    $queryequ = $db->query($sqlequ);
    while($recequ = $db->db_fetch_array($queryequ)){
        $equarr[trim($recequ['equ_id'])] = $recequ['equ_name'];
    }

    $arr_detail_type1 = array(''=>'','1'=>'อายุการใช้งาน','2'=>'การใช้งานผิดลักษณะ','3'=>'ดัดแปลงอุปกรณ์');
?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" style="text-align:right">อาการตามจริง : </label>
            <div class="col-sm-8"><?php echo $rec_frm['frm_detail'];?></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" style="text-align:right">ระยะเวลาการดำเนินการ : </label>
            <div class="col-sm-4" style="text-align:left;"><?php echo $rec_frm['frm_hour'];?> ชั่วโมง</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group row"> 
            <label class="col-sm-2 col-form-label" style="text-align:right" style=" vertical-align: middle;">ลักษณะอาการ : </label>
            <div class="col-sm-3"><?php echo  $arr_detail_type1[$rec_frm['frm_type']];?></div> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" style="text-align:right">อะไหลที่ใช้ : </label>
            <div class="col-sm-8">
                <table class="table .table-hover table-bordered" id="equ_temp_id">
                    <thead>
                        <tr class="table-info">
                            <th width='10%' style="text-align: center;">ลำดับ</th>
                            <th width='60%' style="text-align: center;">ชื่ออะไหล</th>
                            <th width='20%' style="text-align: center;">จำนวน</th>
                        </tr>               
                    <tbody>
                    <?php
                        $i=0;
                        $num_tempr = $db->db_num_rows($query_tempr);
                        if($num_tempr>0){
                            $i=1;
                            while($rec_tempr = $db->db_fetch_array($query_tempr)){ ?>
                                <tr id="tr_<?=$i;?>" on-count="<?=$i;?>">
                                    <td style="text-align: center;"><?=$i;?></td>
                                    <td style="text-align: center;"><?php echo $equarr[$rec_tempr['equ_id']];?></td>
                                    <td style="text-align: center;"><?php echo $rec_tempr['equ_sum']?></td>
                                </tr>
                    <?php
                            $i++;
                            }
                        }else{
                    ?>
                        <tr id="notdata">
                            <td style="text-align: center;" colspan="3">ไม่พบข้อมูล</td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
                <input type="hidden" id="equ_on" name="equ_on" value="<?=$i;?>">
            </div>
        </div>
    </div>
</div>