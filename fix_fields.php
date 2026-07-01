<?php

$content = file_get_contents('c:\\xampp\\htdocs\\axvero\\crm\\resources\\views\\agent_retainer_new.blade.php');

$pattern = '/(<(?:input|select)[^>]*name="([^"]+)"[^>]*>)/i';

$content = preg_replace_callback($pattern, function($matches) {
    $full = $matches[1];
    $name = $matches[2];
    
    if (strpos(strtolower($full), '<select') !== false) {
        $full = str_replace('class="form-control"', 'class="form-control @error(\''.$name.'\') is-invalid @enderror"', $full);
    } else {
        $full = str_replace('class="form-control"', 'class="form-control @error(\''.$name.'\') is-invalid @enderror"', $full);
        if (strpos(strtolower($full), 'type="file"') === false && strpos(strtolower($full), 'value=') === false && $name !== '_token') {
            $full = str_replace('name="'.$name.'"', 'name="'.$name.'" value="{{ old(\''.$name.'\') }}"', $full);
        }
    }
    
    $error_block = '
                        @error(\''.$name.'\')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror';
    return $full . $error_block;
}, $content);

$content = str_replace('<option value="Retainer">Retainer</option>', '<option value="Retainer" {{ old(\'type\') == \'Retainer\' ? \'selected\' : \'\' }}>Retainer</option>', $content);
$content = str_replace('<option value="Agent">Agent</option>', '<option value="Agent" {{ old(\'type\') == \'Agent\' ? \'selected\' : \'\' }}>Agent</option>', $content);
$content = str_replace('<option>Male</option>', '<option {{ old(\'gender\') == \'Male\' ? \'selected\' : \'\' }}>Male</option>', $content);
$content = str_replace('<option>Female</option>', '<option {{ old(\'gender\') == \'Female\' ? \'selected\' : \'\' }}>Female</option>', $content);
$content = str_replace('<option>Other</option>', '<option {{ old(\'gender\') == \'Other\' ? \'selected\' : \'\' }}>Other</option>', $content);
$content = str_replace('<option>Single</option>', '<option {{ old(\'marital_status\') == \'Single\' ? \'selected\' : \'\' }}>Single</option>', $content);
$content = str_replace('<option>Married</option>', '<option {{ old(\'marital_status\') == \'Married\' ? \'selected\' : \'\' }}>Married</option>', $content);

file_put_contents('c:\\xampp\\htdocs\\axvero\\crm\\resources\\views\\agent_retainer_new.blade.php', $content);

echo "done\n";

