<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "<p>You must be logged in to access this page.</p>";
} else {

if (isset($_SESSION["groups"])) {
    $groups = $_SESSION["groups"];
}

$url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.usersfy/members/" . $_GET['gid'];
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HTTPGET, TRUE);

$response = curl_exec($curl);
$groupMembers = json_decode($response, true);
curl_close($curl);
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .groupTable {
            text-align: center;
            font-size: 20px;
            width: 60%;
        }

        .groupTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
        }

        .groupTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            background: #f7f7f7;
        }

    </style>

    <meta charset="UTF-8">
    <title> Group Info </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <link rel="stylesheet" href="css/NavBarStyle2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>

<nav class="navbar navbar-expand-sm">

    <div class="d-inline-block">
        <?php
        echo "<a href='home.php'><i><image src='images/icon.PNG' style='width:100px;height:100px;'></i></a>";
        ?>
    </div>

</nav>

<hr>
<div class="container">
    <?php
    echo "<table class='groupTable' align='center'>";
    echo "<tr><th>Group " . $_GET['gid'] . " - Members</th></tr>";

    if (sizeof($groupMembers) == 0) {
        echo "<tr><td>There are no student assigned to this group.</td></tr>";
    } else {
        foreach ($groupMembers as $member) {
            echo "<tr><td>" . $member['firstname'] . " " . $member['surname'] . "</td></tr>";
        }
    }

    echo "</table>";
    ?>
</div>
</body>
<?php } ?>

