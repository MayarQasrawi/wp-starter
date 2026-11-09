#!/usr/bin/env bash
# One command to a working local site. Safe to run again.
set -euo pipefail
export MSYS_NO_PATHCONV=1
cd "$(dirname "$0")/.."

PORT="${WP_PORT:-8080}"
wp() { docker compose run --rm -T cli wp "$@"; }

echo "→ Starting containers"
docker compose up -d

echo "→ Waiting for WordPress and the database"
until wp db check >/dev/null 2>&1; do sleep 2; done

if ! wp core is-installed >/dev/null 2>&1; then
	echo "→ Installing WordPress"
	wp core install \
		--url="http://localhost:${PORT}" \
		--title="My Project" \
		--admin_user=admin \
		--admin_password=password \
		--admin_email=admin@example.com \
		--skip-email
fi

echo "→ Installing pinned plugins (plugins.txt)"
{ grep -Ev '^[[:space:]]*(#|$)' plugins.txt || true; } | while read -r slug version; do
	if [ -z "${version:-}" ]; then
		echo "✗ $slug has no version in plugins.txt. Pin it." >&2
		exit 1
	fi
	wp plugin install "$slug" --version="$version" --activate --force </dev/null
done

echo "→ Activating project theme and plugin"
wp theme activate my-project
wp plugin activate my-project-core
wp rewrite structure '/%postname%/' --hard

echo "→ Seeding demo content"
wp eval-file /var/www/seed/seed.php

echo "✓ Ready: http://localhost:${PORT}  (admin / password, local only)"
