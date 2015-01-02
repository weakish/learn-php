<!DOCTYPE>

<html>

<head>
<title> 注册成功！</title>
</head>

<body>
<h1> 哇咔咔，你已经注册成功啦！</h1>

<p>呃……不过注册成功了好像也没什么用，因为本网站除了注册以外好像没有其他功能。</p>
<p>那么，作为补偿，我会告诉你，你的“邮箱+密码”的md5值。</p>
<p>你的邮箱是：
<?php 
$username = htmlspecialchars($_POST["name"]);
echo $username;
?>
</p>
<p>你的“邮箱+密码”的md5值是：
<?php
$passphrase = htmlspecialchars($_POST["passphrase"]);
$md5sum = md5($username . $passphrase);
echo $md5sum;

// Actually record the account

// Database info
$db_server = "localhost";
$db_user = "admin";
$db_pass = "password";
$db_name = "segmentfault";

// connect to mysql
$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

// check connection
if (mysqli_connect_errno()) {
  trigger_error("Database connection failed: " . mysqli_connect_error(), E_USER_ERROR);
}

// create table
$sql = "CREATE TABLE user(username CHAR(140), password CHAR(140))";

// record user account
mysqli_query($conn, "INSERT INTO user (username, password) VALUES ($username, $md5sum)");

// close
mysqli_close($conn);

?>
</p>
</body>

</html>
