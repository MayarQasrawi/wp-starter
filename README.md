# My Project

WordPress site: block theme + custom plugin, Docker for local, GitHub Actions for deploy.

## Start a new project from this starter

```bash
git clone https://github.com/MayarQasrawi/wp-starter.git acme-shop
cd acme-shop
rm -rf .git && git init
./scripts/new-project.sh acme-shop "Acme Shop"   # renames theme, plugin, prefixes
./scripts/setup.sh
```

Or click **Use this template** on GitHub, clone your new repo, then run the last two lines.

## Run locally

Needs Docker. On Windows, use Git Bash or WSL.

```bash
./scripts/setup.sh          # first time: install, plugins, theme, seed
docker compose up -d        # later
./scripts/wp plugin list    # WP-CLI
./scripts/test.sh           # CLI checks in tests/
```

Site: http://localhost:8080 · Login: `admin` / `password` (local only).
Change the port with `WP_PORT=8095 ./scripts/setup.sh`.

## Layout

| Path | What goes there |
|---|---|
| `themes/my-project/` | Presentation only: templates, parts, patterns, theme.json, CSS/JS, display blocks |
| `plugins/my-project-core/` | Data and behaviour: post types, taxonomies, REST, settings, shortcodes, API calls |
| `docker/` | Local-only config and mu-plugins. Never deployed |
| `seed/` | Demo content. Finds pages by slug, never by ID |
| `tests/` | CLI-only PHP checks |
| `scripts/` | setup, wp, test, server-setup, new-project |
| `plugins.txt` | Third-party plugins with pinned versions |

## Rules

- **Git owns code, the database owns content.** Deploys never write to the DB.
- Never commit: core, third-party plugins, `wp-config.php`, `.env`, uploads, DB dumps, design exports, server IPs, users or paths.
- Every third-party plugin is pinned in `plugins.txt`.
- Load JS/CSS only on the pages that need them.
- Branch on `wp_get_environment_type()`, never on hostnames.
- Secrets: `wp-config.php` constant on the server, read with `my_project_core_secret()`.
- No Composer, npm or build step until there is a real need.

## Deploy

Push to `main` → PHP lint → DB backup on the server (last 5 kept) → rsync theme and plugin → cache flush.

**One-time setup**

1. GitHub → Settings → Secrets and variables → Actions:
   - Variables: `SSH_HOST`, `SSH_PORT`, `SSH_USER`, `WP_PATH`, `PHP_VERSION` (server's), `CACHE_PURGE_CMD` (optional, e.g. `wp litespeed-purge all`)
   - Secrets: `SSH_KEY` (private deploy key), `SSH_KNOWN_HOSTS` (output of `ssh-keyscan -p <port> <host>`)
2. On the server: WordPress and WP-CLI installed; `wp-config.php` with `WP_ENVIRONMENT_TYPE` = `production` and `WP_DEBUG_DISPLAY` = `false`.
3. Actions → Deploy → **Run workflow** (first deploy).
4. From your machine, once: `SSH_HOST=... SSH_USER=... WP_PATH=... ./scripts/server-setup.sh`
5. Turn on daily DB + uploads backups in the hosting panel, and add a free uptime monitor.

**After each deploy:** check key pages, forms and email.

**Rollback:** revert the commit and push. If the DB changed, restore the latest file in `~/backups/` on the server:
`gunzip -c ~/backups/db-<stamp>.sql.gz | wp db import -`

**Staging (optional):** copy `deploy.yml`, trigger it on a `staging` branch, and use a `staging` GitHub environment with its own variables.
