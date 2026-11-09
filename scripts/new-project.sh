#!/usr/bin/env bash
# Rename the starter for a new project. Run once, right after cloning.
# Usage: ./scripts/new-project.sh acme-shop "Acme Shop"
set -euo pipefail
cd "$(dirname "$0")/.."

SLUG="${1:-}"
TITLE="${2:-}"
if ! [[ "$SLUG" =~ ^[a-z][a-z0-9-]*[a-z0-9]$ ]] || [ -z "$TITLE" ]; then
	echo "Usage: $0 <slug> \"<Title>\"   (slug: lowercase letters, digits, hyphens)" >&2
	exit 1
fi

SNAKE="${SLUG//-/_}"
UPPER="$(echo "$SNAKE" | tr '[:lower:]' '[:upper:]')"

echo "→ Replacing names in files"
grep -rlI --exclude-dir=.git --exclude=new-project.sh -e 'my-project' -e 'my_project' -e 'MY_PROJECT' -e 'My Project' . |
	while read -r file; do
		SLUG="$SLUG" SNAKE="$SNAKE" UPPER="$UPPER" TITLE="$TITLE" perl -pi -e '
			s/MY_PROJECT/$ENV{UPPER}/g;
			s/my_project/$ENV{SNAKE}/g;
			s/my-project/$ENV{SLUG}/g;
			s/My Project/$ENV{TITLE}/g;
		' "$file"
	done

echo "→ Renaming files and folders"
find . -depth -name '*my-project*' -not -path './.git/*' | while read -r path; do
	mv "$path" "$(dirname "$path")/$(basename "$path" | sed "s/my-project/$SLUG/g")"
done

echo "✓ Renamed to '$SLUG' ($TITLE). Next: ./scripts/setup.sh"
