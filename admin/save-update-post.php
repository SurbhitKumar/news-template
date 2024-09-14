<?php
include "config.php";
if (empty($_FILES['new-image']['name'])) {
$new_name = $_POST['old_image'];
} 
else {
$errors = array();
$file_name = $_FILES['new-image']['name'];
$file_size = $_FILES['new-image']['size'];
$file_tmp = $_FILES['new-image']['tmp_name'];
$file_type = $_FILES['new-image']['type'];
$file_ext = end( explode('.', $file_name));
$extension = array("jpeg", "jpg", "png");
if (in_array($file_ext, $extension) === false) {
$errors[] = "This extention file is not valid please choose a jpg or png file";
}
if ($file_size > 2097152)  {
$errors[] = "file size must be 2mb or lower" ;   
}
if ($file_size > 2097152)  {
$errors[] = "file size must be 2mb or lower" ;   
}
$new_name = time(). "-".basename($file_name);
$target = "upload/".$new_name;
$image_name = $new_name;
if (empty($errors)== true) {
move_uploaded_file($file_tmp,$target);
}
else{
print_r($errors);
die();}}
$sql = "UPDATE post SET title = '{$_POST["post_title"]} ', description = '{$_POST["postdesc"]}', category= '{$_POST["category"]} ' , post_img ='{$image_name} '
where post_id = {$_POST["post_id"]}; ";
if ($_POST['Old_category'] != $_POST["category"]) {
$sql .= "UPDATE category set post= post - 1 where category_id = {'Old_category'};";
$sql .= "UPDATE category set post= post + 1 where category_id = {'category'};";
}
$result = mysqli_multi_query($conn,$sql);
if($result){
header("location: {$hostname}/admin/post.php");
}
else {
echo "Query failled";
}
?>