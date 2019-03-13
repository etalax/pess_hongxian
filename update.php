<?php 
include 'navigation.php';
if(!isset($_POST["btnSearch"])){

?>

<!-- reate a form to search for patrol carbased on id -->
<fieldset>
<legend>Update Patrol car</legend>
<form name="form1" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">

<table width ="80%" border="0" align="center" cellpadding="4" cellspacing="4">

<tr>

	<td width="25%" class="td_label">Patrol Car ID:</td>
	<td width="25" class="td_Data"><input type="text" name="patrolCarId" id="patrolCarId"></td>
	<td class="td_Data"><input type="submit" name="btnSearch" id="btnSearch" value="Search"></td>
	
</tr>

</table>
</form>	
</fieldset>
<?php } else {
				// out later
				//echo $_POST["petrolcar"];
				//echo $_POST["patrolCarStatusId"];
				
				$con = mysql_connect("localhost","hongxian","password");
				if(!$con){
					die('cannot connect to database:'.mysql_error());
				}
				mysql_select_db("31_hongxian_pessdb",$con);
				$sql = "SELECT * FROM patrolcar WHERE patrolcarId='".$_POST['patrolCarId']."'";

				$result = mysql_query($sql,$con);
				
				$patrolCarId;
				
				$patrolCarStatusId;
				
				while($row = mysql_fetch_array($result)){
					$patrolCarId = $row['patrolcarId'];
					$patrolCarStatusId = $row['patrolcarStatusId'];
				}
				
				$sql = "SELECT * FROM patrolcar_status";
				
				$result = mysql_query($sql,$con);
				
				$patrolCarStatusMaster;
				
				while($row = mysql_fetch_array($result)){
					$patrolCarStatusMaster[$row['statusId']] = $row['statusDesc'];
				}
				
				mysql_close($con);
?>
<fieldset style="margin-left:30.5%;">
<legend>Update Patrol car</legend>
<form name="form2" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">

<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">

<!-- <tr>
	<td width="25%" class="td_label">Patrol Car ID:</td>
	<td width="25%" class="td_Data"><?php echo $_POST["patrolCarId"]?> </td>
</tr> -->

<tr>
<td width="25%" class="td_label">Patrol Car ID:</td>
<td width="25%" class="td_Data"><?php echo $_POST["patrolCarId"]?>
<input type="hidden" name="patrolCarId" id="patrolCarId" value="<?php echo $_POST["patrolCarId"]?>">
<input type="hidden" name="patrolCarStatus" id="patrolCarStatus" value="<?php echo $_POST['patrolCarStatus']; ?>">
</td>
</tr>

<tr>

	<td class="td_label">Status:</td>
	<td class="td_Data"><select name="patrolCarStatus" id="$patrolCarStatus">
	
	<?php foreach($patrolCarStatusMaster as $key => $value){ ?>
			
			<option value="<?php echo $key ?>"
			<?php if($key==$row['patrolCarStatusId']) {?> selected="selected"
			<?php } ?>>
			<?php echo $value ?>
			</option>
	<?php } ?>
	
	</select>	
	</td>
	</tr>
	
	<!--input type="hidden" name="patrolCarStatus" id="patrolCarStatus" value=""-->
</table>
<br/>
<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">

<tr>
<td width="46%" class="td_label"><input type="reset" name="btnCancel" id="btnCancel" value="Reset"></td>
<td width="54%" class="td_Data">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnUpdate" id="btnUpdate" value="Update">

</td>
</tr>

<!--- new line/ check point/// nvm zzz

<tr>
<td width="25%" class="td_label">ID:</td>
<td width="25%" class="td_Data"><?php echo $_POST["patrolCarId"]?>
<input type="hidden" name="patrolCarId" id="patrolCarId" value="<?php echo $_POST["patrolCarId"]?>">
</td>
</tr>
 code end -->

</table>
</form>
</fieldset>
<?php }?>

<!--- new line/ check point --->

<?php 

if(isset($_POST["btnUpdate"])){
	//retrive patrol car status and patrolcarstatus, need to connect to server/ database
	$con = mysql_connect("localhost","hongxian","password");
	
	if(!$con){
		die('Cannot connect to database! ERROR25!!:'.mysql_error());
	}
	mysql_select_db("31_hongxian_pessdb",$con);
	
	//UPDATE PATROL CAR STATUS!!IMPORTEN!!
	$sql="UPDATE patrolcar SET patrolcarStatusId='".$_POST["patrolCarStatus"]."' WHERE patrolcarId='".$_POST['patrolCarId']."'";
	
	if(!mysql_query($sql,$con)){
		die('error4:'.mysql_error());
	}


	if($_POST["patrolCarStatus"]=='4'){
		$sql = "UPDATE dispatch SET timeArrived=NOW() WHERE timeArrived is NULL AND patrolcarId='".$_POST["patrolCarId"]."'";

		if(!mysql_query($sql,$con)){
			die('ERROR4:'.mysql_error());
		}
	}

else if($_POST["patrolCarStatus"]=='3'){
	// else if patrol car status is free then capture the time of completion
	$sql= "SELECT incidentId FROM dispatch WHERE timeCompleted IS NULL AND patrolcarId='".$_POST["patrolCarId"]."'";
	
	$result=mysql_query($sql,$con);
	
	$incidentId;
	
	while($row = mysql_fetch_array($result)){
		$incidentId = $row['incidentId'];
	}
	
	$sql="UPDATE dispatch SET timeCompleted=NOW() WHERE timeCompleted is NULL AND patrolcarId='".$_POST["patrolCarId"]."'";
	
	if(!mysql_query($sql,$con)){
		die('Error4:'.mysql_eror());
	}

$sql="UPDATE incident SET incidentStatusId='3' WHERE incidentId='$incidentId'
AND incidentId NOT IN (SELECT incidentId FROM dispatch WHERE timeCompleted IS NULL)";

if(!mysql_query($sql,$con)){
	die('Error5:'.mysql_error());
}
}
mysql_close($con);

?>

<script type="text/javascript">windown.location="./logcall.php";</script>
<?php }	?>