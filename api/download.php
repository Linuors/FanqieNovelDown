<?php
function download($id){
	$id = trim($id);
	$path = "/www/wwwroot/211.101.233.5/api/"; //将内容替换成你的API目录
	if ($id != "" && is_file($path . "/" . $id)) {
	    header("Content-Description: File Transfer");
	    header("Content-Type: application/octet-stream");
	    header("Content-Disposition: attachment; filename= ".basename($path . "/" . $id)." ");
	    header("Content-Transfer-Encoding: binary");
	    header("Connection: Keep-Alive");
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Pragma: public");
	    header("Content-Length: " . filesize($path . "/" . $id));
	    readfile($path . "/" . $id);
	    exit;
	}
}
$id= $_GET['id'];
download($id);
?>
