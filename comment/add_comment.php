<?php

require_once("include/config.php");

$error = '';
$comment_name = '';
$comment_content = '';

if(empty($_POST["comment_name"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
else
{
 $comment_name = $_POST["comment_name"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}

if($error == '')
{
 $sql = "INSERT INTO comment (pcomment_id,comment,username) VALUES (?,?,?)";
 $stmt=mysqli_prepare($conn,$sql);
if(!$stmt)
{
echo "error stmt not prepared  ",mysqli_error($conn);
}
else
{
mysqli_stmt_bind_param($stmt,"iss",$_POST["comment_id"],$comment_content,$comment_name);
mysqli_stmt_execute($stmt);
mysqli_stmt_get_result($stmt);
$error = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>