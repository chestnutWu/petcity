<?php
if(isset($_GET['url']) and !empty($_GET['url'])) {
    $data = file_get_contents($_GET['url']);
    print $data;
}
?>