<?php
session_start();
?>

<!DOCTYPE html>
<html>
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
$url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.userssy/getAvailGroupLeaders";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HTTPGET, TRUE);

$response = curl_exec($curl);
$json = json_decode($response, true);
curl_close($curl);

if (!sizeof($json) == 0) {
    ?>
    <hr>
    <div class="container">
        <form action="createGroup.php" method="post" id="createGroup">
            <h5>Select group leader:</h5>
            <select id="leader" name="leader">
                <?php
                foreach ($json as $leader) {
                    echo "<option value ='" . json_encode($leader) . "'>";
                    echo $leader['firstname'] . " " . $leader['surname'];
                    echo "</option>";
                }
                ?>
            </select>

            <input type="submit" value="Create Group">
        </form>
    </div>

    <?php
} else {
    ?>
    <hr>
    <div class="container">
        <div class='alert alert-info'>
            <h5>There are no available student leaders available to create a new group.</h5>
            <meta http-equiv='refresh' content='3.5;url=home.php'>
        </div>
    </div>

    <?php
}
if ($_POST) {
    $a = $_POST['leader'];

    $jsonToSend = '{"gid":"","groupLeader":' . $a . '}';
    //$payload = json_encode(array("groups" => $jsonToSend));
    $url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.groups";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonToSend);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        die('Couldn\'t send request: ' . curl_error($curl));
    }
    else {
        $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($resultStatus == 204) {

            echo "<div class='alert alert-info'>";
            echo 'New group has been created.';
            echo "<meta http-equiv='refresh' content='1.5;url=home.php'>";
            echo "</div>";

        } else {
            die('Request failed: HTTP status code: ' . $resultStatus);
        }
    }

    curl_close($curl);
}
?>



