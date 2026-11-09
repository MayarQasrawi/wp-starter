# Handoff: My Project

Keep this file current. It is the first thing a new developer reads.

## Status

| Area | State | Notes |
|---|---|---|
| Local setup | ✅ | `./scripts/setup.sh` |
| Production | ⬜ | Host: see GitHub variables (never write it here) |
| Deploy workflow | ⬜ | First run via workflow_dispatch |
| Backups | ⬜ | Daily in hosting panel + per-deploy DB export |
| Uptime monitor | ⬜ | |

## Who owns what

| Thing | Owner | Changed by |
|---|---|---|
| Theme, custom plugin, seed, scripts | Git | Pull request → merge to main |
| Pages, posts, menus, media, settings | Database | WP Admin on the live site |
| Third-party plugin versions | `plugins.txt` | PR, then update on server |
| Secrets and server details | Password manager + GitHub secrets | Project owner |

## Decisions

- YYYY-MM-DD: _why something was chosen, in one line._

## Gotchas

- _Anything that surprised you and will surprise the next person._

## Next steps

1. _Keep this list short and current. Delete items when done._
