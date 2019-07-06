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
}