<?php
	
$fileContents = $_POST['upfile'];
//$file = fopen($_FILES["upfile"]["tmp_name"], "rb");
//// 讀入圖片檔資料
//$fileContents = fread($file, filesize($_FILES["upfile"]["tmp_name"])); 
////關閉圖片檔
//fclose($file);

$fileContents = str_replace('data:image/png;base64,','', $fileContents);
$fileContents = str_replace('data:image/jpeg;base64,','', $fileContents);

$fileContents = base64_decode($fileContents);
$fileUrl = "recognition_images/".uniqid().".jpg";
$success = file_put_contents($fileUrl, $fileContents);
echo "http://140.115.80.221/PetCity/petRecognition/".$fileUrl;

?>