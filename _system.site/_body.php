<?php
if (isset($_GET['p']) && $_GET['p'] == "map") {
    include('_user.site/_map.php');
}elseif (isset($_GET['p']) && $_GET['p'] == "about") {
    include('_user.site/_about.php');
}elseif (isset($_GET['p']) && $_GET['p'] == "sponsor") {
    include('_user.site/_sponsor.php');
}else {
    include('main.php');
}
?>
