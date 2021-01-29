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
    <div class="d-inline-block" style="width:100px"></div>

</nav>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="container">
        <div class="row1">
            <h3>Admin Login</h3>
        </div>

        <div class="row">
            <label for="email"><strong>Email Address:</strong> </label><br>
            <input type="text" placeholder="Enter Email Address" name="email" required>
        </div>
        <div class="row">
            <label for="password"><strong>Password:</strong> </label><br>
            <input type="password" placeholder="Enter Password" name="password" required>
        </div>


        <div class="row">
            <input type='submit' class='btn btn-outline-success' value='Log In' />
        </div>
    </div>
</form>
        <?php
        session_start();
        if (isset($_POST['email']) && $_POST['email']!="") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $cost = ['cost' => 10];
            

            $url = "http://192.168.0.21:8080/FyssRestApi/webresources/fyss.usersadmin/auth";
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url
            ]);

            $authToken = $email . ":" . $password;

            $header[] = 'Content-Type: application/x-www-form-urlencoded';
            $header[] = 'Authorization: Basic ' . base64_encode($authToken);

          //  curl_setopt($curl, CURLOPT_POSTFIELDS, "email=".$email ."&password=" . $password );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_POST,true);
            $resp = curl_exec($curl);

            if (curl_errno($curl)) {
                die('Couldn\'t send request: ' . curl_error($curl));
            }
            else {
                $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($resultStatus == 200) {

                    $_SESSION['email'] = $email;
                    curl_close($curl);

                    echo "<div class='alert alert-info'>";
                    echo 'Successfully logged in.';
                    echo "<meta http-equiv='refresh' content='0;url=home.php'>";
                    echo "</div>";

                } else {
                    die('Request failed: HTTP status code: ' . $resultStatus);
                }
            }
        }


        ?>
</body>
</html>
