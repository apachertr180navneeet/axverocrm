<?php

$content = file_get_contents('c:\\xampp\\htdocs\\axvero\\crm\\resources\\views\\agent_retainer_new.blade.php');

// Fix selects by moving @error blocks to outside the select
$pattern = '/(<select[^>]*>)\s*(@error\([^)]+\)\s*<span[^>]*>\s*<strong>\{\{\s*\$message\s*\}\}<\/strong>\s*<\/span>\s*@enderror)([\s\S]*?)(<\/select>)/i';
$content = preg_replace($pattern, '$1$3$4$2', $content);

// Also fix <input> because the script put the error inside the tag? Wait no, I used $full . $error_block where $full was the <input ... >
// Wait, for <input>, $full is the input element, so error block was appended after. That's fine.
// Let's check inputs.

file_put_contents('c:\\xampp\\htdocs\\axvero\\crm\\resources\\views\\agent_retainer_new.blade.php', $content);

echo "done\n";
