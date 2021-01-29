<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "<p>You must be logged in to access this page.</p>";
} else {
    $url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.groups";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPGET, TRUE);

    $response = curl_exec($curl);
    $json = json_decode($response, true);
    $_SESSION['groups'] = $json;
    curl_close($curl);
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

        .group, .meeting {
            padding-bottom: 50px;
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

        #tableOpt tr:hover {
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
                    <a href="logout.php" title="Logout"><i class="fa fa-share-square-o"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <hr>
    <div class="options">
        <div class="group">
            <table id="tableOpt">
                <tr>
                    <th>Groups</th>
                </tr>
                <tr onclick="window.location='createGroup.php';">
                    <td>Create New Group</td>
                </tr>
                <tr onclick="window.location='selectGroup.php';">
                    <td>Assign First Year Students To Group</td>
                </tr>
                <tr onclick="window.location='groupInfo.php';">
                    <td>Group Information</td>
                </tr>
            </table>
        </div>
        <div class="meeting">
            <table id="tableOpt">
                <tr>
                    <th>Meetings</th>
                </tr>
                <tr onclick="window.location='createMeetings.php';">
                    <td>Create Meetings</td>
                </tr>
                <tr>
                    <td>Edit Meeting</td>
                </tr>
            </table>
        </div>
        <div class="Attendace">
            <table id="tableOpt">
                <tr>
                    <th>Attendance</th>
                </tr>
                <tr onclick="window.location='selectGroupAttendance.php';">
                    <td>Check Attendance</td>
                </tr>
            </table>
        </div>

    </div>

    </body>
    </html>
<?php } ?>