# Skylar Furri — Skylar.Rest

**Current version:** v0.0.1

## File layout

```
/index.php
/css/style.css
/fonts/alierons.otf     <- put your font file here
/images/skylar.png      <- put your image here (used as favicon + pfp + embed image)
/LICENSE
```

## Setup

1. Drop these files onto a PHP-enabled webserver (PHP 7.4+ is fine).
2. Make sure `/fonts/alierons.otf` and `/images/skylar.png` exist at those
   exact paths relative to the site root.
3. Open `index.php` and edit the two config lines near the top:

   ```php
   $github_owner = "yourusername";
   $github_repo  = "yourrepo";
   ```

   to match the GitHub repo you want the commit timeline pulled from.

4. To release a new version, bump the `$site_version` variable near the
   top of `index.php` (it drives the version badge in the page title and
   the git-log header).

That's it — the page fetches the latest commits live from GitHub's public
API (`api.github.com`) on every page load, no build step or database
needed. If the repo is private or the API rate limit is hit, the timeline
section shows a small "no commits found" message instead of erroring out.

## Notes

- The Discord/Open Graph embed color is set to `#721e1e` via the
  `theme-color` meta tag, and uses `/images/skylar.png` as the embed image.
- Licensing: see `LICENSE` — this project is AGPLv3 plus an added
  non-commercial clause. Non-commercial/personal use is fine; commercial
  use requires separate permission from Skylar Furri.