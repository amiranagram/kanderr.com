<?php

class Ajax
{

    public function __construct()
    {
        add_action('wp_ajax_nopriv_kanderr_contact_me', array($this, 'kanderr_contact_me'));
        add_action('wp_ajax_kanderr_contact_me', array($this, 'kanderr_contact_me'));
    }

    public function kanderr_contact_me() {
    
        $name = wp_strip_all_tags($_POST['name']);
        $email = wp_strip_all_tags($_POST['email']);
        $message = wp_strip_all_tags($_POST['message']);

        $args = array(
            'post_title' => $name,
            'post_content' => $message,
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'messages',
            'meta_input' => array(
                '_contact_email_value_key' => $email
            )
        );

        $postID = wp_insert_post($args);

        if($postID !== 0) {
            $to = get_bloginfo('admin_email');
            $subject = 'Message from: '.$name.' (kanderr.com)';

            $headers[] = 'From: '.$name.' <'.$email.'>';
            $headers[] = 'Reply-To: '.$name.' <'.$email.'>';
            $headers[] = 'Content-Type: text/html: charset=UTF-8';

            wp_mail($to, $subject, $message, $headers);

            echo $postID;
        } else {
            echo 0;
        }

        die();

    }

}



?>