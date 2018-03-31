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
{ ?>
<!DOCTYPE HTML>
<html>
<head>
<title>
<?php if ($id != '') { echo "Edit Group Details"; } else { echo "New Group Details"; } ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<h1><?php if ($id != '') { echo "Edit Group Details"; } else { echo "New Group Details"; } ?></h1>
<?php if ($error != '') {
echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
. "</div>";
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
          
          <button class="button button-block" type="submit" name="submit"  value="submit"/></a>Save Changes</button>
		 
       </div>
    </form>

       


  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>
</body> 
</html>

<?php }



/*

Edit Group Details

*/
// if the 'id' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['id']))
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// make sure the 'id' in the URL is valid
if (is_numeric($_POST['id']))
{
// get variables from the URL/form
$id = $_POST['id'];
$groupname = $_SESSION['group_name'];
$groupaddress = htmlentities($_POST['groupaddress'], ENT_QUOTES);
$groupcperson = htmlentities($_POST['groupcperson'], ENT_QUOTES);
$groupcnumber = htmlentities($_POST['groupcnumber'], ENT_QUOTES);
$campname = htmlentities($_POST['campname'], ENT_QUOTES);
$campstartdate = htmlentities($_POST['campstartdate'], ENT_QUOTES);
$campenddate = htmlentities($_POST['campenddate'], ENT_QUOTES);
// check that groupname and campname are both not empty
if ($groupname == '' || $groupaddress == '' || $groupcperson == '' || $groupcnumber == '' || $campname == '' || $campstartdate == '' || $campenddate == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($groupname, $groupaddress, $groupcperson, $groupcnumber, $campname, $campstartdate, $campenddate, $error, $id);
}
else
{
// if everything is fine, update the record in the database
if ($stmt = $mysqli->prepare("UPDATE campgroup SET groupname = ?, groupaddress = ?, groupcperson = ?, groupcnumber = ? , campname = ?, campstartdate = ?, campenddate = ?
WHERE id=?"))
{
$stmt->bind_param("sssssssi", $groupname, $groupaddress, $groupcperson, $groupcnumber, $campname, $campstartdate, $campenddate, $id);
$stmt->execute();
$stmt->close();
}
// show an error message if the query has an error
else
{
echo "ERROR: could not prepare SQL statement.";
}

// redirect the user once the form is updated
header("Location: view.php");
}
}
// if the 'id' variable is not valid, show an error message
else
{
echo "Error!";
}
}
// if the form hasn't been submitted yet, get the info from the database and show the form
else
{
// make sure the 'id' value is valid
if (is_numeric($_GET['id']) && $_GET['id'] > 0)
{
// get 'id' from URL
$id = $_GET['id'];

// get the recod from the database
if($stmt = $mysqli->prepare("SELECT * FROM campgroup WHERE id=?"))
{
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->bind_result($id, $groupname, $groupaddress, $groupcperson, $groupcnumber, $campname, $campstartdate, $campenddate);
$stmt->fetch();

// show the form
renderForm($groupname, $groupaddress, $groupcperson, $groupcnumber, $campname, $campstartdate, $campenddate, NULL, $id);

$stmt->close();
}
// show an error if the query has an error
else
{
echo "Error: could not prepare SQL statement";
}
}
// if the 'id' value is not valid, redirect the user back to the view.php page
else
{
header("Location: view.php");
}
}
}


// close the mysqli connection
$mysqli->close();
?>
