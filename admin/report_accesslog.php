<?php

// Directory of file log login
$LOG_DIRECTORY = __DIR__ . '/../logs/';

// Directory of file are compressed
$ZIP_DIRECTORY = __DIR__ . '/logs/';

// Password for file zip
$PWD = 'Boken2024';

// Mail from
$MAIL_FROM = "postmaster@mail.sorimachi.co.jp";

// Mail to
// $MAIL_TO = "854ef857.sgpsp.onmicrosoft.com@jp.teams.ms, k_Watanabe@mail.sorimachi.co.jp";
$MAIL_TO = "khanhvandinhkhanh1@gmail.com";

require_once __DIR__ . '/libs/phpmailer/PHPMailer.php';
require_once __DIR__ . '/libs/phpmailer/SMTP.php';
require_once __DIR__ . '/libs/phpmailer/Exception.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// Error message
define('ERR_FILE_NOT_EXIST', '指定されたファイルが見つかりません。');
define('ERR_ZIP_ADD', 'ファイルをZIPに追加できませんでした。');
define('ERR_ZIP_SET_ENCRYPTION', '暗号化の設定に失敗しました。');
define('ERR_ZIP_CREATE', 'ZIPファイルを作成できません。');
define('ERR_EXCEPTION', 'ZIPファイルを作成する際にエラーが発生しました。');

//START
$file_send = getLastMonthLog();

$error = "";
$subject = "【報告】商工会職員サイト – ログイン利用ログ";
$file_zip = createFileZip($file_send, $error);
if ($file_zip) {
    //send mail with attachment
    $success = sendMail($subject, "先月分のログファイルを添付します。", $file_zip);
} else {
    //send mail error
    $success = sendMail($subject, $error);
}

//print result
echo $success ? "メールの送信に成功しました。" : "メールの送信に失敗しました。";

function createFileZip($filename, &$error)
{
    global $ZIP_DIRECTORY, $LOG_DIRECTORY, $PWD;
    try {
        $file = $LOG_DIRECTORY . $filename;

        if (file_exists($file)) {

            $archive_name = $ZIP_DIRECTORY . substr($filename, 0, strpos($filename, ".txt")) . '.zip';

            $zip = new ZipArchive();

            if ($zip->open($archive_name, ZipArchive::CREATE) === true) {
                // get file name from absolute path
                $filename = substr($file, strrpos($file, '/') + 1);

                // add file in zip archive
                if (!$zip->addFile($file, $filename)) {
                    $error = ERR_ZIP_ADD;
                    return false;
                }

                // encrypt the file with AES-256
                if (!$zip->setEncryptionName($filename, ZipArchive::EM_AES_256, $PWD)) {
                    $error = ERR_ZIP_SET_ENCRYPTION;
                    return false;
                }
                // close zip archive
                $zip->close();

                return $archive_name;
            } else {
                $error = ERR_ZIP_CREATE;
                return false;
            }
        } else {
            $error = ERR_FILE_NOT_EXIST;
            return false;
        }

    } catch (Exception $e) {
        // write log
        $fHandler = fopen($ZIP_DIRECTORY . 'error_zip.txt', 'a');
        fwrite($fHandler, $e->getMessage());
        fclose($fHandler);

        $error = ERR_EXCEPTION;
        return false;
    }
}

function sendMail($subject, $message, $attachment = null)
{
    global $MAIL_FROM, $MAIL_TO;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.office365.com";
        $mail->SMTPAuth = true;
        $mail->Username = "postmaster@mail.sorimachi.co.jp";
        $mail->Password = "sgvPM2030";

        $mail->Port = 587;

        $mail->CharSet = "UTF-8";

        // From
        $mail->setFrom($MAIL_FROM);

        // MailTo
        $recipients = explode(',', $MAIL_TO);
        if (is_array($recipients)) {
            foreach ($recipients as $mail_to) {
                $mail->AddAddress(trim($mail_to));
            }
        } else {
            return false;
        }

        // Attachments
        if (!empty($attachment)) {
            $mail->addAttachment($attachment);
        }

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;

        return $mail->send();

    } catch (Exception $e) {
        // write log
        global $ZIP_DIRECTORY;
        $fHandler = fopen($ZIP_DIRECTORY . 'error_zip.txt', 'a');
        fwrite($fHandler, $e->getMessage());
        fclose($fHandler);
        return false;
    }

}

function getLastMonthLog()
{
    $filename = "";

    $dateInterval = DateInterval::createFromDateString("1 month");
    $current = new DateTime();
    $lastMonthDT = $current->sub($dateInterval);
    $lastmonth = $lastMonthDT->format('Y-m');

    $filename = sprintf("loginmember-%s.txt", $lastmonth);

    return $filename;
}
