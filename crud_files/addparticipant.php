<?php
session_start();
/*
Allows the user to both create New Participant Detailss and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/Edit Participant Details form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($name = '', $gender = '', $nationality= '', $emailadd ='', $medcond = '', $dietrest = '', $error = '', $id = '')
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
          
          <form action="record3.php?id" method="post" autocomplete="off">
          
        
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
			
			 <button class="button button-block" type="submit" name="goback"/>Add Participants</button></a>
		
          <button class="button button-block" type="submit" name="submit" />Submit</button>
          
      </div>
    </form>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>
</body> 
</html>

<?php }
if(isset($_POST['goback']))
{
// to add another participant
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
renderForm($groupname, $pname, $pgender, $pnationality, $pemailadd, $pmedcond, $pdietrest, $error);
}
else
{
// insert the New Participant Details into the database
if ($stmt = $mysqli->prepare("INSERT participants (groupname, pname, pgender, pnationality, pemailadd, pmedcond, pdietrest) VALUES (?, ?, ?, ?, ?, ?, ?)"))
{
$stmt->bind_param("sssssss", $groupname, $pname, $pgender, $pnationality, $pemailadd, $pmedcond, $pdietrest);
$stmt->execute();
$stmt->close();

}

// show an error if the query has an error
else
{
echo "ERROR: Could not prepare SQL statement.";
}

// redirec the user 
header("Location: addparticipant.php");
}

}
// if the form's submit button is clicked, we need to process the form
else if (isset($_POST['submit']))
{
// get the form data
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
renderForm($groupname, $pname, $pgender, $pnationality, $pemailadd, $pmedcond, $pdietrest, $error);
}
else
{
// insert the New Participant Details into the database
if ($stmt = $mysqli->prepare("INSERT participants (groupname, pname, pgender, pnationality, pemailadd, pmedcond, pdietrest) VALUES (?, ?, ?, ?, ?, ?, ?)"))
{
$stmt->bind_param("sssssss", $groupname, $pname, $pgender, $pnationality, $pemailadd, $pmedcond, $pdietrest);
$stmt->execute();
$stmt->close();

}

// show an error if the query has an error
else
{
echo "ERROR: Could not prepare SQL statement.";
}

// redirec the user 
header("Location: view.php");
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
