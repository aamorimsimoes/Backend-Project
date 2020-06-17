<?php
/**
 * Connects to database.
 *
 * @return mixed
 */

// ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
//  PDO MySQL database connection

function conn()
{
    $host = 'localhost';
    $db   = 'company_sta'; // REVIEW
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
        $pdo = null;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
}



/**
 * Sends an email.
 *
 * @param  string $to
 * @param  string $subject
 * @param  string $message
 * @param  string $output
 * @return void
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function email($to, $subject, $message, $output)
{
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'andreamorimsimoes@gmail.com';
        $mail->Password   = 'qwchycltelbzrmnu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('andreamorimsimoes@gmail.com', 'STA App');
        $mail->addAddress($to);
        $mail->addReplyTo('no-reply@app.pt', 'Information');

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        //$mail->AltBody = 'Copy-past this code somewhere: '.$token;

        $mail->send();
        echo $output;
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}


/**
 * Delete a directory recursively.
 *
 * @param  string $dir
 * @return boolean
 */

function deleteDirectory($dir)
{
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}
