<?php
$content = file_get_contents('vendor/composer/autoload_static.php');
preg_match('/public static \$classMap = array \(([^;]+)\);/', $content, $m);
$lines = explode(",\n", $m[1]);
echo count($lines) . " classmap entries found\n";
echo "First 5 entries:\n";
for ($i = 0; $i < min(5, count($lines)); $i++) {
    echo $lines[$i] . "\n";
}
echo "Contains PHPUnit: " . (strpos($content, 'PHPUnit') !== false ? 'yes' : 'no') . "\n";
echo "Contains Illuminate: " . (strpos($content, 'Illuminate') !== false ? 'yes' : 'no') . "\n";
