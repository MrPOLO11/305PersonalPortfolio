<?php
/*
 * Marcos Rivera
 * Confirmation page validation for guestbook page
 *
 */

//Enable developer debugger
ini_set('display_errors', 1);
error_reporting(E_ALL);

require('/home2/marcosri/connect.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GuestBook Confirm</title>
</head>
<body>

<?php
//echo var_dump($_POST);
//Required, no special cases
$first = $_POST['firstName'];
$last = $_POST['lastName'];
$title = $_POST['title'];
$company = $_POST['company'];
$mailingList = $_POST['addToList'];
$commentSection = $_POST['comments'];

if($_POST['howWeMet'] != 'Meetup' AND $_POST['howWeMet'] != 'Booth' AND $_POST['howWeMet'] != 'Jobfair' AND $_POST['howWeMet'] != 'Never' AND $_POST['howWeMet'] != 'Other') {
    echo "<p>Please provide a valid value</p>";
    $isValid = false;
} else {
    $howWeMet = $_POST['howWeMet'];
}


$isValid = true;
$emailValid = false;
$linkedInValid = false;

if ($first == '') {
    echo "<p><strong>Error, You did not enter a first name!</strong></p>";
    echo "<a href=\"guestbook.html\">Go back to page</a>";
    $isValid = false;
} else if ($last == '') {
    echo "<p><strong>Error, You did not enter a last name!</strong></p>";
    echo "<a href=\"guestbook.html\">Go back to page</a>";
    $isValid = false;
} else if ($howWeMet == 'none') {
    echo "<p><strong>Error, You did not select an option for how we met!</strong></p>";
    echo "<a href=\"guestbook.html\">Go back to page</a>";
    $isValid = false;
}

if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p><strong>Error, Invalid email</strong></p>";
        echo "<a href=\"guestbook.html\">Go back to page</a>";
        $isValid = false;
    }
    $emailValid = true;
}

if (isset($_POST['addToList'])) {
    //Must provide email if mailing list is checked
    $email = $_POST['email'];
    if ($email == "") {
        echo "<p><strong>Error, You must provide an email to be added to mailing list</strong></p>";
        echo "<a href=\"guestbook.html\">Go back to page</a>";
        $isValid = false;
    } else if (isset($email) AND !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p><strong>Error, Invalid email</strong></p>";
        echo "<a href=\"guestbook.html\">Go back to page</a>";
        $isValid = false;
    } else {
        $emailValid = true;
    }
}

if (isset($_POST['linkedIn'])) {
    //If linkedIn supplied, it must be valid!
    $linkedInURL = $_POST['linkedIn'];
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?
            =~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $linkedInURL)) {
        echo "<p><strong>Error, Invalid LinkedIn URL</strong></p>";
        echo "<a href=\"guestbook.html\">Go back to page</a>";
        $isValid = false;
    } else {
        $linkedInValid = true;
    }
}
if ($isValid) {
    $submission = date('Y-m-d');
    $sql = "INSERT INTO guestbook (`name`, `email`, `title`, `company`, `linkedIn`, `mailingList`, `howWeMet`, `dateSubmitted`, `commentSection`)
                VALUES ('$first $last', '$email', '$title', '$company', '$linkedInURL', '$mailingList', '$howWeMet', '$submission', '$commentSection')";

    $result = mysqli_query($cnxn, $sql);
    echo "<h1>Thank you for filling out our form!</h1>
              <p><strong>Name:</strong> $last, $first</p>
              <p><strong>How We Met:</strong> $howWeMet</p>";
    if ($emailValid) {
        echo "<p><strong>Email:</strong> $email</p>";
    }
    if ($linkedInValid) {
        echo "<p><strong>LinkedIn:</strong> $linkedInURL</p>";
    }
    echo "<p><a href='guestbook.html'>Go to guestbook page</a></p>";
    echo "<p><a href='login.php'>Go to Guestbook Summary</a></p>";
}
?>
</body>
</html>