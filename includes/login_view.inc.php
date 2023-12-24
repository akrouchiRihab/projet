<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../css/login.css">
</head>
<?php

function output_username()
{
    if (isset($_SESSION["user_id"])) {
       /* echo "you are logged in as " . $_SESSION["user_fname"] . " " . $_SESSION["user_lname"];
        echo '<br>';*/
       
        echo "your id is " . $_SESSION["user_id"];
        echo "you phone is " .$_SESSION["user_phone"];
        echo "you name us " . $_SESSION["user_fname"] . " " . $_SESSION["user_lname"];

    } else {
        echo "you are not logged in";
    }
}
function check_login_errors()
{

    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];

        echo "<br>";
        foreach ($errors as $error) { ?>
            <div class=form-error-div>
                <p class="form-error">
                    <?php echo  $error; ?>
                    <br>
                </p>
            </div>
        <?php
        }

        unset($_SESSION["errors_login"]);
    } else if (isset($_GET['login']) && $_GET['login'] === "success") {
        echo '<br>';
        ?>
        <div>
            <p class="form-success"> vous etes inscrit! </p>
        </div>

<?php
    }
}
?>

</html>