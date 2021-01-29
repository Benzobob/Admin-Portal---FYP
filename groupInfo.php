<?php
session_start();

if (isset($_SESSION["groups"])) {
    $groups = $_SESSION["groups"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <style>

        .groupTable {
            text-align: center;
            font-size: 20px;
            width: 200px;
            margin: 20px;
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

        .container > div {
            display: inline-block;
            box-sizing: border-box;
            width: 50%;
            padding: 15px;
            max-width: 250px;
            min-width: 200px;
        }




    </style>

        <meta charset="UTF-8">
        <title> Group Info </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">
        <link rel="stylesheet" href="css/NavBarStyle2.css">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<nav class="navbar navbar-expand-sm">

    <div class="d-inline-block">
        <?php
        echo "<a href='home.php'><i><image src='images/icon.PNG' style='width:100px;height:100px;'></i></a>";
        ?>
    </div>


    <div class="d-inline-block" id="navbarSupportedContent">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="icon-bar">
                <a href="Logout.php" title="Logout"><i class="fa fa-share-square-o"></i></a>
            </div>
        </div>
    </div>
</nav>

<hr>
<h3 style="text-align: center">Groups</h3>
<div class="container">
    <?php
    foreach ($groups as $group) {
        echo "<div>";
        echo "<table class='groupTable'>";
        echo "<tr><th>Group " . $group['gid'] . "</th></tr>";
        echo "<tr><td>" . $group['groupLeader']['firstname'] . " " . $group['groupLeader']['surname'] . "</td></tr>";
        echo "<tr onclick=\"window.location='groupMembers.php?gid=" . $group['gid'] . "';\"><td><button>Group Members</button></td></tr>";
        echo "<tr onclick=\"window.location='groupMeetings.php?gid=" . $group['gid'] . "';\"><td><button>Group Meetings</button></td></tr>";
        echo "</table>";
        echo "</div>";
    }
    ?>
</div>
</body>





