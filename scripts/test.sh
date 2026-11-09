#!/usr/bin/env bash
# Run every CLI check in tests/ against the local site.
set -euo pipefail
export MSYS_NO_PATHCONV=1
cd "$(dirname "$0")/.."

status=0
for file in tests/*.php; do
	echo "→ $file"
	docker compose run --rm -T cli wp eval-file "/var/www/tests/$(basename "$file")" || status=1
done
exit $status
