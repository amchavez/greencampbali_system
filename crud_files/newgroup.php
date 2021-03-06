<?php
session_start();
/*
Allows the user to both create New Group Detailss and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/Edit Group Details form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($group = '', $address = '', $cperson = '', $cnumber = '', $camp ='', $start = '', $end = '', $error = '', $id = '')
	{ 
		?>
			<!DOCTYPE HTML>
				<html>
				<head>
				<title>
					<?php if ($id != '') { echo "Edit Group Details"; 
					header("Location: record2.php");} else { echo "New Group Details"; } ?>
				</title>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
				</head>
				<body>
					<h1><?php if ($id != '') { echo "Edit Group Details"; } else { echo "New Group Details"; } ?></h1>
							<?php if ($error != '') {
							echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error. "</div>";
				} ?>

<form action="" method="post">
<div>
<?php if ($id != '') { ?>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<p>ID: <?php echo $id; ?></p>
<?php } ?>

		
          <h1>Customer's Information</h1>
          
                
            <div class="field-wrap">
            <label>
              Group Name<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="groupname"
			 value="<?php echo $group; ?>"/>
          </div>
         
          <div class="field-wrap">
            <label>
              Group Address
            </label>
            <input type="text" required autocomplete="off" name="groupaddress"
			value="<?php echo $address; ?>"/>
          </div>
          
		   <div class="field-wrap">
            <label>
              Group Contact Person<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="groupcperson"
			value="<?php echo $cperson; ?>"/>
          </div>
		  
		  <div class="field-wrap">
            <label>
              Group Contact Number<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="groupcnumber"
			value="<?php echo $cnumber; ?>"/>
          </div>
		  
		  <div class="field-wrap">
            <label>
              Camp Name<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="campname"
			value="<?php echo $camp; ?>"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Camp Start Date<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="campstartdate"
			value="<?php echo $start; ?>"/>
          </div>
		  
		  <div class="field-wrap">
            <label>
              Camp End Date<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="campenddate"
			value="<?php echo $end; ?>"/>
          </div>
          
          <button class="button button-block" type="submit" name="submit"  value="submit"/></a>Add Participants</button>
		 
       </div>
    </form>

       


  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>
</body> 
</html>

<?php }


// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// get the form data
$groupname = htmlentities($_POST['groupname'], ENT_QUOTES);
$groupaddress = htmlentities($_POST['groupaddress'], ENT_QUOTES);
$groupcperson = htmlentities($_POST['groupcperson'], ENT_QUOTES);
$groupcnumber = htmlentities($_POST['groupcnumber'], ENT_QUOTES);
$campname = htmlentities($_POST['campname'], ENT_QUOTES);
$campstartdate = htmlentities($_POST['campstartdate'], ENT_QUOTES);
$campenddate = htmlentities($_POST['campenddate'], ENT_QUOTES);
// check that groupname and campname are both not empty
if ($groupname == '' || $groupcperson == '' || $groupcnumber == '' || $campname == '' || $campstartdate == '' || $campenddate == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($groupname, $groupaddress, $groupcperson, $groupcnumber, $campname, $campstartdate, $campenddate, $error);
}
else
{
// insert the New Group Details into the database
if ($stmt = $mysqli->prepare("INSERT campgroup (groupname, groupaddress, groupcperson, groupcnumber, campname, campstartdate, campenddate) VALUES (?, ?, ?, ?, ?, ?, ?)"))
{
$stmt->bind_param("sssssss", $groupname, $groupaddress, $groupcperson, $groupcnumber, $campname, $campstartdate, $campenddate);
$stmt->execute();
$stmt->close();

}

// show an error if the query has an error
else
{
echo "ERROR: Could not prepare SQL statement.";
}
$_SESSION['group_name']=$_POST['groupname'];
// redirec the user
header("Location: addparticipant.php");
}

}
// if the form hasn't been submitted yet, show the form
else
{
renderForm();
}


// close the mysqli connection
$mysqli->close();
?>
