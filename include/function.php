<?php
    include ("function_main.php"); 
    ini_set('display_errors',0);
	// error_reporting(E_ALL & ~E_NOTICE);
    $db = new sql_main();
	//===== Start Array =====//
		$FlowArray = array('1'=>'1.บันทึกข้อมูล','2'=>'2.มอบหมายงาน','3'=>'3.ตรวจสอบ/ซ่อม','4'=>'4.อนุมัติ/ตรวจสอบ','5'=>'5.รอปิดงาน','0'=>'6.ปิดงาน');
		$arr_manu_main = array('1'=>'ระบบแจ้งซ่อม','2'=>'ทะเบียน PM'); //step_flow
		$arr_manu_sub = array('1'=>'บันทึกข้อมูล','2'=>'มอบหมายงาน','3'=>'แจ้งผลดำเนินการ','4'=>'อนุมัติ/ตรวจสอบ','5'=>'รอปิดงาน','0'=>'ปิดงาน');//form_folw
		$arr_severity = array('L'=>'Low','M'=>'Medium','H'=>'High',''=>'ไม่ระบุระดับความรุนแรง'); //severity
		$per_arr = get_per('1');
		// print_r($per_arr);
	//===== End Array =====//
    function text($txt){
        return iconv("tis-620","utf-8",trim($txt));
    }
    function convert_text($txt){
        $arr_text = array();
        if(count($txt)>0){
            foreach($txt as $key=>$val){
                $arr_text[$key] = iconv("tis-620","utf-8",trim($val));
                }
            }
        return $arr_text;
    }

    function ctext($txt){
        $strOut=strip_tags($txt); 
        $strOut=htmlspecialchars($strOut, ENT_QUOTES);
        $strOut=stripslashes($strOut);
        $strOut=str_replace("'"," ",$strOut);
        $strOut=trim($strOut);

        return iconv("utf-8","tis-620",$strOut);
    }
    function get_per($active_status=''){
        global $db;
        $arr_per = array();
        if($active_status==1){
            $wh = "AND per.active_status = 1";
        }
        $sql_per = "SELECT
						per.per_id,
						CONCAT( pf.perfix_name_th, per.f_name, ' ', per.l_name ) AS fullname 
					FROM
                        profile per
						LEFT JOIN perfix pf ON pf.perfix_id = per.perfix_id 
					WHERE
						1=1 {$wh}";
        $query_per = $db->query($sql_per);
        while($rec_per = $db->db_fetch_array($query_per)){
            $arr_per[trim($rec_per['per_id'])] = $rec_per['fullname'];
        }
        return $arr_per;
    }
	function get_company($active_status=''){
        global $db;
        $arr_com = array();
        if($active_status==1){
            $wh = "AND active_status = 1";
        }
        $sql_com = "SELECT
						com_id,
						com_name, 
						com_name_short, 
						CONCAT('[',com_name_short,'] ',com_name) AS fullname
					FROM
						company 
					WHERE 1=1 {$wh}";
        $query_com = $db->query($sql_com);
        while($rec_com = $db->db_fetch_array($query_com)){
			if($rec_com['fullname']!=''){
				$arr_com[trim($rec_com['com_id'])] = $rec_com['fullname'];
			}else{
				$arr_com[trim($rec_com['com_id'])] = $rec_com['com_name'];
			}
        }
        return $arr_com;
    }
    function get_department($active_status='',$com_id=''){
        global $db;
        $arr_dep = array();
        if($active_status==1){
            $wh = "AND dep.active_status = 1";
        }
		if($com_id!=''){
			$wh .=" AND ct.com_id = '".$com_id."' ";
		}
        $sql_dep = "SELECT
						ct.dep_id,
						dep.dep_name
					FROM
						company_temp ct
					INNER JOIN
						department dep ON dep.dep_id = ct.dep_id
					WHERE
						1=1 {$wh}
					GROUP BY
						ct.dep_id,
						dep.dep_name
					ORDER BY
						dep.dep_id ASC ";
        $query_dep = $db->query($sql_dep);
        while($rec_dep = $db->db_fetch_array($query_dep)){
            $arr_dep[trim($rec_dep['dep_id'])] = $rec_dep['dep_name'];
        }
        return $arr_dep;
    }
    function get_position($active_status='',$com_id='',$dep_id=''){
        global $db;
        $arr_pos = array();
        if($active_status==1){
            $wh = " AND pos.active_status = 1";
        }
		if($com_id!=''){
			$wh .=" AND ct.com_id = '".$com_id."' ";
		}
		if($dep_id!=''){
			$wh .=" AND ct.dep_id = '".$dep_id."' ";
		}
        $sql_pos = "SELECT
						ct.pos_id,
						pos.pos_name
					FROM
						company_temp ct
					INNER JOIN
						m_position pos ON pos.pos_id = ct.pos_id
					WHERE
						1=1 {$wh}
					GROUP BY
						ct.pos_id,
						pos.pos_name
					ORDER BY
						pos.pos_id ASC";
        $query_pos = $db->query($sql_pos);
        while($rec_pos = $db->db_fetch_array($query_pos)){
            $arr_pos[trim($rec_pos['pos_id'])] = $rec_pos['pos_name'];
        }
        return $arr_pos;
    }
    function get_lavel($active_status=''){
        global $db;
        $arr_lavel = array();
        if($active_status==1){
            $wh = " AND active_status = 1";
        }
        $sql_lavel = "SELECT
						lavel_id,
						lavel_name 
					FROM
						lavel_user 
					WHERE
						1=1 {$wh}";
        $query_lavel = $db->query($sql_lavel);
        while($rec_lavel = $db->db_fetch_array($query_lavel)){
            $arr_lavel[trim($rec_lavel['lavel_id'])] = $rec_lavel['lavel_name'];
        }
        return $arr_lavel;
    }
    function get_perfix($type='TH'){
        global $db;
        $arr = array();
        if($type=='TH'){
            $perfix_name = "perfix_name_th";
        }else if($type=='EN'){
            $perfix_name = "perfix_name_en";
        }
        $sql = "SELECT perfix_id ,{$perfix_name} FROM perfix";
        $query = $db->query($sql);
        while($rec = $db->db_fetch_array($query)){
            $arr[trim($rec['perfix_id'])] = $rec[$perfix_name];
        }
        return $arr;
    }
	function get_step_flow($step,$mac_id=''){
		global $db,$FlowArray,$per_arr;
		if($step==3 && $mac_id!=''){
			$sql = "SELECT 
							frm_id,per_id 
						FROM
							maintenance_from
						WHERE
							mai_id = '{$mac_id}'
						ORDER BY
							frm_id DESC
						LIMIT 1";
			$query = $db->query($sql);
			$rec = $db->db_fetch_array($query);
			
			$stepFlow = $FlowArray[$step].'<br> ('.$per_arr[$rec['per_id']].')';
		}else{
			$stepFlow = $FlowArray[$step];
		}
		return $stepFlow;
	}
	function get_machinery($active_status='',$com_id='',$dep_id=''){
        global $db;
        $arr_mac = array();
        if($active_status==1){
            $wh = " AND active_status = 1";
        }
		if($com_id!=''){
			$wh .=" AND com_id = '".$com_id."' ";
		}
		if($dep_id!=''){
			$wh .=" AND dep_id = '".$dep_id."' ";
		}
        $sql_mac = "SELECT
						mac_id,img,
						(CASE
								WHEN mac_number IS NULL THEN
									mac_name
								ELSE
									CONCAT('[',mac_number,'] ',mac_name)
							END) AS FullMacName
					FROM
						machinery
					WHERE
						1=1 {$wh}
					GROUP BY
						mac_id,
						mac_number,
						mac_name,
						img
					ORDER BY
						mac_number,mac_name ASC";
        $query_mac = $db->query($sql_mac);
        while($rec_mac = $db->db_fetch_array($query_mac)){
            $arr_mac[trim($rec_mac['mac_id'])] 	= $rec_mac['FullMacName'];
        }
        return $arr_mac;
    }
	function random($len){
		srand((double)microtime()*10000000);
		$chars = "ABCDEFGHJKMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz1234567890";
		$ret_str = "";
		$num = strlen($chars);
		for($i=0;$i<$len;$i++){
			$ret_str .= $chars[rand()%$num];
		}
		return $ret_str;
	}
	//แปลงค่าวันที่
	function conv_date($input, $format_month='', $type='',$br_type=1){
		global $mont_en, $mont_en_short, $mont_th, $mont_th_short;
		/*
			$input='2013-11-14 10:43:04' || '2013-11-14', 
			$type='' ไม่แสดงเวลา
			$type='1' แสดงเวลา
			$br_type = 1 ใส่ <br>
			$br_type =  2 ไม่ใส่ <br>
		*/
		if(trim($input)){
			if($format_month=='long'){
				$date=(int)substr($input,8,2)." ".$mont_th[substr($input,5,2)]." ".(substr($input,0,4)+543);
				}elseif($format_month=='short'){
				$date=(int)substr($input,8,2)." ".$mont_th_short[substr($input,5,2)]." ".(substr($input,0,4)+543);
				}elseif($format_month=='full'){
				$date=(int)substr($input,8,2)." เดือน ".$mont_th[substr($input,5,2)]." พ.ศ. ".(substr($input,0,4)+543);
				}elseif($format_month=='short2'){
				$date=(int)substr($input,8,2)." ".$mont_th[substr($input,5,2)]."  ".(substr($input,0,4)+543);
				}elseif($format_month=='time'){
				$date=substr($input,10,6);
				}else{
				$date=substr($input,8,2)."/".substr($input,5,2)."/".(substr($input,0,4)+543);
			}
		}else{
			$date=($format_month=='')?"":"-";
		}
		return $date;
	}
	function RunFlowNumber($type,$year=''){
		if($year==''){
			$year=date('Y')+543;
		}
		$num = Maxrun($type,$year);
		$paddedNum = sprintf("%05d", $num);
		$Number = $paddedNum.'/'.$year;
		return $Number;
	}
	function Maxrun($type,$year=''){
		global $db;
		if($year==''){
			$year=date('Y')+543;
		}
		$sql_mac = "SELECT MAX(mai_run) AS mai_run FROM maintenance WHERE mai_type = '{$type}' AND mai_year='{$year}'";
        $query_mac = $db->query($sql_mac);
        $rec_mac = $db->db_fetch_array($query_mac);
		$num = $rec_mac['mai_run']+1;
		return $num;
	}
	//แปลงค่าวันที่ ลง DB
	function conv_date_db($input){
		$date=trim($input)?(substr($input,6,4)-543)."-".substr($input,3,2)."-".substr($input,0,2):'NULL';
		return $date;
	}
	function convert_int_date($int){
		$date = substr($int,6,2)."/".substr($int,4,2)."/".substr($int,0,4);
		return $date;
	}
	function convert_month($month,$language){
		if($language=='longthai'){
			if($month=='01' || $month=='1'){
				$month = "มกราคม";
				}elseif($month=='02' || $month=='2'){
				$month = "กุมภาพันธ์";
				}elseif($month=='03' || $month=='3'){
				$month = "มีนาคม";
				}elseif($month=='04' || $month=='4'){
				$month = "เมษายน";
				}elseif($month=='05' || $month=='5'){
				$month = "พฤษภาคม";
				}elseif($month=='06' || $month=='6'){
				$month = "มิถุนายน";
				}elseif($month=='07' || $month=='7'){
				$month = "กรกฎาคม";
				}elseif($month=='08' || $month=='8'){
				$month = "สิงหาคม";
				}elseif($month=='09' || $month=='9'){
				$month = "กันยายน";
				}elseif($month=='10'){
				$month = "ตุลาคม";
				}elseif($month=='11'){
				$month = "พฤศจิกายน";
				}elseif($month=='12'){
				$month = "ธันวาคม";
			}
			return $month;
			}elseif($language=='shortthai'){
			if($month=='01' || $month=='1'){
				$month = "ม.ค.";
				}elseif($month=='02' || $month=='2'){
				$month = "ก.พ.";
				}elseif($month=='03' || $month=='3'){
				$month = "มี.ค.";
				}elseif($month=='04' || $month=='4'){
				$month = "เม.ย.";
				}elseif($month=='05' || $month=='5'){
				$month = "พ.ค.";
				}elseif($month=='06' || $month=='6'){
				$month = "มิ.ย.";
				}elseif($month=='07' || $month=='7'){
				$month = "ก.ค.";
				}elseif($month=='08' || $month=='8'){
				$month = "ส.ค.";
				}elseif($month=='09' || $month=='9'){
				$month = "ก.ย.";
				}elseif($month=='10'){
				$month = "ต.ค.";
				}elseif($month=='11'){
				$month = "พ.ย.";
				}elseif($month=='12'){
				$month = "ธ.ค.";
			}
			return $month;
			}elseif($language=='shorteng'){
			if($month=='01' || $month=='1'){
				$month = "Jan";
				}elseif($month=='02' || $month=='2'){
				$month = "Feb";
				}elseif($month=='03' || $month=='3'){
				$month = "Mar";
				}elseif($month=='04' || $month=='4'){
				$month = "Apr";
				}elseif($month=='05' || $month=='5'){
				$month = "May";
				}elseif($month=='06' || $month=='6'){
				$month = "Jun";
				}elseif($month=='07' || $month=='7'){
				$month = "Jul";
				}elseif($month=='08' || $month=='8'){
				$month = "Aug";
				}elseif($month=='09' || $month=='9'){
				$month = "Sep";
				}elseif($month=='10'){
				$month = "Oct";
				}elseif($month=='11'){
				$month = "Nov";
				}elseif($month=='12'){
				$month = "Dec";
			}
			return $month;
			}elseif($language=='longeng'){
			if($month=='01'  || $month=='1'){
				$month = "January";
				}elseif($month=='02' || $month=='2'){
				$month = "February";
				}elseif($month=='03' || $month=='3'){
				$month = "March";
				}elseif($month=='04' || $month=='4'){
				$month = "April";
				}elseif($month=='05' || $month=='5'){
				$month = "May";
				}elseif($month=='06' || $month=='6'){
				$month = "June";
				}elseif($month=='07' || $month=='7'){
				$month = "July";
				}elseif($month=='08' || $month=='8'){
				$month = "August";
				}elseif($month=='09' || $month=='9'){
				$month = "September";
				}elseif($month=='10'){
				$month = "October";
				}elseif($month=='11'){
				$month = "November";
				}elseif($month=='12'){
				$month = "December";
			}
			return $month;
		}
	}
	function get_severityimg($type="D"){
		if($type=='L'){
			$img = "<i style=\"font-size:32px; color: green;\" class=\"mdi mdi-security icon-lg\"></i> ";
		}elseif($type=='M'){
			$img = "<i style=\"font-size:32px; color: yellow;\" class=\"mdi mdi-security icon-lg\"></i> ";
		}elseif($type=='H'){
			$img = "<i style=\"font-size:32px; color: red;\" class=\"mdi mdi-security icon-lg\"></i> ";
		}else{
			$img = "<i style=\"font-size:32px; color: #000000;\" class=\"mdi mdi-security icon-lg\"></i> ";
		}
		echo $img;
	}
	function ModelForm($IDmodal,$header,$spanID,$saveshow,$savefunc,$savename){
		$btnsave = "";
		if($saveshow==1){
			$btnsave = "<button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\" onclick=\"".$savefunc."\">".$savename."</button>";
		}
		$model ="<div class=\"modal\" id=\"".$IDmodal."\">
					<div class=\"modal-dialog\">
						<div class=\"modal-content\">
							<div class=\"modal-header\" style=\"border-bottom: 1px solid;\">
								<h4 class=\"modal-title\">".$header."</h4>
								<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
							</div>
							<div class=\"modal-body\" style=\"border-bottom: 1px solid;\">
								<span id=\"".$spanID."\"></span>
							</div>
							<div class=\"modal-footer\">
								{$btnsave}
								<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">ปิด</button>
							</div>
						</div>
					</div>
				</div>";
		return $model;
	}
	function page_navi($total_item, $cur_page, $per_page=10, $query_str="", $min_page=5){
 
		$total_page = ceil($total_item/$per_page);
		$cur_page = (isset($cur_page))?$cur_page:1;
		$diff_page = NULL;
		if($cur_page>$min_page){
			$diff_page = $total_page-$cur_page;
		}
		$limit_page = $min_page;
		$f_num_page = ($cur_page<=$min_page)?1:(floor($cur_page/$min_page)*$min_page)+1;
		if($diff_page>$min_page){
			$limit_page = ($min_page + $f_num_page)-1;
		}else{
			if(isset($diff_page)){
				$limit_page = $total_page;
			}else{
				$limit_page = $min_page;
			}
		}
		$show_page = ($total_page<=$min_page)?$total_page:$limit_page;
		$l_num_page = 1;
		$prev_page = $cur_page-1;
		$next_page = $cur_page+1;
		$temp_query_str = $query_str;
		$query_str = "";
		if($temp_query_str && is_array($temp_query_str) && count($temp_query_str)>0){
			array_pop($temp_query_str);
			$query_str = http_build_query($temp_query_str);
			if($query_str!=""){
				$query_str = "?".$query_str;    
			}
		}
		$mark_char = ($query_str!="")?"&":"?";
			
			echo '<br> <div class="row">
					<div class="col-md-6">'; 
				echo '<p class="justify-content-start">หน้าที่ '.$cur_page.' จากทั้งหมด '.$show_page.' หน้า จำนวนข้อมูล '.$total_item.' รายการ</p>';
		 	echo '</div><div class="col-md-6" align="right">';
				echo '<nav>
					<ul class="pagination justify-content-end">
					<li class="page-item">
					<a class="page-link waves-effect" href="'.$query_str.$mark_char.'page=1"><i class="mdi mdi-chevron-double-left"></i></a>
					</li>
					';
				echo '
					<li class="page-item '.(($cur_page==1)?"disabled":"").'">
					  <a class="page-link"  href="'.$query_str.$mark_char.'page='.$prev_page.'"><i class="mdi mdi-chevron-left"></i></a> 
					</li> 
				';  
				for($i = $f_num_page; $i<=$show_page;$i++){
				echo '     
					<li class="page-item '.(($i==$cur_page)?"active":"").'"> 
						<a class="page-link" href="'.$query_str.$mark_char.'page='.$i.'"> '.$i.' </a> 
					</li>     
				';
				}
				echo '
					<li class="page-item '.(($next_page>$total_page)?"disabled":"").'"> 
						<a class="page-link"  href="'.$query_str.$mark_char.'page='.$next_page.'"><i class="mdi mdi-chevron-right"></i></a> 
					</li>     
				';  

				// echo '
				// 	<li class="page-item">
				// 	  <input type="number" class="form-control" min="1" max="'.$total_page.'"
				// 			  style="width:80px;" onClick="this.select()" onchange="window.location=\''.$query_str.$mark_char.'page=\'+this.value"  value="'.$cur_page.'" />
				// 	</li> 
				// ';
				echo '
					<li class="page-item"> 
						<a class="page-link waves-effect"  href="'.$query_str.$mark_char.'page='.$total_page.'"><i class="mdi mdi-chevron-double-right"></i></a> 
					</li>     
					</ul>
				</nav>        
				';     
		echo '</div></div>'; 
    }
    function FuncAlert(){
        $arr_in = array();
        $sql_manu_sub = "SELECT
                            ms.manu_id
                        FROM
                            manu_setting ms
                        JOIN
                            manu_set_groub msg ON msg.manu_id = ms.manu_id
                        JOIN 
                            profile per ON per.per_lavel = msg.lavel_id
                        WHERE
                            ms.manu_lavel > 1
                            AND per.per_id = '{$_SESSION['PER_ID']}'
                        ORDER BY
                            ms.manu_order ASC";
        $query_manu_sub = $db->query($sql_manu_sub);
        while($rec_manu_sub = $db->db_fetch_array($query_manu_sub)){
            // ระบบแจ้งซ่อม
                // บันทึกข้อมูล
                if($rec_manu_sub['manu_id']==32){
                    
                }
                // มอบหมายงาน
                if($rec_manu_sub['manu_id']==33){
                    $sql_mac = "SELECT
                                    COUNT(*) AS nums
                                FROM
                                    maintenance mai
                                    INNER JOIN machinery mac ON mac.mac_id = mai.mac_id
                                    LEFT JOIN company com ON com.com_id = mai.com_id
                                    LEFT JOIN department dep ON dep.dep_id = mai.dep_id 
                                WHERE
                                    1 = 1 
                                    AND mai.step_flow = 2
                                    AND IFNULL(mai.flow_status,'N') = 'N'
                                    AND mai.com_id = '{$_SESSION['COM_ID']}'";
                    $query_mac = $db->query($sql_mac);
                    $rec_mac = $db->db_fetch_array($query_mac);
                    // $arr_in[][] = '';
                    
                }
                // รายงานผลดำเนินงาน
                if($rec_manu_sub['manu_id']==34){
                    
                }
                // อนุมัติ/ตรวจสอบ
                if($rec_manu_sub['manu_id']==35){
                    
                }
            // ระบบแจ้งซ่อม
        }
    }
    ini_set("memory_limit","200M");
?>