<?php
function arrayEmoji(){
	$emoji = array();
	for ($i = 1 ; $i <= 36; $i++) {
		if(file_exists('storage/emoji/icon/'.$i.'.png'))

			$emoji['default']['#Q'.$i.'Q#'] ="<img src='storage/emoji/icon/".$i.".png' class='img-circle' style='margin: 0px 3px;' height='30px' width='30px' alt=''>";
		if(file_exists('storage/emoji/icon/n'.$i.'.png'))
			$emoji['face']['#Qn'.$i.'Q#'] ="<img src='storage/emoji/icon/n".$i.".png' class='img-circle' style='margin: 0px 3px;' height='30px' width='30px' alt=''>";
		if(file_exists('storage/emoji/icon/g'.$i.'.gif'))
			$emoji['gif']['#Qg'.$i.'Q#'] ="<img src='storage/emoji/icon/g".$i.".gif' class='img-circle' style='margin: 0px 3px;' height='30px' width='30px' alt=''>";
	}
	return $emoji;
}
function getAvatar($avatar){
	return ($avatar ==null || $avatar == "")?"upload/image/default/default-avatar.png":$avatar;
}
function convertStringEmoji($string){
	$emoji = arrayEmoji();
	foreach ($emoji['default'] as $key => $value) {
		$string =str_replace($key, $value, $string);
	}
	foreach ($emoji['face'] as $key => $value) {
		$string =str_replace($key, $value, $string);
	}
	foreach ($emoji['gif'] as $key => $value) {
		$string =str_replace($key, $value, $string);
	}
	return $string;
}

function pathFile($name,$id,$status = false){
	$dir = $status?url(''):dirname($_SERVER["SCRIPT_FILENAME"]);
	$path = array(
		"category"=>$dir."/upload/image/category/",
		"product"  => $dir."/upload/image/product/",
		"user"  => $dir."/upload/image/user/",
	);
	return $path[$name].$id; 
}
function imageCategory($id){
	$dir = pathFile("category",$id);
	$image = url('')."/upload/image/empty.jpg";
    if (is_dir($dir)){
        if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
                if(strpos($file,'.jpg') || strpos($file,'.png') || strpos($file,'.jpeg'))
                	$image = pathFile("category",$id,true)."/".$file;
            }
            closedir($dh);
        }
    }
    return $image;
}
function RqankColor($core){
	$color = array(
		1=>"#F03B3B",
		2=>"#E231ED",
		3=>"#3C2EEF",
		4=>"#38F2C0",
		5=>"#44D927",
		6=>"#825d00",
		7=>"#504D4D"
	);
    if($core >= 500) return $color[1];
	if($core >= 350) return $color[2];
	if($core >= 225) return $color[3];
	if($core >= 125) return $color[4];
	if($core >= 50) return $color[5];
	if($core >= 15) return $color[6];
	return $color[7];
}
function colorRoles($roleName){
	if($roleName == "System Admin") return '<span style="color: #F03B3B; font-weight:bold;">'.$roleName.'</span>';
	elseif($roleName == "Admin") return '<span style="color: #E231ED; font-weight:bold;">'.$roleName.'</span>';
	elseif($roleName == "Manager") return '<span style="color: #3C2EEF; font-weight:bold;">'.$roleName.'</span>';
	elseif($roleName == "Employee") return '<span style="color: #44D927; font-weight:bold;">'.$roleName.'</span>';
	else return '<span style="color: #504D4D; font-weight:bold;">'.$roleName.'</span>';
}
function adddotstring($strNum) {
	$strNum.="";
	$len = strlen($strNum);
    $counter = 3;
    $result = "";
    $x = 0;
    $kt = false;
    for($i = 0; $i < $len; $i++) 
        if($strNum[$i] == "."){ 
            $kt = true; break; 
        }
    if($kt){
        while($strNum[$len-1] !="."){
        	$result=$strNum[$len-1].$result;
        	$len--;
        }
        if($strNum[$len-1] == ".") {
    		$result=$strNum[$len-1].$result;
        	$len--;
        }
    }
    for($i = $len - 1; $i >=0; $i--){
    	$x++;
    	$result = $strNum[$i].$result;
    	if($x % $counter == 0 && $i!=0){
    		$result = ','.$result;	
    	}
    }
    return $result;
}
function familyCategory($cate,$check = false)
{
	$s = "";
	if($check == true)
		$s .= $cate->name;
	while($cate->parent_id!==null){
		$s = $cate->parent->name." > ".$s;
		$cate = $cate->parent;
	}
	$s =trim($s,"> ");
	return $s;
}
function idParentCategory($cate,$class)
{	
	// echo $cate->category->id; 
	if($cate->id == $class) return 1;
	while($cate->parent_id!=NULL){
		if($cate->parent_id == $class) return 1;
		$cate = $cate->categoryParent;
	}
	return 0;
}
function dateOnline($date){
	$strAns;
	date_default_timezone_set('Asia/Ho_Chi_Minh');
    $now = date("Y-m-d H:i:s");
    $first_date = strtotime($now);
    $second_date = strtotime($date);
    $online = $first_date - $second_date;
   	$s = 1; $m = $s*60; $h = $m*60; $d = $h*24; $w = $d*7; $M = $d*30; $y = $d*365; 
    $s = floor($online/$s); $m =floor($online/$m); $h = floor($online/$h); 
    $d = floor($online/$d); $w =floor($online/$w); $M = floor($online/$M); $y = floor($online/$y); 
    if($s < 60) return $s." seconds ago";
    if($m < 60) return $m." minutes ago";
    if($h < 24) return $h." hours ago";
    if($d < 7) return $d." days ago";
    if($w < 4) return $w." weeks ago";
    if($M < 12) return $M." months ago";
    return $y." years ago";
}

function ckeditor($id,$demo='full',$color='',$height=300){
	$code ="<script>
		config = {};
		config.height= ".$height.";
		config.entities_latin = false;
		config.uiColor = '".$color."' ;";
	
	if($demo == 'quy'){

		$code .= "config.toolbarGroups = [
				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
				{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
				{ name: 'forms', groups: [ 'forms' ] },
				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
				{ name: 'links', groups: [ 'links' ] },
				{ name: 'insert', groups: [ 'insert' ] },
				{ name: 'styles', groups: [ 'styles' ] },
				{ name: 'colors', groups: [ 'colors' ] },
				{ name: 'tools', groups: [ 'tools' ] },
				{ name: 'others', groups: [ 'others' ] },
				{ name: 'about', groups: [ 'about' ] }
			];

			config.removeButtons = 'Checkbox,Radio,TextField,Textarea,Select,Form,Button,ImageButton,HiddenField,Templates,Preview,Print,CopyFormatting,RemoveFormat,BidiLtr,BidiRtl,Language,Flash,ShowBlocks,About,Subscript,Superscript,CreateDiv,Blockquote,Anchor,Unlink,Link';

				
		";
	}elseif($demo == 'standar'){
		$code.="config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'spellchecker', 'find', 'selection', 'editing' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		'/',
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
		];

		config.removeButtons = 'Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Find,Replace,SelectAll,Flash,PageBreak,Iframe,Save,NewPage,Preview,Print,Templates,Checkbox,Subscript,Superscript,CreateDiv,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,Smiley,BidiLtr,BidiRtl,Language,Font,FontSize,TextColor,BGColor,ShowBlocks,CopyFormatting,About';
		";
	}
	elseif($demo== 'basic'){
		$code .="config.toolbarGroups = [
			{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
			{ name: 'editing', groups: [ 'spellchecker', 'find', 'selection', 'editing' ] },
			{ name: 'insert', groups: [ 'insert' ] },
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			{ name: 'forms', groups: [ 'forms' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
			{ name: 'links', groups: [ 'links' ] },
			{ name: 'tools', groups: [ 'tools' ] },
			{ name: 'document', groups: [  'document', 'doctools' ] },
			{ name: 'styles', groups: [ 'styles' ] },
			{ name: 'colors', groups: [ 'colors' ] },
			{ name: 'others', groups: [ 'others' ] },
			{ name: 'about', groups: [ 'about' ] }
		];

		config.removeButtons = 'Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Find,Replace,SelectAll,Flash,PageBreak,Iframe,Save,NewPage,Preview,Print,Templates,Checkbox,Subscript,Superscript,CreateDiv,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,Smiley,BidiLtr,BidiRtl,Language,Font,FontSize,TextColor,BGColor,ShowBlocks,CopyFormatting,About,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Anchor,Image,Table,HorizontalRule,SpecialChar,Styles,Format,Blockquote,Underline,Strike,RemoveFormat,Scayt';
		";
	}elseif($demo=='full'){
		$code.='';
	}
	if($demo=='img'){
		$code.="config.toolbarGroups = [
			{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
			{ name: 'insert', groups: [ 'insert' ] },
			{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
			{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
			{ name: 'forms', groups: [ 'forms' ] },
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
			{ name: 'links', groups: [ 'links' ] },
			{ name: 'styles', groups: [ 'styles' ] },
			{ name: 'colors', groups: [ 'colors' ] },
			{ name: 'tools', groups: [ 'tools' ] },
			{ name: 'others', groups: [ 'others' ] },
			{ name: 'about', groups: [ 'about' ] }
		];
		config.removeButtons = 'Save,Source,Templates,Cut,Copy,Paste,PasteText,Redo,Undo,Find,Replace,SelectAll,Scayt,Form,Radio,TextField,Textarea,Select,Button,ImageButton,Link,BidiLtr,JustifyLeft,Blockquote,Outdent,NumberedList,BulletedList,CreateDiv,Indent,JustifyCenter,JustifyBlock,JustifyRight,Language,BidiRtl,Unlink,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Styles,Format,Font,FontSize,BGColor,TextColor,ShowBlocks,About,Bold,CopyFormatting,RemoveFormat,Italic,Underline,Strike,Subscript,Superscript,Anchor,Checkbox,HiddenField,PasteFromWord,Print,NewPage,Preview';
	";
	}
	$code .="config.filebrowserBrowseUrl='../../../ckeditor/ckfinder/ckfinder.html';
			config.filebrowserUploadUrl = '../../../ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
			config.filebrowserWindowWidth = '1000';
			config.filebrowserWindowHeight = '700';
	";
	$code .="CKEDITOR.replace('".$id."',config);</script>";
	return $code;
}

?>