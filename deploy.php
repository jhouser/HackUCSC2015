<?php
set_time_limit(0);
$command = 'C:\xampp\mysql\bin\mysql'
        . ' --host=localhost'
        . ' --user=root'
        . ' --password='
        . ' --database=hackucsc'
        . ' --execute="SOURCE '
;

$output = shell_exec($command . 'protected/data/install.sql"');
$output = shell_exec($command . 'protected/data/data.sql"');
header('Location: index.php');
