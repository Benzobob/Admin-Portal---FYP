<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "<p>You must be logged in to access this page.</p>";
} else {

    ?>


    <!DOCTYPE html>
    <html>
    <style>
        #tableOpt th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
        }

        .options {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
        }

        #tableOpt {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 95%;

        }

        #tableOpt td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #tableOpt tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #tableOpt tr.Hover:hover {
            background-color: #ddd;
        }

    </style>
    <head>
        <meta charset="UTF-8">
        <title> HomePage </title>
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
    <div class="options">
        <table id="tableOpt">
            <tr>
                <th colspan="2" width="75%">Select Group:</th>
            </tr>
            <tr>
                <td>Group Number:</td>
                <td>Group Leader:</td>
            </tr>
            <?php
            if (isset($_SESSION['groups'])) {
                $json = $_SESSION['groups'];
                foreach ($json as $group) {
                    echo "<tr class=\"Hover\" onclick =\"window.location='checkAttendance.php?gid=" . $group['gid'] . "';\">";
                    echo "<td width='50%'>" . $group['gid'] . "</td>";
                    echo "<td width='50%'>" . $group['groupLeader']['firstname'] . " " . $group['groupLeader']['surname'] . "</td>";
                    echo "</tr>";
                }
            }

            ?>
        </table>
    </div>
    </body>
    </html>
    <?php
}
?>