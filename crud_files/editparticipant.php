<?php
session_start();
/*
Allows the user to both create New Participant Detailss and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/Edit Participant Details form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($group = '', $name = '', $gender = '', $nationality= '', $emailadd ='', $medcond = '', $dietrest = '', $error = '', $id = '')
{ ?>
<!DOCTYPE HTML>
<html>
<head>
<title>
<?php if ($id != '') { echo "Edit Participant Details"; } else { echo "New Participant Details"; } ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<h1><?php if ($id != '') { echo "Edit Participant Details"; } else { echo "New Participant Details"; } ?></h1>
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
          
          <form action="record3.php" method="post" autocomplete="off">
          
        
          <div class="field-wrap">
            <label>
              Name<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="pname"
			value="<?php echo $name; ?>"/>
          </div>
          
		   <div class="field-wrap">
            <label>
              Gender<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="pgender"
			value="<?php echo $gender; ?>"/>
          </div>
		  
		  <div class="field-wrap">
            <label>
              Nationality<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="pnationality"
			value="<?php echo $nationality; ?>"/>
          </div>
		  
		  <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="pemailadd"
			value="<?php echo $emailadd; ?>"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Medical Condition<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="pmedcond"
			value="<?php echo $medcond; ?>"/>
          </div>
		  
		  <div class="field-wrap">
            <label>
              Dietary Restriction<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="pdietrest"
			value="<?php echo $dietrest; ?>"/>
          </div>

          <button class="button button-block" type="submit" name="submit" />Submit</button>
          
      </div>
    </form>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>
</body> 
</html>

<?php }



/*

Edit Participant Details

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
$pname = htmlentities($_POST['pname'], ENT_QUOTES);
$pgender = htmlentities($_POST['pgender'], ENT_QUOTES);
$pnationality = htmlentities($_POST['pnationality'], ENT_QUOTES);
$pemailadd = htmlentities($_POST['pemailadd'], ENT_QUOTES);
$pmedcond = htmlentities($_POST['pmedcond'], ENT_QUOTES);
$pdietrest = htmlentities($_POST['pdietrest'], ENT_QUOTES);
// check that groupname and pemailadd are both not empty
if ($groupname == '' || $pgender == '' || $pnationality == '' || $pemailadd == '' || $pmedcond == '' || $pdietrest == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($groupname, $pname, $pgender, $pnationality, $pemailadd, $pmedcond, $pdietrest, $error, $id);
}
else
{
// if everything is fine, update the record in the database
if ($stmt = $mysqli->prepare("UPDATE participants SET groupname = ?, pname = ?, pgender = ?, pnationality = ? , pemailadd = ?, pmedcond = ?, pdietrest = ?
WHERE id=?"))
{
$stmt->bind_param("sssssssi", $groupname, $pname, $pgender, $pnationality, $pemailadd, $pmedcond, $pdietrest, $id);
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
if($stmt = $mysqli->prepare("SELECT * FROM participants WHERE id=?"))
{
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->bind_result($id, $groupname, $pname, $pgender, $pnationality, $pemailadd, $pmedcond, $pdietrest);
$stmt->fetch();

// show the form
renderForm($groupname, $pname, $pgender, $pnationality, $pemailadd, $pmedcond, $pdietrest, NULL, $id);

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
