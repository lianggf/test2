<?php
	include_once('main.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<title>无标题文档</title>

<style type="text/css">
.title {
	text-align:center;
}
table {
	border-collapse:collapse;
	font-size:14px;
}
th {
	width:auto;
}
td, th {
	border: 1px solid #ccc;
	border-spacing: 0;
	padding: 4px 4px;
}
.col-idx {
	width:60px;
	text-align:center;
}
.col-file {
	width:360px;
}
.col-size {
	width:120px;
	text-align:right;
}
.col-level {
	width: 80px;
	text-align: center;
}
.col-download {
	width:80px;
	text-align:center;
}
a {
	color:#0000ee;
	text-decoration:none;
}
</style>
</head>

<body>
<h3 class="title">文件下载测试页面</h3>
<div class="container">
	<a href="clear.php">[清除全部文件]</a>
	<table>
		<tr><th>#</th><th>文件</th><th>大小</th><th>加密级别</th><th>下载</th></tr>
	</table>
</div>
<script src="jquery.min.js" ></script>
<script type="text/javascript">
$(document).ready(function(e) {
	/*var data = [
		{"file":"abc.doc", "size":"156.00 KB"},
		{"file":"abc.doc", "size":"156.00 KB"},
		{"file":"abc.doc", "size":"156.00 KB"},
		{"file":"abc.doc", "size":"156.00 KB"},
		{"file":"abc.doc", "size":"156.00 KB"}
	];*/
	
	var data = <?php echo get_files(); ?>
	
	var table = $("table");
	for (var i=0; i<data.length; i++) {
		var tr = "<tr><td class=\"col-idx\">"+(i+1)+"</td><td class=\"col-file\">"+decodeURI(data[i].file)+"</td><td class=\"col-size\">"+data[i].size+"</td><td class=\"col-level\">"+data[i].level+"</td><td class=\"col-download\"><a href=\"download.php?level="+data[i].level+"&file="+data[i].file+"\">下载</a></td></tr>";
		table.append(tr);
	}
});
</script>
</body>
</html>
