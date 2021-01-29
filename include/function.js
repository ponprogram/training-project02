$(document).ready(function() { 
	$(".select2").select2(); 
	$(".selectbox").select2(); 
	
});
function search_option(com_name,dep_name,pos_name,proc,texts,NameNext){
	if(com_name!=''){
		var COM_ID 	= $('#'+com_name).val();
	}
	if(dep_name!=''){
		var DEP_ID 	= $('#'+dep_name).val();
	}
	if(pos_name!=''){
		var POS_ID 	= $('#'+pos_name).val();
	}
	if(texts!=''){
		var tex_def = texts;
	}else{
		var tex_def = '--เลือก--';
	}
	switch(proc){
		case 'dep':
			var NAME_NEXT = dep_name;
			$.ajax({
				type: "POST", 
				url: "../all/ajax_onchang.php",
				data: {PROC:'DEP',COM_ID:COM_ID},
				cache: false,
				success: function(html){
					$('#'+NAME_NEXT).html('').select2({data: [{id:'', text:tex_def ,disabled: true,selected:true}]});
					$('#'+NAME_NEXT).select2({
						allowClear: true,
						data: html
					});
				}
				
			});
			
		break;
		case 'pos':
			var NAME_NEXT = pos_name;
			$.ajax({
				type: "POST", 
				url: "../all/ajax_onchang.php",
				data: {PROC:'POS',COM_ID:COM_ID,E_DEP:DEP_ID},
				cache: false,
				success: function(html){
						$('#'+NAME_NEXT).html('').select2({data: [{id:'', text: tex_def,disabled: true,selected:true}]});
						$('#'+NAME_NEXT).select2({
							allowClear: true,
							data: html
						});
				}
				
			});
		break;
		case 'get_machinery':
			var NAME_NEXT = NameNext;
			$.ajax({
				type: "POST", 
				url: "../all/ajax_onchang.php",
				data: {PROC:'GET_MACHINERY',COM_ID:COM_ID,E_DEP:DEP_ID},
				cache: false,
				success: function(html){
						$('#'+NAME_NEXT).html('').select2({data: [{id:'', text: tex_def, img: '',disabled: true,selected:true}]});
						$('#'+NAME_NEXT).select2({
							allowClear: true,
							data: html
						});
				}
				
			});
		break;
		default:
	}
}
function get_machineryIMG(com_name,dep_name,mac_name,NAME_NEXT,part){
	if(com_name!=''){
		var COM_ID 	= $('#'+com_name).val();
	}
	if(dep_name!=''){
		var DEP_ID 	= $('#'+dep_name).val();
	}
	if(mac_name!=''){
		var MAC_ID 	= $('#'+mac_name).val();
	}
	$.ajax({
		type: "POST", 
		url: "../all/ajax_GetData.php",
		data: {PROC:'GET_MACHINERY_IMG',COM_ID:COM_ID,E_DEP:DEP_ID,MAC_ID:MAC_ID},
		cache: false,
		success: function(html){
            
			urlre = part+'file_uplode/'+html; 
			$('#'+NAME_NEXT).attr('src',urlre);
		}
		
	});
}