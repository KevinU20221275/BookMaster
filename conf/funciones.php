<?php
function set_message($header, $message, $type) {
    $_SESSION['message_header'] = $header;
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

function hasEmptyField(array $fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return true;
        }
    }
    return false;
}