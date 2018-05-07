<?php
$return_var = shell_exec('aws ec2 describe-instances --filter "Name=tag:Name,Values=LG-Web-*"');
$instances = json_decode($return_var, true);

$sttopped_instances = array();
foreach ($instances["Reservations"] as $instance) {
    foreach ($instance["Instances"] as $i) {
        echo $i["InstanceId"]."\n";
    }
}