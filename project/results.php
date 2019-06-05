<?php
    // get the data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $phone = $_POST['phone'];
    $requirement = $_POST['requirement'];
   

    // trim the spaces from the start and end of all data
    $first_name = trim($first_name);
    $last_name = trim($last_name);
    $email = trim($email);
    $company = trim($company);
    $phone = trim($phone);
    $requirement = trim($requirement);

    // validate data
    $message = "";
    if (empty($first_name)) {
        $message =  $message . "You must enter a first name.\n";        
    }

    if (empty($last_name)) {
        $message =  $message . "You must enter a last name.\n";        
    }

  
    if (empty($email)) {
        $message =  $message . "You must enter a email address.\n";                
    }
    else if(strpos($email, '@') === false) {
        $message = 'The email address must contain an @ sign.';        
    } else if(strpos($email, '.') === false) {
        $message = 'The email address must contain a dot character.';        
    }    


    if (empty($company)) {
        $message =  $message . "You must enter a company.\n";        
    }


    if (empty($phone)) {
        $message =  $message . "You must enter a phone number.\n";        
    }
    else {
            // remove common formatting characters from the phone number
        $phone = str_replace('-', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);

        // validate the phone number
        if (strlen($phone) < 7) {
            $message = $message . "The phone number must contain at least seven digits.\n";
        }        
        else if (strlen($phone) == 7) {  // format the phone number
            $part1 = substr($phone, 0, 3);
            $part2 = substr($phone, 3);
            $phone = $part1 . '-' . $part2;
        } else {
            $part1 = substr($phone, 0, 3);
            $part2 = substr($phone, 3, 3);
            $part3 = substr($phone, 6);
            $phone = $part1 . '-' . $part2 . '-' . $part3;
        }
    }

    

    if (empty($requirement)) {
        $message =  $message . "You must enter a requirement.\n";        
    }




    if (strcmp($message,"") == 0)
    {

        require_once('database.php');
        $query = "INSERT INTO clients (FirstName, LastName, Email, Company, Phone, Requirement) VALUES ('$first_name', '$last_name', '$email', '$company', '$phone', '$requirement')";
        $db->exec($query);
    
        // Display the Product List page
       // include('index.php');

        // format the message
        $message =
        "Hello $first_name,\n\n" .
        "Thank you for entering this data,\nIt has been saved:\n\n" .
        "Name: $first_name  $last_name\n" .
        "Email: $email\n" .
        "Company: $company\n" .
        "Phone: $phone\n"  .
        "Requirement: $requirement\n";
    }

          
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Personal Information - Summary</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
    <div id="content">
        <h1>Personal Information Summary</h1>

        <h2>Message:</h2>
        <p><?php echo nl2br(htmlspecialchars($message)); ?></p>

        <p>&nbsp;</p>
        <p><a href="index.php">Home</a></p>
    </div>
</body>
</html>