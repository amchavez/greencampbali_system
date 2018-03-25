<!DOCTYPE HTML>
<html>
<head>
<title>View Records</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php include 'css/css.html'; ?>
<h1>View Records</h1>



<?php

// connect to the database
include('connect-db.php');

//<p><b>View All</b> | <a href="view-paginated.php">View Paginated</a></p>
// get the records from the database
if ($result = $mysqli->query("SELECT * FROM campgroup order by id"))
{
// display records if there are records to display
if ($result->num_rows > 0)
{
// display records in a table
echo "<table align = 'center' border='1' cellpadding='10' color='green'>";

// set table headers
//echo "<tr>ID</th><th>Group Name</th><th>groupaddress</th><th>camp Name</th><th></th><th></th></tr>";

while ($row = $result->fetch_object())
{
// set up a row for each record
echo "<tr>";
echo "<td>ID</td>";
echo "<td>" . $row->id . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Group Name</td>";
echo "<td>" . $row->groupname . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Group Address</td>";
echo "<td>" . $row->groupaddress . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Group Contact Person</td>";
echo "<td>" . $row->groupcperson . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Group Contact Number</td>";
echo "<td>" . $row->groupcnumber . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Camp Name</td>";
echo "<td>" . $row->campname . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Camp Start Date</td>";
echo "<td>" . $row->campstartdate . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Camp End Date</td>";
echo "<td>" . $row->campenddate . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td><a href='records.php?id=" . $row->id . "'>Edit</a></td>";
echo "<td><a href='delete.php?id=" . $row->id . "'>Delete</a></td>";
echo "</tr>";
}

echo "</table>";
}
// if there are no records in the database, display an alert message
else
{
echo "No results to display!";
}
}
// show an error if there is an issue with the database query
else
{
echo "Error: " . $mysqli->error;
}

if ($result = $mysqli->query("SELECT * FROM participants order by id "))
{
// display records if there are records to display
if ($result->num_rows > 0)
{
// display records in a table
echo "<table align = 'center' border='1' cellpadding='10' color='green'>";

// set table headers
echo "<br></br>";
echo "<tr><th>No</th><th>Name</th><th>Gender</th><th>Nationality</th><th>Email Address</th><th>Medical Condition</th><th>Diet Restriction</th></tr>";

while ($row = $result->fetch_object())
{
// set up a row for each record
echo "<tr>";
echo "<td>" . $row->id . "</td>";
echo "<td>" . $row->pname . "</td>";
echo "<td>" . $row->pgender . "</td>";
echo "<td>" . $row->pnationality . "</td>";
echo "<td>" . $row->pemailadd . "</td>";
echo "<td>" . $row->pmedcond . "</td>";
echo "<td>" . $row->pdietrest . "</td>";
echo "<td><a href='record3.php?id=" . $row->id . "'>Edit</a></td>";
echo "<td><a href='delete.php?id=" . $row->id . "'>Delete</a></td>";
echo "</tr>";
}

echo "</table>";
}
// if there are no records in the database, display an alert message
else
{
echo "No results to display!";
}
}
// show an error if there is an issue with the database query
else
{
echo "Error: " . $mysqli->error;
}
// close database connection
$mysqli->close();
//<a href="records.php">Add New Record</a>
?>


  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>
</body>
</html>
