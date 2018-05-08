<?php
$state = "start";
$ignore = "i-0f63c96cd2498fead"; // LG-Web-01a

$return_var = shell_exec('aws ec2 describe-instances --filter "Name=tag:Name,Values=LG-Web-*"');
$instances = json_decode($return_var, true);

$sttopped_instances = array();
foreach ($instances["Reservations"] as $instance) {
    foreach ($instance["Instances"] as $i) {
        if ($i["State"]["Name"] == "stopped") {
            if ($i["InstanceId"] != $ignore) {
                $sttopped_instances[] = $i["InstanceId"];
            }
        }
    }
}

foreach ($sttopped_instances as $instance_id) {
    shell_exec("aws ec2 " . $state. "-instances --instance-ids " . $instance_id);
}