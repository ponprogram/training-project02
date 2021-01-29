<?php 
	$part = "../../";
	include ($part."include/include.php"); 
	$active_name = array('2'=>'ไม่ใช้งาน','1'=>'ใช้งาน');
	
	$S_COM_NAME     = (isset($_POST['S_COM_NAME'])!='')?$_POST['S_COM_NAME']:'';
	$ACTVE_STATUS   = (isset($_POST['ACTVE_STATUS'])!='')?$_POST['ACTVE_STATUS']:'';
	
	$wh_filde = "";
	if($S_COM_NAME!=''){
		$wh_filde .= " AND com_name LIKE '%{$S_COM_NAME}%'";
	}
	if($ACTVE_STATUS!=''){
		$wh_filde .= " AND active_status = '{$ACTVE_STATUS}'";
    } 
    
    if($_SESSION['PER_LAVEL']!=1 || $_SESSION['PER_LAVEL']==5){

        $wh_filde .= " AND com_id = '{$_SESSION['COM_ID']}'";
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
				com_id,
				com_name,
				address,
				phone_number,
				active_status 
			FROM
				company 
			WHERE
				1 = 1 {$wh_filde}";
	$total = $db->db_num_rows($db->query($sql));

	$sql .= "LIMIT ".$s_page.",$e_page";
	$query = $db->query($sql);

    
?>       
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h1><i class="mdi mdi-settings icon-lg"></i> ตั้งค่าบริษัท </h1>
    </div>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <form id="frm-search" action="" method="post">
              <input type="hidden" id="manu_sub_id" name="manu_sub_id" value="<?php echo $_GET['manu_sub_id'];?>">
              <input type="hidden" id="proc" name="proc" value="">
			  <input type="hidden" id="com_id" name="com_id" value="">
			  <input type="hidden" id="url_back" name="url_back" value="company_dis.php?settings=settings&manu_sub_id=<?php echo $_GET['manu_sub_id'];?>">
              <div class="row">
                  <h1 class=""><i class="mdi mdi-magnify"></i> ค้นหา</h1>
              </div>
              <div class="row">
				<div class="col-md-6">
				  <div class="form-group row" align="right">
					<label class="col-md-4 col-form-label">บริษัท : </label>
					<div class="col-md-6">
					  <input type="text" class="form-control ClearData" id="S_COM_NAME" name="S_COM_NAME" value="<?=$S_COM_NAME;?>">
					</div>
				  </div>
				</div>
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
					  <th width='10%' style="text-align: center;"> ลำดับ </th>
					  <th width='20%' style="text-align: center;"> บริษัท </th>
					  <th width='30%' style="text-align: center;"> ที่อยู่ </th>
					  <th width='10%' style="text-align: center;"> เบอร์โทร </th>
					  <th width='10%' style="text-align: center;"> สถานะ </th>
					  <th width='10%' style="text-align: center;"> จัดการ </th>
					</tr>
				  </thead>
				  <tbody>
					<?php
					if($db->db_num_rows($query)){
						$no = $s_page+1;
					  while($rec = $db->db_fetch_array($query)){
						$edit ="<button type=\"button\" class=\"btn btn-outline-info btn-sm\" onClick=\"EditData('".$rec['com_id']."');\"><span class=\"mdi mdi-account-edit\" ></span></span>แก้ไข</button>";
						$del ="<button type=\"button\" class=\"btn btn-outline-danger btn-sm\" onClick=\"delData('".$rec['com_id']."');\"><span class=\"mdi mdi-delete\"></span>ลบ</button>";
					
						if($_SESSION["MANU_GROUB"][$_GET['manu_sub_id']]['EDIT']==0){
							$edit='';
						}
						if($_SESSION["MANU_GROUB"][$_GET['manu_sub_id']]['DEL']==0){
							$del='';
						}
					?>
					  <tr id="tr_<?=$rec['com_id'];?>">
						<td style="text-align: center;"><?=$no;?></td>
						<td style="text-align: left;"><?=$rec["com_name"];?></td>
						<td style="text-align: left;"><?=$rec["address"];?></td>
						<td style="text-align: left;"><?=$rec["phone_number"];?></td>
						<td style="text-align: center;"><?=($rec["active_status"]!='')?$active_name[$rec["active_status"]]:'';?></td>
						<td style="text-align: center;"><?=$edit.' '.$del;?></td>
					  </tr>
					<?php
						$no++;
						$edit='';
						$del='';
					  }
					}else{
					?>
					<tr>
					  <td style="text-align: center;" colspan="7">ไม่พบข้อมูล</td>
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
    $("#frm-search").attr("action","company_form.php").submit();
}
function EditData(com_id){
    $("#proc").val("edit");
    $("#com_id").val(com_id);
    $("#frm-search").attr("action","company_form.php").submit();
}
function delData(com_id){
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
		url = "process/company_proc.php";
		data = {proc:'del',com_id:com_id};
		$.post(url,data,function(msg){
			Swal.fire({
			  position: 'center',
			  icon: 'success',
			  title: 'ลบรายการเสร็จสิ้น',
			  showConfirmButton: false,
			  timer: 1500
			})
			$('#tr_'+com_id).remove();
		});
	});
}
function stretchData(){
    $("#frm-search").attr("action","company_dis.php<?='?settings=settings&manu_sub_id='.$_GET['manu_sub_id'];?>").submit();
}
function ClearData(url){
	
	window.location.href = url;
}
</script>    