<?php
  $part = "../../";
  include ($part."include/include.php"); 
	//manu header
	if($_GET['step_flow']!=''){
	$ManuSub = " <i class=\"mdi mdi-hand-pointing-right icon-lg\"></i> ".$arr_manu_sub[$_GET['step_flow']]."";
	}
	$ManuHeader = "<i class=\"mdi mdi-settings icon-lg\"></i> ".$arr_manu_main[$_GET['form_folw']].$ManuSub;
	//manu header
	$Link = "?step_flow=".$_GET['step_flow']."&form_folw=".$_GET['form_folw'];
  $page_name = ($_POST['proc']=='add')?'เพิ่มข้อมูล':'แก้ไขข้อมูล';
  $temp_code = (random(50)).date('dmyhis');
  $sql_main = "SELECT * FROM maintenance WHERE mai_id = '".$_POST['mai_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);
  
  $sql_frm = "SELECT frm_id FROM maintenance_from WHERE mai_id = '".$_POST['mai_id']."' ORDER BY frm_id DESC LIMIT 1";
  $query_frm = $db->query($sql_frm);
  $rec_frm = $db->db_fetch_array($query_frm);

  $com_arr = get_company('1');
  $dep_arr = get_department('1');
  $dep_machinery = get_machinery('1');
  $per_arr = get_per('1');

  $_POST['frm_id'] = $rec_frm['frm_id'];
  
  $tab_id 	= $_POST['mai_id'];
  $tab_name = "maintenance";
  
  // $com_arr = get_company('1');
  // $dep_arr = get_department('1',$rec_main['com_id']);
  // $dep_machinery = get_machinery('1',$rec_main['com_id'],$rec_main['dep_id']);
?>
<!-- partial -->
<style>
    .container {
        max-width: 1640px!important;
    }
</style>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><?=$ManuHeader;?></h1>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=$_POST['url_back'];?>">ระบบแจ้งซ่อม</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
    <div class="card">
        <div class="card-body">
            <form id="frm-input" action="" method="post" enctype='multipart/form-data'>
                <input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
                <input type="hidden" id="mai_id" name="mai_id" value="<?=$_POST['mai_id'];?>">
                <input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
                <input type="hidden" id="temp_code" name="temp_code" value="<?=$temp_code;?>">

                <div class="container">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#detail1">รายละเอียด</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detail2">รูปหรือวิดิโอ</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detail3">มอบหมายงาน</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detail4">แจ้งผลดำเนินการ</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="detail1" class="container tab-pane active"><br>
                            <h3>รายละเอียด</h3>
                            <div class="col-md-12">
                                <?php include('../all/file_detail_main.php');?>
                            </div>
                        </div>
                        <div id="detail2" class="container tab-pane fade"><br>
                            <h3>รูปหรือวิดิโอ</h3>
                            <div class="col-md-12">
                                <?php include('../all/file_detail_uplode.php');?>
                            </div>
                            </div>
                        </div>
                        <div id="detail3" class="container tab-pane fade"><br>
                            <h3>มอบหมายงาน</h3>
                            <div class="col-md-12">
                                <?php include('../all/file_detail_assign.php');?>
                            </div>
                        </div>
                        <div id="detail4" class="container tab-pane fade"><br>
                            <h3>แจ้งผลดำเนินการ</h3>
                            <div class="col-md-12">
                                <?php include('../all/file_detail_reply.php');?>    
                            </div>
                        </div>
                    </div>
                </div>
          </form>
        </div>
    </div>
  <?php include "{$part}include/footer.php"; ?>
