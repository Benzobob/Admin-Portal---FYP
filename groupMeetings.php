<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "<p>You must be logged in to access this page.</p>";
} else {
    if (isset($_SESSION["groups"])) {
        $groups = $_SESSION["groups"];
    }
    $url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.groupmeetings/getMeetingsByGroup/" . $_GET['gid'];
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPGET, TRUE);

    $response = curl_exec($curl);
    $meetings = json_decode($response, true);
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

<br>
<h3 style="text-align: center">Meetings - Group <?php echo $_GET['gid']; ?></h3>
<hr>

<div class="container">
    <?php
    if (sizeof($meetings) == 0) {
        echo "<p>There are no meetings assigned to this group.</p>";
    } else {
        foreach ($meetings as $meeting) {
            echo "<table class='groupTable' align='center'>";
            echo "<tr><th colspan=\"2\">Week - " . $meeting['weekNum'] . "</th></tr>";

            if (isset($meeting['topic'])) {
                if ($meeting['description'] != null) {
                    echo "<tr><td width='50%'>Topic</td>";
                    echo "<td>" . $meeting['topic'] . "</td></tr>";
                } else {
                    echo "<tr><td colspan='2'>Topic is not set.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Topic is not set.</td></tr>";
            }

            if (isset($meeting['description'])) {
                if ($meeting['description'] != null) {
                    echo "<tr><td width='50%'>Description</td>";
                    echo "<td>" . $meeting['description'] . "</td></tr>";
                } else {
                    echo "<tr><td colspan='2'>Description is not set.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Description is not set.</td></tr>";
            }

            if (isset($meeting['strDate'])) {
                $pieces = explode("T", $meeting['strDate']);
                echo "<tr><td width='50%'>Date</td>";
                echo "<td>" . $pieces[0] . " " . $pieces[1] . "</td></tr>";
            } else {
                echo "<tr><td colspan='2'>Date is not set.</td></tr>";
            }

            if (isset($meeting['building'])) {
                if ($meeting['building'] != null) {
                    echo "<tr><td width='50%'>Location</td>";
                    echo "<td>" . $meeting['building'] . "</td></tr>";
                } else {
                    echo "<tr><td colspan='2'>Location is not set.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Location is not set.</td></tr>";
            }

            echo "</table><hr>";
        }
    }

    ?>
</div>
</body>
    <?php
}
?>

