<?php
$ignore = "i-0f63c96cd2498fead"; // LG-Web-01a
$arn = "arn:aws:elasticloadbalancing:ap-northeast-1:662684164378:targetgroup/pro-group/4b7dbda4ccc491e8";

$return_var = shell_exec('aws ec2 describe-instances --filter "Name=tag:Name,Values=LG-Web-*"');
$instances = json_decode($return_var, true);

$sttopped_instances = array();
foreach ($instances["Reservations"] as $instance) {
    foreach ($instance["Instances"] as $i) {
        if ($i["State"]["Name"] == "running") {
            if ($i["InstanceId"] != $ignore) {
                $sttopped_instances[] = $i["InstanceId"];
            }
        }
    }
}

foreach ($sttopped_instances as $instance_id) {
    shell_exec("aws elbv2 register-targets --target-group-arn " . $arn . " --targets Id=" . $instance_id);
}
