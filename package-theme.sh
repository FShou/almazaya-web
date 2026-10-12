#!/usr/bin/env bash
# Build almazaya.zip — theme root = zip root, ready for
# Appearance → Themes → Add New → Upload (.git & dev files excluded).
set -euo pipefail
cd "$(dirname "$0")"
python3 - <<'EOF'
import os, zipfile
out = 'almazaya.zip'
skip_dirs = {'.git'}
skip_files = {'.wp-env.json', 'package-theme.sh', 'almazaya.zip'}
if os.path.exists(out):
    os.remove(out)
n = 0
with zipfile.ZipFile(out, 'w', zipfile.ZIP_DEFLATED) as z:
    for root, dirs, files in os.walk('.'):
        dirs[:] = [d for d in dirs if d not in skip_dirs and not d.startswith('.git')]
        for f in files:
            if f in skip_files or f.endswith('.zip'):
                continue
            p = os.path.join(root, f)
            z.write(p, os.path.relpath(p, '.'))
            n += 1
print('Built: %s (%d files)' % (os.path.abspath(out), n))
EOF
python3 -c "import zipfile;z=zipfile.ZipFile('almazaya.zip');names=z.namelist();print('root ok:', 'style.css' in names and 'functions.php' in names);print('no git dir:', not any(n.startswith('.git/') for n in names));print('no wpenv:', '.wp-env.json' not in names)"
