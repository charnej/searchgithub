<?php

require './ConnectionClass.php';

if (isset($_POST['full_name']) && isset($_POST['language'])) {

    if (isset($_POST['latest_tag'])) {
        $conObj->AddFavorite($_POST['full_name'], $_POST['language'], $_POST['latest_tag']);
    } else {
        $conObj->AddFavorite($_POST['full_name'], $_POST['language'], "-");
    }
}
