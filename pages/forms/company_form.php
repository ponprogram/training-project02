<?php
  $part = "../../";
  include ($part."include/include.php"); 
  $page_name = ($_POST['proc']=='add')?'เพิ่มข้อมูล':'แก้ไขข้อมูล';
  
  $sql_main = "SELECT * FROM company WHERE com_id = '".$_POST['com_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);
  
  $sql_dep = "SELECT * FROM company_temp WHERE com_id = '".$_POST['com_id']."'";
  $query_dep = $db->query($sql_dep);

  $com_arr = get_company('1');
  $dep_arr = get_department('1');
  $pos_arr = get_position('1');
  $perfix_arr = get_perfix();
  $lavel_arr = array('0'=>'ผู้ดูแลระบบ','1'=>'หัวหน้าแผนก','2'=>'ผู้ใช้งานทั่วไป');
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><i class="mdi mdi-settings icon-lg"></i> ตั้งค่าบริษัท </h1>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=$_POST['url_back'];?>">ตั้งค่าบริษัท</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
        <form id="frm-input" action="" method="post">
			<input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
			<input type="hidden" id="com_id" name="com_id" value="<?=$_POST['com_id'];?>">
			<input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
			<div class="row">
			  <div class="col-lg-6 grid-margin stretch-card">
				<div class="card">
				  <div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" align="right">ชื่อบริษัท : </label>
								<div class="col-sm-9">
									<input type="text" class="form-control ClearData" id="com_name" name="com_name" value="<?=$rec_main['com_name'];?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" align="right">ชื่อย่อ : </label>
								<div class="col-sm-9">
									<input type="text" class="form-control ClearData" id="com_name_short" name="com_name_short" value="<?=$rec_main['com_name_short'];?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" align="right">ที่อยู่ : </label>
								<div class="col-sm-9">
									<textarea class="form-control ClearData" id="address" name="address" rows="5"><?=$rec_main['address'];?></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
							  <label class="col-sm-3 col-form-label" align="right">เบอร์โทร : </label>
							  <div class="col-sm-9">
								<input type="text" class="form-control ClearData" id="phone_number" name="phone_number" value="<?=$rec_main['phone_number'];?>">
							  </div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" align="right">สถานะการใช้งาน : </label>
								<div class="col-sm-4">
									<div class="form-check">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="ACTVE_STATUS" id="ACTVE_STATUS1" value="1" <?=($rec_main['active_status']==1)?'checked':'';?>> ใช้งาน </label>
									</div>
								</div>
								<div class="col-sm-5">
									<div class="form-check">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="ACTVE_STATUS" id="ACTVE_STATUS2" value="2" <?=($rec_main['active_status']==2)?'checked':'';?>> ไม่ใช้งาน </label>
									</div>
								</div>
							</div>
						</div>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="col-lg-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">แผนกและตำแน่ง</h4>
						<button type="button" class="btn btn-gradient-success btn-rounded btn-fw" onClick="add_dep();"><i class="mdi mdi-import"></i> เพิ่มแผนกและตำแน่ง</button>
						</p>
						<table class="table .table-hover table-bordered" id="DEP_POS_ID">
							<thead>
								<tr>
									<th width='10%' style="text-align: center;">ลำดับ</th>
									<th width='40%' style="text-align: center;">แผนก</th>
									<th width='40%' style="text-align: center;">ตำแหน่ง</th>
									<th width='10%' style="text-align: center;">จัดการ</th>
								</tr>               
							<tbody>
							<?php
								$i=1;
								$num_dep = $db->db_num_rows($query_dep);
								if($num_dep>0){
									while($rec_dep = $db->db_fetch_array($query_dep)){ ?>
										<tr id="tr_<?=$i;?>" on-count="<?=$i;?>">
											<td style="text-align: center;"><?=$i;?></td>
											<td style="text-align: center;">
												<select class="form-control select2" id="DEP_ID_<?=$i;?>" name="DEP_ID[]">
												  <option value="">---เลือก---</option>
												  <?php
													foreach($dep_arr as $key_dep=>$val_dep){ ?>
													  <option value="<?=$key_dep;?>" <?=($key_dep==$rec_dep['dep_id'])?'selected':'';?>><?=$val_dep;?></option>
												  <?php
													}
												  ?>
												</select>
											</td>
											<td style="text-align: center;">
												<select class="form-control select2" id="POS_ID_<?=$i;?>" name="POS_ID[]">
												  <option value="">---เลือก---</option>
												  <?php
													foreach($pos_arr as $key_pos=>$val_pos){ ?>
													  <option value="<?=$key_pos;?>" <?=($key_pos==$rec_dep['pos_id'])?'selected':'';?>><?=$val_pos;?></option>
												  <?php
													}
												  ?>
												</select>
											</td>
											<td style="text-align: center;"><button type="button" class="btn btn-gradient-danger  btn-md" onClick="remove('<?=$i;?>');"><i class="mdi mdi-delete icon-lg"></i> ลบ</button></td>
										</tr>
							<?php
									$i++;
									}
								}else{
							?>
								<tr id="notdata">
									<td style="text-align: center;" colspan="4">ไม่พบข้อมูล</td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						<input type="hidden" id="DEP_ON" name="DEP_ON" value="<?=$i;?>">
					</div>
				</div>
			  </div>
			</div>
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
				  <div class="form-group row">
					<div class="col-md-12" align="center">
					  <br>
					  <button type="button" class="btn btn-outline-success btn-fw" style="margin-bottom:5px;" onClick="submit_chk();"><i class="mdi mdi-content-save"></i> บันทึก</button>
					  <button type="button" class="btn btn-outline-danger btn-fw" style="margin-bottom:5px;" onclick="ClearData();"><i class="mdi mdi-cached btn-icon-prepend"></i>ยกเลิก</button>
					  <br>
					</div>
				  </div>
				</div>
			</div>
		</form>
    </div>

  <?php include "{$part}include/footer.php"; ?>
  </div>
<script>    
function submit_chk(){
	$("#frm-input").attr("action","process/company_proc.php").submit();
}
function ClearData(){
	location.reload();
}
function add_dep(){
	var on_count = $('#DEP_ON').val();
	var on = parseInt(on_count)+1;
	url = "../all/get_html_dep_pos.php";
	data = {on:on};
	$.post(url,data,function(msg){
		$('tbody').append(msg);
		$('#notdata').remove();
		$('#DEP_ON').val(on);
	});
}
function remove(on){
	var on_count = $('#DEP_ON').val();
	$('#tr_'+on).remove();
}
</script>  