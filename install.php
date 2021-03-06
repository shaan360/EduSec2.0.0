<?php
$flag = 0;
$error_list = array();

if(!version_compare(PHP_VERSION, "5.3.2", ">=")) {
  $error_list[] = 'Need atleast or greater version of PHP 5.3.2';
  $flag = 1;
}

$canDo = array();
$canDo['phpmail'] = @ini_get('sendmail_path') && function_exists('mail');
if($canDo['phpmail']){
	// Check for valid, existing sendmail_path
	$smpath = explode(' ', ini_get('sendmail_path'));
	$smpath = $smpath[0];
	$canDo['phpmail'] = is_executable($smpath);
	if(!$canDo['phpmail']) {
	 $error_list[] = 'Php Mail function not enable. Refer <a href="http://www.rudrasoftech.com/forum/forum/view/id/7" target="_blank">this link</a> to enable Mail function.';
	  $flag = 1;
	}
}
else {
	 $error_list[] = 'Php Mail function not enable. Refer <a href="http://www.rudrasoftech.com/forum/forum/view/id/7" target="_blank">this link</a> to enable Mail function.';
	$flag = 1;
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
	<meta charset="UTF-8" />
	<meta name="language" content="en" />
	<title>Edusec Installation</title>
<link href="<?php echo $_SERVER['REQUEST_URI']?>/../css/installation.css" type="text/css" rel="stylesheet">
    </head>
   <body>
   <div class="container">
   <div class="content">
	<div class="header">
		<div class="app-logo">
		   <img src="<?php echo $_SERVER['REQUEST_URI']?>/../images/product.png" alt="logo" /> 
		</div>
		<h1 class="title">Installation Page</h1>
		<span>Welcome to the Edusec application installer! We need to collect a little information before we can get your application up and running.</span>
	</div>
	

<?php if($flag == 1) { ?>
	<div class="require-note">
	<ul class="error-list">
	<h1 class="title">Cannot install Edusec </h1> 
<?php	
	foreach($error_list as $err)
	   echo "<li>".$err."</li>";
	echo '</ul></div>';
}

else {
	unlink('install.php');

    echo '<div class="req-finish">';
    echo 'System requirement checking successfully completed <a href="site/confirmForm.php">Click here</a> for database connectivity</div>';
}
?>

</div></div>
</body>
</html>


