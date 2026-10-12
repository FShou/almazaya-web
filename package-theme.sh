#!/usr/bin/env bash
# Build almazaya.zip — standar zip theme WP (folder almazaya/ di root zip),
# siap upload via Appearance → Themes → Add New → Upload.
# File git/dev (.github, .wp-env.json, script ini) tidak ikut.
set -euo pipefail
cd "$(dirname "$0")"
python3 - <<'EOF'
import os, zipfile
out = 'almazaya.zip'
skip_dirs = {'.git', '.github'}
skip_files = {'.wp-env.json', 'package-theme.sh', 'almazaya.zip',
              'ABOUT_US.md', 'FACT_CHECK.md', 'PLAN.md', 'STATUS.md'}
if os.path.exists(out):
    os.remove(out)
n = 0
with zipfile.ZipFile(out, 'w', zipfile.ZIP_DEFLATED) as z:
    for root, dirs, files in os.walk('.'):
        dirs[:] = [d for d in dirs if d not in skip_dirs and not d.startswith('.git')]
        for f in files:
            if f in skip_files or f.endswith(('.zip', '.docx')):
                continue
            p = os.path.join(root, f)
            z.write(p, os.path.join('almazaya', os.path.relpath(p, '.')))
            n += 1
print('Built: %s (%d files)' % (os.path.abspath(out), n))
EOF
python3 -c "import zipfile;z=zipfile.ZipFile('almazaya.zip');names=z.namelist();print('layout ok:', 'almazaya/style.css' in names and 'almazaya/functions.php' in names);print('no git/github:', not any(n.startswith('.git') or n.startswith('.github') for n in names));print('no wpenv:', 'almazaya/.wp-env.json' not in names)"
