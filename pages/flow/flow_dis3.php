<?php 
	$part = "../../";
	include ($part."include/include.php"); 
	//manu header
	if($_GET['step_flow']!=''){
		$ManuSub = " <i class=\"mdi mdi-hand-pointing-right icon-lg\"></i> ".$arr_manu_sub[$_GET['step_flow']]."";
	}
	$ManuHeader = "<i class=\"mdi mdi-settings icon-lg\"></i> ".$arr_manu_main[$_GET['form_folw']].$ManuSub;
	//manu header
	$Link = "?step_flow=".$_GET['step_flow']."&form_folw=".$_GET['form_folw'].'&manu_sub_id='.$_GET['manu_sub_id'];
	
	$active_name = array('2'=>'ไม่ใช้งาน','1'=>'ใช้งาน');
	$com_arr = get_company('1');
	$dep_arr = get_department('1');
	$pos_arr = get_position('1');
	$per_arr = get_per('1');
	$S_NAME         = (isset($_POST['S_NAME'])!='')?$_POST['S_NAME']:'';
	$S_COM_ID       = (isset($_POST['S_COM_ID'])!='')?$_POST['S_COM_ID']:'';
	$S_FLOW_STATUS  = (isset($_POST['S_FLOW_STATUS'])!='')?$_POST['S_FLOW_STATUS']:'';
	
	$wh_filde = "";
	if($S_NAME!=''){
		$wh_filde .= " AND mac.mac_number LIKE '%{$S_NAME}%' OR mac.mac_name LIKE '%{$S_NAME}%'";
	}
	if($S_COM_ID!=''){
		$wh_filde .= " AND mai.com_id = '{$S_COM_ID}'";
	}
	if($S_FLOW_STATUS!=''){
		$wh_filde .= " AND IFNULL(mai.flow_status,'N') = '{$S_FLOW_STATUS}'";
	}else{
		$wh_filde .= " AND IFNULL(mai.flow_status,'N') = 'N'";
    }
    if($_SESSION['PER_LAVEL']!=1){
        if($_SESSION['PER_LAVEL']==5){
            $wh_filde .= " AND mai.com_id = '{$_SESSION['COM_ID']}'";
        }else{
            $wh_filde .= " AND mai.user_id = '{$_SESSION['PER_ID']}'";
        }   
    }


	// แบ่งหน้า
	$page_arr = array(20,50,100,200);
	$e_page   = (isset($_POST['e_page'])!='')?$_POST['e_page']:20; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
	$step_num=0;
	if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page']==1)){   
		$_GET['page']=1;   
		$step_num=0;
		$s_page = 0;    
	}else{   
		$s_page = $_GET['page']-1;
		$step_num=$_GET['page']-1;  
		$s_page = $s_page*$e_page;
	}
	
	$sql = "SELECT
				mai.mai_id,
				mai.severity,
				mai.mai_date,
				mai.mai_detail,
				mai.user_id,
				mai.step_flow,
				mai.mai_number,
				(CASE
            WHEN mac.mac_number IS NULL THEN
              mac.mac_name
            ELSE
                CONCAT('[',mac.mac_number,'] ',mac.mac_name)
        END) AS mac_name,
				mac.mac_number,
				com.com_name,
				com.com_name_short,
				dep.dep_name 
			FROM 
				maintenance mai
				INNER JOIN machinery mac ON mac.mac_id = mai.mac_id
				LEFT JOIN company com ON com.com_id = mai.com_id
				LEFT JOIN department dep ON dep.dep_id = mai.dep_id 
			WHERE
				1 = 1
                AND mai.step_flow = 0 {$wh_filde}";
	$total = $db->db_num_rows($db->query($sql));
	$sql .= "LIMIT ".$s_page.",$e_page";
	$query = $db->query($sql);

    
?>       
<!-- partial -->
<style>
    body {
    margin-top: 80px;
    font-family: "Varela Round", sans-serif;
    }
    .container {
    max-width: 960px;
    width: 100%;
    margin: 0 auto;
    }

    h1 {
    text-align: center;
    }

    .tabs {
    list-style: none;
    margin: 0;
    padding: 0;
    }

    .tabs li {
    display: inline-block;
    padding: 15px 25px;
    background: none;
    text-transform: uppercase;
    cursor: pointer;
    }

    .tabs li.current {
    background: #e9e9e9;
    }

    .tab-contents {
    background: #e9e9e9;
    padding: 20px;
    }

    .tab-pane {
    display: none;
    }

    .tab-pane.current {
    display: block;
    }
</style>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h1><?=$ManuHeader;?></h1>
    </div>
    <div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<form id="frm-search" action="" method="post">
					  <input type="hidden" id="proc" name="proc" value="">
					  <input type="hidden" id="mai_id" name="mai_id" value="">
					  <input type="hidden" id="url_back" name="url_back" value="flow_dis3.php<?=$Link;?>">
					  <input type="hidden" id="manu_sub_id" name="manu_sub_id" value="<?php echo $_GET['manu_sub_id'];?>">
					  <div class="row">
						  <h1 class=""><i class="mdi mdi-magnify"></i> ค้นหา</h1>
					  </div>
					  <div class="row">
						<div class="col-sm-12 col-md-12">
						  <div class="form-group row" align="right">
							<label class="col-sm-2 col-md-2 col-form-label">ชื่อเครื่องจักร : </label>
							<div class="col-sm-10 col-md-10">
							  <input type="text" class="form-control ClearData" id="S_NAME" name="S_NAME" value="<?=$S_NAME;?>">
							</div>
						  </div>
						</div>
					  </div>
					  <div class="row">
						<div class="col-sm-12 col-md-6">
						  <div class="form-group row" >
							<div class="col-sm-4 col-md-4" align="right">
								<label class="col-form-label">บริษัท :</label>
							</div>
							<div class="col-sm-6 col-md-6">
								<select class="form-control select2 ClearData" id="S_COM_ID" name="S_COM_ID">
									<option value="">---ทั้งหมด---</option>
									<?php
									foreach($com_arr as $key_com=>$val_com){ ?>
									  <option value="<?=$key_com;?>" <?=($key_com==$S_COM_ID)?'selected':'';?>><?=$val_com?></option>
									<?php
									}
									?>
								</select>
							</div>
						  </div>
						</div>
						<div class="col-sm-12 col-md-6">
						  <div class="form-group row">
							<div class="col-sm-4 col-md-4" align="right">
								<label class="col-form-label">สถานะดำเนินการ : </label>
							</div>
							<div class="col-sm-4 col-md-6">
								<select class="form-control select2 ClearData" id="S_FLOW_STATUS" name="S_FLOW_STATUS">
									<option value="N" <?=($S_FLOW_STATUS=='N' || $S_FLOW_STATUS=='')?'selected':'';?>>อยู่ระหว่างดำเนินการ</option>
									<option value="Y" <?=($S_FLOW_STATUS=='Y')?'selected':'';?>>ดำเนินการเสร็จสิ้น</option>
								</select>
							</div>
						  </div>
						</div>
					  </div>
					  <div class="row">
						<div class="col-sm-12 col-md-12" align="center">
						  <button type="button" class="btn btn-social-icon-text btn-twitter" style="margin-bottom:5px;" onClick="stretchData();"><i class="mdi mdi-magnify"></i> ค้นหา</button>
						  <button type="button" class="btn btn-social-icon-text btn-youtube" style="margin-bottom:5px;" onclick="ClearData('<?=$_SERVER['PHP_SELF'].$Link;?>');"><i class="mdi mdi-reload btn-icon-prepend"></i>ยกเลิก</button>
						</div>
					  </div>
					</form>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="<?=$part;?>pages/flow/flow_dis.php<?=$Link;?>">รอดำเนินการ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=$part;?>pages/flow/flow_dis2.php<?=$Link;?>">ระหว่างดำเนินการ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?=$part;?>pages/flow/flow_dis3.php<?=$Link;?>">ปิดงาน</a>
                            </li>
                        </ul>
                        <br>
                        <div style="overflow-x:auto;">
                            <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align: center;"> ลำดับ </th>
                                    <th width="10%" style="text-align: center;"> เลขที่คำขอ </th>
                                    <th width="10%" style="text-align: center;"> ระดับความรุนแรง </th>
                                    <th width="10%" style="text-align: center;"> วันที่บันทึก </th>
                                    <th width="20%" style="text-align: center;"> ชื่อเครื่องจักร </th>
                                    <th width="10%" style="text-align: center;"> บริษัท </th>
                                    <th width="20%" style="text-align: center;"> อาการ </th>
                                    <th width="10%" style="text-align: center;"> ขั้นตอน 1-6 </th> 
                                    <th width="10%" style="text-align: center;"> จัดการ </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($db->db_num_rows($query)){
                                $del='';
                                $no = $s_page+1;
                                $edit='';
                                $del='';
                                $next_step='';
                                $detail='';
                                $end_job='';
                                while($rec = $db->db_fetch_array($query)){
                                    if($rec['mai_number']!=''){
                                        $mai_number = $rec['mai_number'];
                                    }else{
                                        $mai_number = 'ไม่มีเลขที่เอกสาร';
                                    }
                                    if($_SESSION['PER_LAVEL']==1){
                                        $del ="<button type=\"button\" class=\"btn btn-outline-danger btn-sm\" onClick=\"delData('".$rec['mai_id']."');\"><span class=\"mdi mdi-delete\"></span>ลบ</button>";
                                    }
                                    $detail ="<button type=\"button\" class=\"btn btn-outline-success btn-sm\" onClick=\"DetailData('".$rec['mai_id']."');\"><span class=\"mdi mdi-file-document\"></span>รายละเอียด</button>";
                                   
                                ?>
                                <tr id="tr_<?=$rec['mai_id'];?>">
                                    <td style="text-align: center;"><?=$no;?></td>
                                    <td style="text-align: center;"><?=$mai_number;?></td>
                                    <td style="text-align: center; background-color: #D2CCCC;"><?=get_severityimg($rec['severity']);?></td>
                                    <td style="text-align: center;"><?=conv_date($rec['mai_date']);?></td>
                                    <td style="text-align: left;"><?=$rec['mac_name'];?></td>
                                    <td style="text-align: left;"><?=$rec["com_name_short"];?></td>
                                    <td style="text-align: left;"><?=$rec['mai_detail'];?></td>
                                    <td style="text-align: center;"><?=get_step_flow($rec["step_flow"],$rec['mai_id']);?></td>
                                    <td style="text-align: center;"><?=$edit.' '.$end_job.' '.$next_step.' '.$detail.' '.$del;?></td>
                                </tr>
                                <?php
                                    $no++;
                                    $edit='';
                                    $del='';
                                    $next_step='';
                                    $detail='';
                                    $end_job='';
                                }
                                }else{
                                ?>
                                <tr>
                                <td style="text-align: center;" colspan="9">ไม่พบข้อมูล</td>
                                <tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            </table>
                        </div>
                        <?php
                            page_navi($total,(isset($_GET['page']))?$_GET['page']:1,$e_page);
                        ?>
                        <hr>
                        <div class="col-md-12" style="background-color: #D2CCCC;">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" align="right" style=" vertical-align: middle;">ระดับความรุนแรง : </label>
                                <div class="col-sm-9" style="vertical-align: middle; padding: 10px;">
                                        <i style="font-size:20px; color: #000000;" class="mdi mdi-security icon-lg"></i> =	Default 
                                        &nbsp;
                                        <i style="font-size:20px; color: green;" class="mdi mdi-security icon-lg"></i> =	Low 
                                        &nbsp;
                                        <i style="font-size:20px; color: yellow;" class="mdi mdi-security icon-lg"></i> =	Medium
                                        &nbsp;
                                        <i style="font-size:20px; color: red;" class="mdi mdi-security icon-lg"></i> =	High
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- Button to Open the Modal -->
	<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
	Open modal
	</button> -->
	
	<?php echo ModelForm('myModal','000001','tesssss',1,'','บันทึก');?>
<?php include "{$part}include/footer.php"; ?>     
<script> 
function AddData(){
    $("#proc").val("add");
    $("#frm-search").attr("action","flow_form.php<?=$Link;?>").submit();
}
function EndData(mai_id){
    $("#proc").val("Endjob");
    $("#mai_id").val(mai_id);
    $("#frm-search").attr("action","flow_approve_form.php?step_flow=5&form_folw=1").submit();
}
function EditData(mai_id){
    $("#proc").val("edit");
    $("#mai_id").val(mai_id);
    $("#frm-search").attr("action","flow_form.php<?=$Link;?>").submit();
}
function DetailData(mai_id){
    $("#proc").val("view");
    $("#mai_id").val(mai_id);
    $("#frm-search").attr("action","flow_detail.php<?=$Link;?>").submit();
}
function SendData(mai_id){
    $("#proc").val("next_step");
    $("#mai_id").val(mai_id);
    $("#frm-search").attr("action","process/flow_proc.php<?=$Link;?>").submit();
}
function ReturnData(mai_id){
    $("#proc").val("return_step");
    $("#mai_id").val(mai_id);
    $("#frm-search").attr("action","process/flow_proc.php<?=$Link;?>").submit();
}
function delData(mai_id){
	Swal.fire({
	  title: 'ต้องการลบข้อมูลใช่หรือไม่?',
	  text: "",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'ตกลง',
	  cancelButtonText: "ยกเลิก"
	}).then((result) => {
		if (result.isConfirmed) {
            url = "process/flow_proc.php";
            data = {proc:'del',mai_id:mai_id};
            $.post(url,data,function(msg){
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'ลบรายการเสร็จสิ้น',
                showConfirmButton: false,
                timer: 1500
                })
                $('#tr_'+mai_id).remove();
            });
        }
	});
}
function stretchData(){
    $("#frm-search").attr("action","flow_dis3.php<?=$Link;?>").submit();
}
function ClearData(url){
	
	window.location.href = url;
}
</script>    