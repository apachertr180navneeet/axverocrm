import re

content = open(r'c:\xampp\htdocs\axvero\crm\resources\views\agent_retainer_new.blade.php', 'r', encoding='utf-8').read()

def inject_error(match):
    full = match.group(0)
    name = match.group(1)
    
    if '<select' in full:
        full = full.replace('class="form-control"', f'class="form-control @error(\'{name}\') is-invalid @enderror"')
    else:
        full = full.replace('class="form-control"', f'class="form-control @error(\'{name}\') is-invalid @enderror"')
        if 'type="file"' not in full and 'value=' not in full:
            full = full.replace('name="' + name + '"', f'name="{name}" value="{{{{ old(\'{name}\') }}}}"')
    
    error_block = f"""
                        @error('{name}')
                            <span class="text-danger small" role="alert">
                                <strong>{{{{ $message }}}}</strong>
                            </span>
                        @enderror"""
    return full + error_block

pattern = r'(<(?:input|select)[^>]*name="([^"]+)"[^>]*>)'

new_content = re.sub(pattern, inject_error, content)

new_content = new_content.replace('<option value="Retainer">Retainer</option>', '<option value="Retainer" {{ old(\'type\') == \'Retainer\' ? \'selected\' : \'\' }}>Retainer</option>')
new_content = new_content.replace('<option value="Agent">Agent</option>', '<option value="Agent" {{ old(\'type\') == \'Agent\' ? \'selected\' : \'\' }}>Agent</option>')
new_content = new_content.replace('<option>Male</option>', '<option {{ old(\'gender\') == \'Male\' ? \'selected\' : \'\' }}>Male</option>')
new_content = new_content.replace('<option>Female</option>', '<option {{ old(\'gender\') == \'Female\' ? \'selected\' : \'\' }}>Female</option>')
new_content = new_content.replace('<option>Other</option>', '<option {{ old(\'gender\') == \'Other\' ? \'selected\' : \'\' }}>Other</option>')
new_content = new_content.replace('<option>Single</option>', '<option {{ old(\'marital_status\') == \'Single\' ? \'selected\' : \'\' }}>Single</option>')
new_content = new_content.replace('<option>Married</option>', '<option {{ old(\'marital_status\') == \'Married\' ? \'selected\' : \'\' }}>Married</option>')

open(r'c:\xampp\htdocs\axvero\crm\resources\views\agent_retainer_new.blade.php', 'w', encoding='utf-8').write(new_content)
print("done")
