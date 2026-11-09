#!/usr/bin/env bash
# First-time server setup. Run ONCE from your machine, after the first deploy.
# Needs: WordPress + WP-CLI already installed on the server.
#
# Server details come from your environment, never from the repo:
#   SSH_HOST=... SSH_USER=... WP_PATH=... [SSH_PORT=22] ./scripts/server-setup.sh
set -euo pipefail
cd "$(dirname "$0")/.."

: "${SSH_HOST:?Set SSH_HOST}"
: "${SSH_USER:?Set SSH_USER}"
: "${WP_PATH:?Set WP_PATH (WordPress root on the server)}"
SSH_PORT="${SSH_PORT:-22}"

remote() { ssh -n -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" "cd '$WP_PATH' && $*"; }

echo "→ Installing pinned plugins"
grep -Ev '^[[:space:]]*(#|$)' plugins.txt | while read -r slug version; do
	[ -n "${version:-}" ] || { echo "✗ $slug is not pinned" >&2; exit 1; }
	remote wp plugin install "$slug" --version="$version" --activate
done

echo "→ Activating project theme and plugin"
remote wp theme activate my-project
remote wp plugin activate my-project-core
remote wp rewrite structure "'/%postname%/'" --hard

echo "→ Running seed (copied outside the web root, removed afterwards)"
TMP="/tmp/my-project-seed-$$"
scp -P "$SSH_PORT" -r seed "$SSH_USER@$SSH_HOST:$TMP"
remote wp eval-file "$TMP/seed.php"
remote rm -rf "$TMP"

echo "✓ Server ready. Turn on daily DB + uploads backups in the hosting panel."
