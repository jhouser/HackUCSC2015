<?php

$command = 'C:\xampp\mysql\bin\mysql'
        . ' --host=localhost'
        . ' --user=root'
        . ' --password='
        . ' --database=hackucsc'
        . ' --execute="SOURCE '
;

$output = shell_exec($command . 'protected/data/install.sql"');
