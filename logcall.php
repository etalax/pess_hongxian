<!DOCTYPE HTML>
<html>
<head>
<title>Log Call</title>
<?php include 'navigation.php';?>
<style>



	
</style>
</head>
<body>

<?php

if(isset($_POST['Submit'])){

    $con = mysql_connect("localhost","hongxian","password");
if(!$con)
    {
    die('Cannot connect to database :'.mysql_error());
    }

mysql_select_db("31_hongxian_pessdb",$con);
$sql = "INSERT INTO incident (callerName, phoneNumber, incidentTypeid, incidentLocation, incidentDesc, incidentStatusid) 
VALUES('$_POST[callerName]','$_POST[contactNo]','$_POST[incidenttype]','$_POST[location]','$_POST[incidentDesc]','1')";
if(!mysql_query($sql,$con))
{
    die('Error: ' .mysql_error());
}

mysql_close($con);}
?>
</head>
<body>

<script>

function validateForm() {
  var x = document.forms["frmLogCall"]["callerName"].value;
  var y = document.forms["frmLogCall"]["contactNo"].value;
  var z = document.forms["frmLogCall"]["location"].value;
  var w = document.forms["frmLogCall"]["incidentDesc"].value;
  if (x == "") {
    alert("Name must be filled out"); 
  }
  else if(!isNaN(x)){
          alert("Name only in Alphabet only.");

      }


  if (y == "") {
    alert("Number must be filled out"); 
  }
  else if(isNaN(y)){
          alert("Number only.");
      }

  if (z == "") {
    alert("Please fill in the Location"); 
  }

if (w == "") {
    alert("Please fill in the Description"); 
  }

  }

</script>



<?php
$con = mysql_connect("localhost","hongxian","password");
if(!$con)
	{
	die('Cannot connect to database :'.mysql_error());
	}
	
mysql_select_db("31_hongxian_pessdb",$con);

$result = mysql_query("SELECT * FROM incidenttype");

$incidenttype;

while($row = mysql_fetch_array($result))
{
//incidentTypeId,incidentTypeDesc


$incidenttype[$row['incidentTypeId']] = $row['incidentTypeDesc'];

}

mysql_close($con);
?>



<form name="frmLogCall" method="POST" onsubmit="return validateForm();" action="dispatch.php">



<fieldset>
<legend>Log Call</legend>
<div class ="center">
<table>
	<tr>
		<td>Caller Name:</td>
		<td><p><input type="text" name="callerName"/></p></td>
	</tr>
	
	<tr>
		<td>Contact No:</td>
		<td><p><input type="text" name="contactNo"/></p></td>
	</tr>
	
	<tr>	
		<td>Location:</td>
		<td><p><input type="text" name="location"/></p></td>
	</tr>	
	
	<tr>
		<td align="right" class"td_label">Incident Type:</td>
		<td class="td_Date">
			<p>
			<select name="incidenttype" id="incidenttype">
				<?php foreach($incidenttype as $key => $value) {?>
					<option value="<?php echo $key ?>"><?php echo $value ?></option>
				<?php }?>
			</select>
			</p>
		</td>
	</tr>
	<tr>
		<td>Description:</td>
		<td><p><textarea name="incidentDesc" rows="5" cols="50"></textarea></td>
	</tr>
	
	<tr>
		<td><input type="submit" value="Process Call" name="Submit"></td>
		<td><input type="reset" name="reset" value="Reset"></td>
	</tr>
	
</table>
</div>
</form>
</fieldset>

</body>
</html>









