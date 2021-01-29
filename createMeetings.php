<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Log In </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Styles.css">
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
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="container">
        <div class="row1">
            <h3>Create Meeting</h3>
        </div>
        <hr>

        <div class="row">
            <label for="weekNum"><strong>Week Number:</strong> </label><br>
            <input type="number" placeholder="Enter Number" name="weekNum" required>
        </div><br>
        <div class="row">
            <label for="topic"><strong>Topic:</strong> </label><br>
            <input type="text" placeholder="Enter Topic" name="topic" required>
        </div>
        <div class="row">
            <label for="description"><strong>Description:</strong> </label><br>
            <textarea rows="5" cols="70" name="description" placeholder="Areas to cover during meeting.."
                      required></textarea><br>
        </div>

        <div class="row">
            <input type='submit' class='btn btn-outline-success' value='Create Meeting'/>
        </div>
    </div>
</form>

<?php
if ($_POST) {
    $weekNum = $_POST['weekNum'];
    $topic = $_POST['topic'];
    $description = $_POST['description'];

    if (isset($_SESSION["groups"])) {
        $groups = $_SESSION["groups"];
    }

    foreach ($groups as $group) {
        $g = json_encode($group, true);
        $jsonToSend = '{"building":null, "description":"' . $description . '","gid":' . $g . ', "gmid": "", "latitude": null, "longitute": null, "room": null, "strDate": null, "topic" : "' . $topic . '", "weekNum": "' . $weekNum . '"}';
        //$payload = json_encode(array("groups" => $jsonToSend));

        $url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.groupmeetings";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonToSend);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            die('Couldn\'t send request: ' . curl_error($curl));
        } else {
            $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($resultStatus == 204) {

                echo "<div class='alert alert-info'>";
                echo 'has been created.';
                echo "<meta http-equiv='refresh' content='1.5;url=home.php'>";
                echo "</div>";

            } else {
                die('Request failed: HTTP status code: ' . $resultStatus);
            }
        }
    }

    curl_close($curl);
}
?>
