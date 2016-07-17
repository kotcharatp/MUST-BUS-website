<? require_once('includes/checkLogin.inc.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Language" content="th">
  <meta http-equiv="content-Type" content="text/html; charset=window-874">
  <title>Edit Driver</title>

  <?php include('includes/headerFiles.php'); ?>
  </head>

  <body style="background-color: #032a47;" >
    <?php include("layout/header.php");?>
    <?php include("layout/menu.php");?>

    <div style="margin-top: 2%; margin-left: 0%; color: white; ">
      <fieldset class="form-group" style="width: 84%; margin-left: 10%; ">
        <label align = "center" for="exampleSelect1" style="align: center; font-size: 2em; font-family: Arial;">Edit Driver</label>

      </fieldset>
    </div>

<div id="pageeditdri">
    <div id="bgg">

<?
// Connect to database 
$servername = "localhost";
$username = "atilalco_bus";
$password = "bustracker";
$dbname = "atilalco_bus";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->query("set names utf8");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if($_POST['Edit'])
    {

    $driver = $_POST['driver'];
    $driver_thai = $_POST['driver_thai'];
    $phoneNum = $_POST['phoneNum'];
    $driver_id = $_REQUEST['edit_id'];
    // แก้ไขข้อมูล

    $sql_edit = "UPDATE driver d
    SET d.driver = '$driver' , d.driver_thai = '$driver_thai' , d.phoneNum = '$phoneNum'
    WHERE d.driver_id = '$driver_id'";
    mysqli_query($conn, $sql_edit);
     ?>
        <script type="text/javascript">
          window.location.href = 'driver.php';
        </script>
        <?php

    }

//เรียกข้อมูลจาก รหัส มาแสดงใน textbox
if($_REQUEST['edit_id'] != "")
{
  $driver_id = $_REQUEST['edit_id'];
  $sql = "SELECT * FROM driver d WHERE d.driver_id='$driver_id'";
  $result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

}
//--->
?>
  <div id = "add">
<form action="editdv.php" method="post">
<label for="driver">Driver (EN)</label>
<p align="center"><input name="driver" type="text" id="la1" value="<?=$row['driver']?>" /></p>
<br />
<label for="driver_thai">Driver (TH)</label>
<p align="center"><input name="driver_thai" type="text" id="la1" value="<?=$row['driver_thai']?>" /></p>
<br />
<label for="phoneNum">Phone number</label>
<p align="center"><input name="phoneNum" type="text" id="la1" value="<?=$row['phoneNum']?>" onkeyup="autoTab(this)" onKeyPress="CheckNum()" /></p>
<br />

<p id= "sub" align="center">
<input class="btn btn-primary btn-lg" align = "center" onclick="return confirm('Confirm to Edit?')" type="submit" name="Edit" id="submitbut" value="Edit" />
</p>
<input name="edit_id" type="hidden" id="edit_id" value="<?=$_REQUEST['edit_id']?>" />


</form>
</div>

</div> <!--bbg-->
</div>
<?php include("layout/footer.php"); ?>

<script type="text/javascript">
//Function to make input tel number as 0xx-xxx-xxxx
function autoTab(obj){
    var pattern=new String("___-___-____");
    var pattern_ex=new String("-");
    var returnText=new String("");
    var obj_l=obj.value.length;
    var obj_l2=obj_l-1;
    for(i=0;i<pattern.length;i++){
      if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
        returnText+=obj.value+pattern_ex;
        obj.value=returnText;
      }
    }
    if(obj_l>=pattern.length){
      obj.value=obj.value.substr(0,pattern.length);
    }
}
</script>

<script language="javascript">
//Function to check if the input is number of not
function CheckNum(){
    if (event.keyCode < 48 || event.keyCode > 57){
          event.returnValue = false;
        }
  }
</script>

</body>
</html>
