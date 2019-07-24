<?php

/**
 * 
 */
class Email
{

    /**
     * 
     */
    function send ($title, $content, $to="hello@workodin.com")
    {
        // https://www.php.net/manual/fr/function.mail.php
        $headers =  "From: $to" . "\r\n" .
                    "Reply-To: $to" . "\r\n" .
                    "X-Mailer: PHP/" . phpversion();

        @mail($to, $title, $content, $headers);

    }

    /**
     * TODO: envoyer aussi en plain text
     */
    function sendHtml ($title, $htmlContent, $attachFile="", $attachName="", $to="hello@workodin.com")
    {
        // https://www.codexworld.com/send-email-with-attachment-php/
        // https://webcheatsheet.com/php/send_email_text_html_attachment.php

        //sender
        $from = 'hello@workodin.com';
        $fromName = 'Workodin';

        //header for sender info
        $headers = "From: $fromName"." <".$from.">";

        //boundary MULTIPART
        $semiRand = md5(password_hash(uniqid(), PASSWORD_DEFAULT)); 
        $mimeBoundary = "==Multipart_Boundary_x{$semiRand}x"; 

        //boundary ALT (TODO)
        $semiRand2 = md5(password_hash(uniqid(), PASSWORD_DEFAULT)); 
        $altBoundary = "==Multipart_Boundary_x{$semiRand2}x"; 
        
        //headers for attachment 
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mimeBoundary}\""; 

        //multipart boundary 
        $message = "--{$mimeBoundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

        //preparing attachment
        if(is_file($attachFile)){
            $message .= "--{$mimeBoundary}\n";
            $data =  file_get_contents($attachFile);

            $data = chunk_split(base64_encode($data));
            if ($attachName != "")
            {
                $basename = basename($attachName);
            }
            else
            {
                $basename = basename($attachFile);
            }
            $message .= "Content-Type: application/octet-stream; name=\"$basename\"\n" . 
            "Content-Description: $basename\n" .
            "Content-Disposition: attachment;\n" . " filename=\"$basename\"; size=".filesize($attachFile).";\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
        $message .= "--{$mimeBoundary}--";

        // send email
        $result = @mail($to, $title, $message, $headers); 

        return $result;
    }
}