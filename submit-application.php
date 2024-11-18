<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];
    $notes = $_POST['notes'];

    // Check if a file is uploaded
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        // Define the allowed file types
        $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        
        // Get file info
        $fileName = $_FILES['resume']['name'];
        $fileTmpPath = $_FILES['resume']['tmp_name'];
        $fileType = $_FILES['resume']['type'];
        $fileSize = $_FILES['resume']['size'];
        
        // Check if file type is allowed
        if (in_array($fileType, $allowedTypes)) {
            // Define the directory to save the file
            $uploadDir = 'uploads/';
            $filePath = $uploadDir . $fileName;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($fileTmpPath, $filePath)) {
                echo "Application submitted successfully!<br>";
                echo "Resume uploaded: " . $fileName . "<br>";
            } else {
                echo "Error uploading file.<br>";
            }
        } else {
            echo "Invalid file type. Only PDF and DOC files are allowed.<br>";
        }
    } else {
        echo "No resume uploaded or there was an error with the file.<br>";
    }

    // Format the email content
    $message = "
    Job Application Details:
    ----------------------------
    First Name: $firstName
    Last Name: $lastName
    Email: $email
    Phone: $phone
    Qualification: $qualification
    Experience: $experience
    Notes: $notes
    Resume: $filePath
    ";

    // Send email (adjust the recipient email address)
    $to = 'sales@uv1inc.com';
    $subject = 'New Job Application Submission';
    $headers = 'From: ' . $email . "\r\n" .
               'Reply-To: ' . $email . "\r\n" .
               'Content-Type: text/plain; charset=UTF-8';

    if (mail($to, $subject, $message, $headers)) {
        echo "Your application has been submitted successfully.<br>";
    } else {
        echo "Error in sending email.<br>";
    }

} else {
    // If form is not submitted
    echo "Form not submitted properly.";
}
?>
