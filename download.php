<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2015-08-05 17:08:46
 * @version $Id$
 */

$fileBaseName = $_REQUEST['file'];
$file_dir = "uploads/".$_REQUEST['file'];
$file_dir = iconv('UTF-8', 'GB2312//IGNORE', $file_dir);
$level = $_REQUEST['level'];

if (!file_exists($file_dir)) {
    exit();
}

$nSize = filesize($file_dir);
$fp = fopen($file_dir, "rb");
// 输入文件标签
Header("Content-type: application/octet-stream");
Header("Accept-Ranges: bytes");
Header("Content-Length: ".filesize($file_dir));
Header('Pragma: public');
header('encrypt-level:'.$level);
header('Content-Transfer-Encoding: base64');

$ua = $_SERVER["HTTP_USER_AGENT"];
if (preg_match("/MSIE/", $ua)) {
    header('Content-Disposition: attachment; filename="' . urlencode($fileBaseName) . '"');
}
else if (preg_match("/Firefox/", $ua)) {
    header('Content-Disposition: attachment; filename*="utf-8\'\'' . urlencode($fileBaseName) . '"');
}
else if (preg_match("/Chrome/", $ua))
{
    header('Content-Disposition: attachment; filename=' . urlencode($fileBaseName));
}
else {
    header('Content-Disposition: attachment; filename="' . urlencode($fileBaseName) . '"');
}
ob_clean();
ob_end_clean();

$buffer = 1024;

while (!feof($fp)){
    $content = fread($fp, $buffer);
    if ($content === FALSE)
    {
        break;
    }

    print $content;
    flush();
}
fclose($fp);
