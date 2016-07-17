<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">

    <title><?php echo $page_title; ?></title>
    <!-- <link rel="stylesheet" type="text/css" href= "../style.css"  media="screen" /> -->

</head>

<body style="font-family: Arial; ">
	<div id="lftbx" style="height: 100%; margin-top: -2%">
	    <br><br>
	    <ul id="lful">
	      <li><a href="../user.php" >Home</a></li>
	      <li><a href="../scheduleTable.php" >Bus schedule</a></li>

	      <?php if($uid == true): ?>
			<li><a href="../route.php" >Add New Route</a></li>
	      	<li><a href="../station.php" >Add New Station</a></li>
	      	<li><a href="../driver.php" >Add New Driver</a></li>
	      <?php endif ?>
	     
	      <li><a href="../stat.php" >Statistics</a></li>
	    </ul>
	  </div>

</body>
</html>
