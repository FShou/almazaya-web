#!/usr/bin/env bash
# Jalankan server web lokal untuk situs Al Mazaya.
# Pemakaian: ./serve.sh            (port 8765)
#            ./serve.sh 9000       (port lain)
set -e
cd "$(dirname "$0")"
PORT="${1:-8765}"
echo "==> Al Mazaya web siap: http://localhost:${PORT}"
echo "    (tekan Ctrl+C untuk berhenti)"
exec python3 -m http.server "${PORT}"