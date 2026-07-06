<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$a = new App\Models\AgentRetainer();
$a->name = 'test_script';
$a->mobile = '9876543210';
$a->user_id = 1;
$a->save();
echo "SAVED_ID: " . $a->id . "\n";
