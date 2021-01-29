<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="<?=($_SESSION['IMG_PER']!='')?$part.'file_uplode/'.$_SESSION['IMG_PER']:$part.'assets/images/user.png';?>" alt="profile">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2"><?=$_SESSION['PER_NAME'];?></span>
                  <span class="text-secondary text-small"><?=$_SESSION['POS_NAME'];?></span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=$part;?>home.php">
                <span class="menu-title">เมนูหลัก</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <?php
              if($_SESSION['PER_LAVEL']!=''){
            ?>
			<li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#forms-save" aria-expanded="false" aria-controls="forms-save">
                <span class="menu-title">บันทึกข้อมูล</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-content-save menu-icon"></i>
              </a>
              <div class="collapse" id="forms-save">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/flow/flow_dis.php?step_flow=1&form_folw=1"> ระบบแจ้งซ่อม</a></li>
                  <li class="nav-item"> <a class="nav-link" href="#!"> ทะเบียน PO</a></li>
                </ul>
              </div>
            </li>
            <?php
              }
              if($_SESSION['PER_LAVEL']!=''){
            ?>
			<li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#forms-appoint" aria-expanded="false" aria-controls="forms-appoint">
                <span class="menu-title">มอบหมายงาน</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-folder-move menu-icon"></i>
              </a>
              <div class="collapse" id="forms-appoint">
                <ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/flow/flow_assign_dis.php?step_flow=2&form_folw=1"> ระบบแจ้งซ่อม</a></li>
					<li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/flow/flow_assign_dis.php?step_flow=2&form_folw=2"> ทะเบียน PM</a></li>
                </ul>
              </div>
            </li>
			<?php
              }
              if($_SESSION['PER_LAVEL']==0){
            ?>
            <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#forms-pages" aria-expanded="false" aria-controls="forms-pages">
                <span class="menu-title">รายงานผลดำเนินงาน</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-reply-all menu-icon"></i>
              </a>
              <div class="collapse" id="forms-pages">
                <ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/flow/flow_reply_dis.php?step_flow=3&form_folw=1"> ระบบแจ้งซ่อม</a></li>
					<li class="nav-item"> <a class="nav-link" href="#!"> ทะเบียน PM</a></li>
                </ul>
              </div>
            </li>
			<?php
              }
              if($_SESSION['PER_LAVEL']!=''){
            ?>
			<li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#forms-approve" aria-expanded="false" aria-controls="forms-approve">
                <span class="menu-title">อนุมัติ/ตรวจสอบ</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-clipboard-check menu-icon"></i>
            </a>
              <div class="collapse" id="forms-approve">
                <ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/flow/flow_approve_dis.php?step_flow=4&form_folw=1"> ระบบแจ้งซ่อม</a></li>
					<li class="nav-item"> <a class="nav-link" href="#!"> ทะเบียน PM</a></li>
                </ul>
              </div>
            </li>
			<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#general-report" aria-expanded="false" aria-controls="general-report">
                <span class="menu-title">รายงาน</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-printer menu-icon"></i>
              </a>
              <div class="collapse" id="general-report">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="#!"> รายงาน 1 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#!"> รายงาน 2 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#!"> รายงาน 3 </a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                <span class="menu-title">ตั้งค่าพื้นฐาน</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
              </a>
              <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/profile_dis.php"> ข้อมูลบุคลากร </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/company_dis.php"> ตั้งค่าบริษัท </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/department_dis.php"> ตั้งค่าตำแหน่ง </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/position_dis.php"> ตั้งค่าตำแหน่ง </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/perfix_dis.php"> ตั้งค่าคำนำหน้า </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/lavel_dis.php"> ตั้งค่าระดับผู้ใช้งาน </a></li>
				          <li class="nav-item"> <a class="nav-link" href="#!"> ตั้งค่าทะเบียน PM</a></li>
				          <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/machinery_dis.php"> ตั้งค่าทะเบียนเครื่องจักร </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/equipment_dis.php"> ตั้งค่าทะเบียนอุปกรณ์ </a></li>
                </ul>
              </div>
            </li>
            <?php
              }
            ?>
          </ul>
        </nav>