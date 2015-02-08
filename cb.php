<?php
echo $_SERVER['HTTP_USER_AGENT'] . "<hr />\n";
$browr = get_browser();
print_r($browr);
phpinfo();
?>