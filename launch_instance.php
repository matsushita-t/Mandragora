<?php
if (empty($argv[0])) {
    echo "引数を指定してください example : php launch_instance.php start or php launch_instance.php stop";
    exit;
}
$state = $argv[0];

$return_var = shell_exec('aws ec2 describe-instances --filter "Name=tag:Name,Values=LG-Web-*"');
$instances = json_decode($return_var, true);

$sttopped_instances = array();
foreach ($instances["Reservations"] as $instance) {
    foreach ($instance["Instances"] as $i) {
        if ($i["State"]["Name"] == "stopped") {
            $sttopped_instances[] = $i["InstanceId"];
        }
    }
}

foreach ($sttopped_instances as $instance_id) {
    $cmd = "aws ec2 " . $state. "-instances --instance-ids " . $instance_id;
    shell_exec($cmd);
}