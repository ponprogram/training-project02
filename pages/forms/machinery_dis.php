<?php 
	$part = "../../";
	include ($part."include/include.php"); 
	$active_name = array('2'=>'ไม่ใช้งาน','1'=>'ใช้งาน');
	
	$s_mac_name         = (isset($_POST['s_mac_name'])!='')?$_POST['s_mac_name']:'';
	$S_COM_ID       = (isset($_POST['S_COM_ID'])!='')?$_POST['S_COM_ID']:'';
	$S_DEP_ID       = (isset($_POST['S_DEP_ID'])!='')?$_POST['S_DEP_ID']:'';
	$s_mac_number       = (isset($_POST['s_mac_number'])!='')?$_POST['s_mac_number']:'';
	$ACTVE_STATUS   = (isset($_POST['ACTVE_STATUS'])!='')?$_POST['ACTVE_STATUS']:'';
	
	$com_arr = get_company('1');
	$dep_arr = get_department('1',$S_COM_ID);
	$pos_arr = get_position('1',$S_COM_ID,$S_DEP_ID);
	$perfix_arr = get_perfix();
	 
	$wh_filde = "";
	if($s_mac_name!=''){
		$wh_filde .= " AND mac.mac_name LIKE '%{$s_mac_name}%'";
	}
	if($S_COM_ID!=''){
		$wh_filde .= " AND mac.com_id = '{$S_COM_ID}'";
	}
	if($S_DEP_ID!=''){
		$wh_filde .= " AND mac.dep_id = '{$S_DEP_ID}'";
	}
	if($s_mac_number!=''){
		$wh_filde .= " AND mac.mac_number = LIKE '%{$s_mac_number}%'";
	}
	if($ACTVE_STATUS!=''){
		$wh_filde .= " AND mac.active_status = '{$ACTVE_STATUS}'";
    }
    
    if($_SESSION['PER_LAVEL']!=1){
        $wh_filde .= " AND mac.com_id = '{$_SESSION['COM_ID']}'";
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
				mac.mac_id,
				mac.mac_name,
				mac.com_id,
				com.com_name,
				mac.dep_id,
				dep.dep_name,
				mac.mac_gen,
				mac.mac_year,
				mac.series_no,
				mac.active_status,
				mac.mac_number 
			FROM
				machinery mac
				LEFT JOIN company com ON com.com_id = mac.com_id
				LEFT JOIN department dep ON dep.dep_id = mac.dep_id
			WHERE
				1=1 {$wh_filde}";
	$total = $db->db_num_rows($db->query($sql));
	
	$sql .= "LIMIT ".$s_page.",$e_page";
	$query = $db->query($sql);

    
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h1><i class="mdi mdi-database icon-lg"></i> ทะเบียนเครื่องจักร </h1>
    </div>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <form id="frm-search" action="" method="post">
				<input type="hidden" id="manu_sub_id" name="manu_sub_id" value="<?php echo $_GET['manu_sub_id'];?>">
              	<input type="hidden" id="proc" name="proc" value="">
			  	<input type="hidden" id="mac_id" name="mac_id" value="">
			 	<input type="hidden" id="url_back" name="url_back" value="machinery_dis.php?settings=settings&manu_sub_id=<?php echo $_GET['manu_sub_id'];?>">
              <div class="row">
                  <h1 class=""><i class="mdi mdi-magnify"></i> ค้นหา</h1>
              </div>
				<div class="row">
					<div class="col-md-6">
					  <div class="form-group row" align="right">
						<label class="col-md-4 col-form-label">ชื่อเครื่องจักร : </label>
						<div class="col-md-6">
						  <input type="text" class="form-control ClearData" id="s_mac_name" name="s_mac_name" value="<?=$s_mac_name;?>">
						</div>
					  </div>
					</div>
					<div class="col-md-6">
					  <div class="form-group row" align="right">
						<label class="col-md-4 col-form-label">รหัสเครื่องจักร : </label>
						<div class="col-md-6">
						  <input type="text" class="form-control ClearData" id="s_mac_number" name="s_mac_number" value="<?=$s_mac_number;?>">
						</div>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
					  <div class="form-group row" >
						<div class="col-md-4" align="right">
							<label class="col-form-label">บริษัท :</label>
						</div>
						<div class="col-md-6">
							<select class="form-control select2 ClearData" id="S_COM_ID" name="S_COM_ID" onchange="search_option('S_COM_ID','S_DEP_ID','','dep','---ทั้งหมด---');">
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
					<div class="col-md-6">
						<div class="form-group row">
							<div class="col-md-4" align="right">
								<label class="col-form-label">แผนก : </label>
							</div>
							<div class="col-md-6">
								<select class="form-control select2 ClearData" id="S_DEP_ID" name="S_DEP_ID">
								  <option value="">---ทั้งหมด---</option>
								  <?php
									foreach($dep_arr as $key_dep=>$val_dep){ ?>
									  <option value="<?=$key_dep;?>" <?=($key_dep==$S_DEP_ID)?'selected':'';?>><?=$val_dep;?></option>
								  <?php
									}
								  ?>
								</select>
							</div>
						</div>
					</div>
				</div>
              <div class="row">
				<div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label" align="right">สถานะ : </label>
                    <div class="col-md-3">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="ACTVE_STATUS" id="ACTVE_STATUS1" value="1" <?=($ACTVE_STATUS==1)?'checked':'';?>> ใช้งาน <i class="input-helper"></i></label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="ACTVE_STATUS" id="ACTVE_STATUS2" value="2" <?=($ACTVE_STATUS==2)?'checked':'';?>> ไม่ใช้งาน <i class="input-helper"></i></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12" align="center">
                  <button type="button" class="btn btn-social-icon-text btn-twitter" style="margin-bottom:5px;" onClick="stretchData();"><i class="mdi mdi-magnify"></i> ค้นหา</button>
                  <button type="button" class="btn btn-social-icon-text btn-youtube" style="margin-bottom:5px;" onclick="ClearData('<?=$_SERVER['PHP_SELF'].'?settings=settings&manu_sub_id='.$_GET['manu_sub_id'];?>');"><i class="mdi mdi-reload btn-icon-prepend"></i>ยกเลิก</button>
                </div>
              </div>
            </form>
            <?php
				if($_SESSION["MANU_GROUB"][$_GET['manu_sub_id']]['ADD']>0){
					echo '<button type="button" class="btn btn-social-icon-text btn-linkedin" style="margin-bottom:5px;" onClick="AddData();"><i class="mdi mdi-account-plus"></i>เพิ่มข้อมูล</button>';		
				}
			?>
			<div style="overflow-x:auto;">
				<table class="table table-striped table-bordered">
				  <thead>
					<tr>
					  <th style="text-align: center;"> ลำดับ </th>
					  <th style="text-align: center;"> รหัสเครื่องจักร </th>
					  <th style="text-align: center;"> ชื่อเครื่องจักร </th>
					  <th style="text-align: center;"> บริษัท </th>
					  <th style="text-align: center;"> แผนก </th>
					  <th style="text-align: center;"> รุ่น ตามผู้ขาย </th>
					  <th style="text-align: center;"> ปีที่ซื้อ </th>
					  <th style="text-align: center;"> สถานะ </th>
					  <th style="text-align: center;"> จัดการ </th>
					</tr>
				  </thead>
				  <tbody>
					<?php
					if($db->db_num_rows($query)){
					  $no = $s_page+1;
					  while($rec = $db->db_fetch_array($query)){
						$edit ="<button type=\"button\" class=\"btn btn-outline-info btn-sm\" onClick=\"EditData('".$rec['mac_id']."');\"><span class=\"mdi mdi-account-edit\" ></span></span>แก้ไข</button>";
						$del ="<button type=\"button\" class=\"btn btn-outline-danger btn-sm\" onClick=\"delData('".$rec['mac_id']."');\"><span class=\"mdi mdi-delete\"></span>ลบ</button>";
						$print ="<button type=\"button\" class=\"btn btn-outline-success btn-sm\" onClick=\"PrintData('".$rec['mac_id']."');\"><i class=\"mdi mdi-printer\"></i>พิมพ์</button>";
					
						if($_SESSION["MANU_GROUB"][$_GET['manu_sub_id']]['EDIT']==0){
							$edit='';
						}
						if($_SESSION["MANU_GROUB"][$_GET['manu_sub_id']]['DEL']==0){
							$del='';
						}
					?>
					  <tr id="tr_<?=$rec['mac_id'];?>">
						<td style="text-align: center;"><?=$no;?></td>
						<td style="text-align: center;"><?=$rec['mac_number'];?></td>
						<td style="text-align: left;"><?=$rec['mac_name'];?></td>
						<td style="text-align: left;"><?=$rec["com_name"];?></td>
						<td style="text-align: left;"><?=$rec["dep_name"];?></td>
						<td style="text-align: left;"><?=$rec["mac_gen"];?></td>
						<td style="text-align: center;"><?=$rec["mac_year"];?></td>
						<td style="text-align: center;"><?=($rec["active_status"]!='')?$active_name[$rec["active_status"]]:'';?></td>
						<td style="text-align: center;"><?=$edit.' '.$del.' '.$print;?></td>
					  </tr>
					<?php
						$no++;
						$edit='';
						$del='';
						$print='';
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
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include "{$part}include/footer.php"; ?>
</div>    
<script>    
function AddData(){
    $("#proc").val("add");
    $("#frm-search").attr("action","machinery_form.php").submit();
}
function EditData(mac_id){
    $("#proc").val("edit");
    $("#mac_id").val(mac_id);
    $("#frm-search").attr("action","machinery_form.php").submit();
}
function PrintData(mac_id){
    $("#proc").val("edit");
    $("#mac_id").val(mac_id);
    $("#frm-search").attr("target","_blank");
    $("#frm-search").attr("action","machinery_report.php").submit();
}
function delData(mac_id){
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
		url = "process/machinery_proc.php";
		data = {proc:'del',mac_id:mac_id};
		$.post(url,data,function(msg){
			Swal.fire({
			  position: 'center',
			  icon: 'success',
			  title: 'ลบรายการเสร็จสิ้น',
			  showConfirmButton: false,
			  timer: 1500
			})
			$('#tr_'+mac_id).remove();
		});
	});
}
function stretchData(){
    $("#frm-search").attr("action","machinery_dis.php<?='?settings=settings&manu_sub_id='.$_GET['manu_sub_id'];?>").submit();
}
function ClearData(url){
	
	window.location.href = url;
}
</script>    