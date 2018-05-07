<?php
if (empty($argv[0])) {
    echo "引数にインスタンスタイプを設定してください example : php modify_instance_type.php c4.2xlarge";
    exit;
}
$instance_type = $argv[0];

$return_var = shell_exec('aws ec2 describe-instances --filter "Name=tag:Name,Values=LG-Web-*"');
$instances = json_decode($return_var, true);

$sttopped_instances = array();
foreach ($instances["Reservations"] as $instance) {
    foreach ($instance["Instances"] as $i) {
        $sttopped_instances[] = $i["InstanceId"];
    }
}

foreach ($sttopped_instances as $instance_id) {
    $boot_cmd = "aws ec2 modify-instance-attribute --instance-id " . $instance_id . " --attribute instanceType --value " . $instance_type;
    shell_exec($boot_cmd);
}