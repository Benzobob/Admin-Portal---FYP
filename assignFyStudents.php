<?php
session_start();
//This gets the available students to be added to a group
$url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.usersfy/getStudentsNotInGroup";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HTTPGET, TRUE);

$response = curl_exec($curl);
$json = json_decode($response, true);
curl_close($curl);

//This gets the current members in the group
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

        .noHover:hover {
            pointer-events: none;
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

    </nav>

    <hr>
    <form action="<?php echo "assignFyStudents.php?gid=" . $_GET['gid'] ?>" method="post">
        <div class="options">
            <h5 style="text-align: center">Add students to group <?php echo $_GET['gid'] ?></h5>
            <table id="tableOpt">
                <tr>
                    <th colspan="3" width="75%">Available Users:</th>
                </tr>
                <tr class="noHover">
                    <td>Name:</td>
                    <td>Email:</td>
                    <td></td>
                </tr>
                <?php
                if(sizeof($json) == 0){
                    echo "<tr><td colspan='3'>All students have been added to a group.</td></tr>";
                }
                else {
                    foreach ($json as $user) {
                        echo "<tr class=\"Hover\">";
                        echo "<td>" . $user['firstname'] . " " . $user['surname'] . "</td>";
                        echo "<td>" . $user['email'] . "</td>";
                        echo "<td><input value='" . json_encode($user, true) . "' type='checkbox' name='selectedUsers[]'/></td>";
                        echo "<input value='" . $_GET['gid'] . "' name='gid' type='hidden'>";
                        echo "</tr>";
                    }
                    ?>
                    <tr>
                        <td width="75%" colspan="3"><input name="add" value="Add" type="submit"></td>
                    </tr>
                    <?php
                }
                    ?>
            </table>
        </div>
    </form>
    <hr>
    <form action="<?php echo "assignFyStudents.php?gid=" . $_GET['gid'] ?>" method="post">
    <div class="options">
        <table id="tableOpt">
            <tr>
                <th colspan="3" width="75%">Current students in group <?php echo $_GET['gid'] ?></th>
            </tr>
            <tr class="noHover">
                <td>Name:</td>
                <td>Email:</td>
                <td></td>
            </tr>
            <?php
            if(sizeof($groupMembers)==0){
                echo "<tr><td colspan='3'>There are no members in this group.</td></tr>";
            }
            else {
                foreach ($groupMembers as $user) {
                    echo "<tr>";
                    echo "<td>" . $user['firstname'] . " " . $user['surname'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td><input value='" . json_encode($user, true) . "' type='checkbox' name='selectedUsers1[]'/></td>";
                    echo "<input value='" . $_GET['gid'] . "' name='gid' type='hidden'>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td width="75%" colspan="3"><input name="remove" value="Remove" type="submit"></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    </form>
    </body>

    </html>

<?php
if (isset($_POST['add'])) {
    if(!isset($_POST['selectedUsers'])){
        echo '<script>alert("Please select students.")</script>';

    }
    else {
        $handleCurl = 0;
        $u = $_POST['selectedUsers'];
        $gid = $_POST['gid'];

        if (isset($_SESSION["groups"])) {
            $groups = $_SESSION["groups"];
            foreach ($groups as $group) {
                if ($group['gid'] == $gid) {
                    $g = json_encode($group, true);
                }
            }
        }

        foreach ($u as $fy) {
            $temp = json_decode($fy, true);
            $fyid = $temp['fyid'];
            $url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.usersfy/" . $fyid;
            $temp['gid'] = json_decode($g);
            $fy = json_encode($temp);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fy);
            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                $handleCurl = 1;
            } else {
                $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($resultStatus == 204) {
                    $handleCurl = 2;
                } else {
                    $handleCurl = 3;
                }
            }
        }

        if ($handleCurl == 1) {
            die('Couldn\'t send request: ' . curl_error($curl));
        } elseif ($handleCurl == 2) {
            echo "<meta http-equiv='refresh' content='0.1;url=assignFyStudents.php?gid=" . $gid . "'>";
        } else {
            die('Request failed: HTTP status code: ' . $resultStatus);
        }
    }
}

if (isset($_POST['remove'])) {
    if(!isset($_POST['selectedUsers1'])){
        echo '<script>alert("Please select students.")</script>';

    }
    else {
        $handleCurl = 0;
        $u = $_POST['selectedUsers1'];
        $gid = $_POST['gid'];

        foreach ($u as $fy) {
            $temp = json_decode($fy, true);
            $fyid = $temp['fyid'];
            $url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.usersfy/" . $fyid;
            $temp['gid'] = null;
            $fy = json_encode($temp);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fy);
            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                $handleCurl = 1;
            } else {
                $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($resultStatus == 204) {
                    $handleCurl = 2;
                } else {
                    $handleCurl = 3;
                }
            }
        }

        if ($handleCurl == 1) {
            die('Couldn\'t send request: ' . curl_error($curl));
        } elseif ($handleCurl == 2) {
            echo "<meta http-equiv='refresh' content='0.1;url=assignFyStudents.php?gid=" . $gid . "'>";
        } else {
            die('Request failed: HTTP status code: ' . $resultStatus);
        }
    }
}

?>