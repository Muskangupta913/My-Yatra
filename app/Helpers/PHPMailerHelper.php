<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerHelper
{
    /**
     * Send an email using PHPMailer with enhanced debugging.
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param string|null $fromEmail
     * @param string|null $fromName
     * @return array
     */
    public static function sendEmail($to, $subject, $body, $fromEmail = null, $fromName = null)
    {
        $mail = new PHPMailer(true);
        $debugOutput = '';

        try {
            // Capture SMTP debugging information
            $mail->SMTPDebug = 3; // Highest level of debugging
            $mail->Debugoutput = function($str, $level) use (&$debugOutput) {
                $debugOutput .= "$str\n";
                \Log::debug("PHPMailer ($level): $str");
            };

            // Basic server settings
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST', 'smtpout.secureserver.net');
            $mail->SMTPAuth = true;
            
            // Authentication
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            
            // Encryption and port settings
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SMTPS explicitly
            $mail->Port = 465;

            // Additional SMTP options for GoDaddy
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Extended timeout
            $mail->Timeout = 60;
            $mail->SMTPKeepAlive = true;

            // Sender settings
            $fromEmail = $fromEmail ?? env('MAIL_FROM_ADDRESS');
            $fromName = $fromName ?? env('MAIL_FROM_NAME');
            
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($to);

            // Email content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body = $body;
            
            // Clear any previous errors
            $mail->ErrorInfo = '';

            // Attempt to send
            $result = $mail->send();
            
            if (!$result) {
                throw new Exception($mail->ErrorInfo ?: 'Unknown error occurred');
            }

            return [
                'success' => true,
                'message' => 'Email sent successfully',
                'debug' => $debugOutput
            ];

        } catch (Exception $e) {
            $errorDetails = [
                'error' => $e->getMessage(),
                'debug_output' => $debugOutput,
                'smtp_config' => [
                    'host' => $mail->Host,
                    'port' => $mail->Port,
                    'encryption' => $mail->SMTPSecure,
                    'username' => $mail->Username,
                    'from_email' => $fromEmail,
                    'to_email' => $to,
                ],
                'server_info' => [
                    'php_version' => PHP_VERSION,
                    'openssl_version' => OPENSSL_VERSION_TEXT,
                ]
            ];

            \Log::error('Detailed PHPMailer Error:', $errorDetails);

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'debug' => $debugOutput,
                'details' => $errorDetails
            ];
        }
    }
}