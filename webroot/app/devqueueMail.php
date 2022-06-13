<?php
echo 'queueMail ', "\n";

error_reporting(E_ALL);
ini_set('error_log', 'log/queue_mail-'.date('Y-m-d').'.log');

set_include_path(get_include_path() . PATH_SEPARATOR .  './lib/');
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

$dbconn = new PDO("mysql:host=localhost;dbname=portaltst;charset=utf8", 'root', 'senha1');
$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbconn->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);

$sql = 'select * from queue_email where DATE_PUBLISHED > ? and success = 0 and max_attempts > attempts order by DATE_PUBLISHED limit 20';
$params = [date('Y-m-d H:i:s', strtotime("-1 day"))];
$stmt = $dbconn->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


try {

    $config = include 'config.php';
    $config = $config['mail-profiles'];


    foreach($rows as $row) {


        try {

            $profile = $row['PROFILE'] ?: 'default';

            if (!isset($config[$profile]))
                $profile = 'default';

        if (!isset($config[$profile])) throw new Exception('profile not found in config');

            $smtpConfig = $config[$profile];

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = $smtpConfig['host'];
            $mail->SMTPAuth = $smtpConfig['auth'];
            $mail->Username = $smtpConfig['username'];
            $mail->Password = $smtpConfig['password'];
            $mail->SMTPSecure = $smtpConfig['ssl'] ?: false;
            $mail->Port = $smtpConfig['port'];

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'  => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                ]
            ];

            if (!empty($smtpConfig['reply_to']))
                $mail->addReplyTo($smtpConfig['reply_to'], $smtpConfig['reply_name']);

            if (strlen($row['FROM_EMAIL']))
                $mail->setFrom($row['FROM_EMAIL'], $row['FROM_NAME']);
            else
                $mail->setFrom($smtpConfig['from_email'], $smtpConfig['from_name']);

            $mail->Subject = $row['SUBJECT'];

            $emails = preg_split('/[,;]/', $row['TO_EMAIL']);
            foreach($emails as $email){
                $email = trim($email);

                if (filter_var($email, FILTER_VALIDATE_EMAIL))
                    $mail->addAddress($email);
            }

            $emails = preg_split('/[,;]/', $smtpConfig['bcc']);
            foreach($emails as $email){
                $email = trim($email);

                if (filter_var($email, FILTER_VALIDATE_EMAIL))
                    $mail->addBCC($email);
            }

            if ($row['HTML']) {
                $mail->isHTML(true);
                $mail->Body = $row['MESSAGE'];
            } else {
                $mail->Body = $mail->AltBody = $row['MESSAGE'];
            }

            if (!empty($row['ATTACHS'])) {
                $attachs = json_decode($row['ATTACHS'], true);

                if (is_array($attachs) && $attachs)
                    foreach($attachs as $name => $filename)
                        if (is_readable($filename))
                            $mail->addAttachment($filename, $name);
            }

            $mail->send();


            $sql = 'update queue_email set attempts = attempts+1, success = 1, last_attempt = ?, date_sent = ? where id = ?';
            $params = [date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), $row['ID']];
            $stmt = $dbconn->prepare($sql)->execute($params);

        } catch (Exception $e) {
            error_log('Error: '.$e->getMessage());
            $row['MESSAGE'] = substr($row['MESSAGE'], 0, 250);
            error_log('Message: ' . print_r($row, true));
            $sql = 'update queue_email set attempts = attempts+1, last_attempt = ? where id = ?';
            $params = [date('Y-m-d H:i:s'), $row['ID']];
            $stmt = $dbconn->prepare($sql)->execute($params);

        }

    }
} catch (Exception $e) {
	error_log($e->getMessage());
	error_log($filename);
	error_log(print_r($row, true));

}

error_log('Queue processed');
echo 'Done', "\r\n";
