<?php

/**
 * 
 */
class Email
{

    /**
     * 
     */
    function send ($to, $title, $content)
    {
        // https://www.php.net/manual/fr/function.mail.php
        $headers =  'From: hello@workodin.com' . "\r\n" .
                    'Reply-To: hello@workodin.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        @mail($to, $title, $content, $headers);

    }
}