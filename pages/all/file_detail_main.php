<?php
	$sql_macimg = "SELECT
						mac_id,img,CONCAT('[',mac_number,'] ',mac_name) AS FullMacName
					FROM
						machinery
					WHERE
						1=1
						AND mac_id = '".$rec_main['mac_id']."'
						AND com_id = '".$rec_main['com_id']."'
						AND dep_id = '".$rec_main['dep_id']."'
					GROUP BY
						mac_id,
						mac_number,
						mac_name,
						img
					ORDER BY
						mac_number,mac_name ASC
				";
	$query_macimg = $db->query($sql_macimg);
	$rec_macimg = $db->db_fetch_array($query_macimg);
?>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                <label class="col-sm-3 col-form-label" align="right">สถานที่ : </label>
                <div class="col-sm-9"><?=$com_arr[$rec_main['com_id']];?></div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="right">พื้นที่ : </label>
            <div class="col-sm-9"><?=$dep_arr[$rec_main['dep_id']];?></div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" align="right">รหัสเครื่องจักร : </label>
                <div class="col-sm-9"><?=$dep_machinery[$rec_main['mac_id']];?></div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="right">อาการ : </label>
            <div class="col-sm-9"><?=$rec_main['mai_detail'];?></div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" align="right" style=" vertical-align: middle;">ระดับความรุนแรง : </label>
                    <div class="col-sm-3"> <?=get_severityimg($rec_main['severity']).' '.$arr_severity[$rec_main['severity']];?></div> 
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="col-sm-12 col-form-label" align="center"><h1>รูปเครื่องจักร </h1></label>
        <div class="col-md-12" align="center">
            <img id="img_show" src="../../file_uplode/<?php echo ($rec_macimg['img']!='')?$rec_macimg['img']:'no-image.a4eb045.jpg';?>" width="500">
        </div>
    </div>
</div>