<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$folder = $_SERVER['DOCUMENT_ROOT'] . "/vaultfurniture";
require_once("$folder/config/db.php");

require_once("$folder/PHPMailer/src/PHPMailer.php");
require_once("$folder/PHPMailer/src/SMTP.php");
require_once("$folder/PHPMailer/src/Exception.php");
$table = "contact";

if (isset($_POST['trigger_contact'])) {
    $fullname = $db->real_escape_string($_POST['fullname']);
    $email = $db->real_escape_string($_POST['email']);
    $phone = $db->real_escape_string($_POST['phone']);
    $message = $db->real_escape_string($_POST['message']);

    $mail = new PHPMailer(true);
    try {
        // Configure Mailer
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "salamiabidemi19@gmail.com";
        $mail->Password = "zvnaxyyktpnwqwlb";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Receiver
        $mail->setFrom("salamiabidemi19@gmail.com", "Vaultfurniture"); // This must be your email (as written on my own line 25)
        $mail->addAddress("salamiabidemi19@gmail.com"); // This is the email to receive the message
        $mail->addReplyTo($email, $fullname); // This is the email that would show up when you tap "Reply" in your inbox

        $insert_query = $db->query("INSERT INTO $table (fullname, email, phone, message) VALUES ('$fullname', '$email', '$phone', '$message')"); // Save a copy of the message in your database 
        if ($insert_query) {
            $mail->isHTML(true);
            $mail->Subject = "Vaultfurniture: Message from $fullname";
            // Make the email look fancy, you can choose to use plain text too. Your choice.
            $mail->Body = <<<_HTML
            <section style="box-sizing: border-box; padding: 0.5rem;">
                <h4 style="font-size: 1.25rem; font-weight: 700; padding-bottom: 0.5rem 0.5rem 0; border-radius: 5px; text-align: center; color: #16f9a2;">Vaultfurniture: Contact Form.</h4>
                <p style="color: #50506a; text-align: center;  line-height: 1.8; padding: 0.5rem;">Please note, a copy of this message in your admin database, on the contact page.</p>
                <p style="color: #50506a; text-align: center; display: flex; line-height: 1.8; padding: 0.25rem 0; border-bottom: 1px solid #d8d8d8;"><span style="color: #16f9a2; font-weight: bolder; padding-right: .2rem;">Full Name:</span> $fullname</p>
                <p style="color: #50506a; text-align: center; display: flex; line-height: 1.8; padding: 0.25rem 0; border-bottom: 1px solid #d8d8d8;"><span style="color: #16f9a2; font-weight: bolder; padding-right: .2rem;">Email:</span> $email</p>
                <p style="color: #50506a; text-align: center; display: flex; line-height: 1.8; padding: 0.25rem 0; border-bottom: 1px solid #d8d8d8;"><span style="color: #16f9a2; font-weight: bolder; padding-right: .2rem;">Phone:</span> $phone</p>
                <p style="background-color: #f4f3f4; color: #50506a !important; border-radius: 5px; padding: .75rem; margin: 0.5rem 0 2rem;">$message</p>
                <p style="color: #50506a; font-size: 10px; text-align: center; line-height: 1.8; padding: 0.5rem; border-top: 1px solid #d8d8d8;">You are receiving this message because you are an admin of Vaultfurniture. Click <a href='https://e-limi.africa/sign-up' style='color: #16f9a2; font-weight: 600;'>here</a> if you wish to stop receiving these message, thanks.</p>
            </section>
_HTML;
            $mail->send(); // This is the line that actually send the mail
            echo json_encode(["error" => false, "message" => "Dear $fullname, thank you for your message. We will review and where applicable get back to you."]);
        }
    } catch (\Throwable $th) {
        echo json_encode(["error" => true, "message" => "Something went wrong on our end, we could not send your message. Please, refresh and try again"]);
        throw $th; // The $th gives a meaningful reason/message if an error occurs
    }
}

?>