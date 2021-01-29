<?php
session_start();
$url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.groupmeetings/getMeetingsByGroup/" . $_GET['gid'];
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
$response = curl_exec($curl);
$json = json_decode($response, true);
$meetingNum = sizeof($json);
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


    #tableOpt {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 95%;
        margin-bottom: 20px;

    }

    #tableOpt td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    #tableOpt tr:nth-child(even) {
        background-color: #f2f2f2;
    }

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<head>
    <meta charset="UTF-8">
    <title> HomePage </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
<?php
if ($meetingNum == 0) {
    echo "<h5> There are no meetings set for this group. </h5>";
} else {
    ?>
    <br>
    <h5 style="text-align: center">Meetings</h5>

    <hr>
    <div class="options">
        <?php
        foreach ($json as $meet) {

            $url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.attendance/getAttendanceForMeeting/" . $meet['gmid'];
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
            $response = curl_exec($curl);
            $attendance = json_decode($response, true);
            curl_close($curl);

            if (isset($meet['strDate'])) {
                $s = $meet['strDate'];
                $date = strtotime($s);
                $date2 = date('d/M/Y H:i', $date);
                $date1 = date('Y/m/d H:i');
                if ($date > strtotime('now')) {
                    echo "<table id='tableOpt'>";
                    echo "<tr><th>Week: " . $meet['weekNum'] . "</th>";
                    echo "<th>Date: " . $date2 . "</th>";
                    echo "</tr>";
                    echo "<tr><td colspan='2'>This meeting has not happened yet.</td></tr>";
                } else {
                    echo "<table id='tableOpt'>";
                    echo "<tr><th>Week: " . $meet['weekNum'] . "</th>";
                    echo "<th>Date: " . $date2 . "</th>";
                    echo "</tr>";
                    echo "<tr><td>Student Name:</td>";
                    echo "<td>In attendance?</td></tr>";
                    foreach ($attendance as $rec) {
                        $here = "No";
                        if ($rec['attend'] == 1) {
                            $here = "Yes";
                        }

                        echo "<tr>";
                        echo "<td>" . $rec['fyid']['firstname'] . " " . $rec['fyid']['surname'] . "</td>";
                        echo "<td>" . $here . "</td>";
                        echo "</tr>";
                    }
                }

                echo "</table>";
            }
            else{
                echo "<table id='tableOpt'>";
                echo "<tr><th>Week: " . $meet['weekNum'] . "</th>";
                echo "</tr>";
                echo "<tr><td colspan='2'>Date has not been set.</td></tr>";
                echo "</table>";
            }
        }
        ?>
    </div>
    <?php
}

?>
</nav>
</div>
</body>
</html>
