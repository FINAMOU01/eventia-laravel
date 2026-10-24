# EVENTIA BY N.J — site Laravel

Migration fidèle du site EVENTIA BY N.J (Next.js) vers **Laravel 12 / PHP 8.2**. Les contenus, médias, styles, animations, URLs et métadonnées sont ceux du site Next.js d'origine ; seul le moteur change.

## Stack

| Rôle | Next.js (source) | Laravel (ce dépôt) |
| --- | --- | --- |
| Rendu | React Server Components | Blade (composants anonymes) |
| Styles | Tailwind CSS v4 + `app/globals.css` | Tailwind CSS v4 + `resources/css/app.css` (même fichier) |
| Animations | Framer Motion | [Motion](https://motion.dev) (même équipe) |
| Interactions | React (hooks) | Alpine.js |
| Polices | `next/font` (Playfair Display, Montserrat) | Fontsource, auto-hébergées, mêmes polices de secours |
| Données | `lib/*.ts` | `app/Support/*.php` |

## Arborescence utile

```
app/Support/            Données et helpers (ports de lib/*.ts)
  Content.php           Contenus FR / EN (textes validés par le client)
  Site.php              Coordonnées, navigation, liens WhatsApp / mailto
  Media.php             Manifeste des médias (images, alt, cadrage)
  Metadata.php          Titres, descriptions, canonical, hreflang
  I18n.php              URLs FR (racine) / EN (/en), redirection selon la langue
resources/views/
  layouts/app.blade.php En-tête <head>, header, footer, bouton WhatsApp
  pages/                Une vue par page
  components/site/      Sections du site (hero, expertise, réalisations…)
  components/ui/        Briques (bouton, lien, reveal, média, vidéo…)
  errors/404.blade.php  Page 404 identique à celle de Next.js
resources/js/modules/   Comportements (header, carrousels, vidéos, formulaire, animations)
public/media/           Médias d'origine, copiés à l'identique
public/media-optimized/ Copies WebP redimensionnées (générées, ne pas modifier à la main)
public/build/           CSS / JS compilés (versionnés : le serveur n'a pas Node)
scripts/                optimize-images.mjs (équivalent de l'optimiseur next/image)
```

## Développement local

Prérequis : PHP 8.2+ (extensions `ctype`, `dom`, `fileinfo`, `filter`, `hash`, `iconv`, `json`, `libxml`, `mbstring`, `openssl`, `pcre`, `session`, `tokenizer`), Composer 2, Node 20+.

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build        # ou "npm run dev" pendant le développement
php artisan serve    # http://localhost:8000
```

Tests :

```bash
php artisan test
```

> Après toute modification de CSS, de JS ou de classes Tailwind dans les vues, relancez `npm run build` et versionnez `public/build/`.

## URLs

Identiques au site Next.js : français à la racine, anglais sous `/en`.

`/`, `/expertises`, `/realisations`, `/equipe`, `/recrutement`, `/contact`, `/mentions-legales` et leurs équivalents `/en/...`.

## Déploiement sur cPanel

Le site n'utilise ni base de données ni Node.js côté serveur : il suffit de PHP 8.2 (déjà actif sur l'hébergement).

1. **Envoyer le code** dans un dossier hors de `public_html`, par exemple `/home/eventianjadmin/eventia-laravel` (Git Version Control de cPanel ou gestionnaire de fichiers).
2. **Dépendances PHP** : `composer install --no-dev --optimize-autoloader`.
   - Si Composer n'est pas disponible sur l'hébergement, exécutez cette commande en local et envoyez aussi le dossier `vendor/`.
3. **Fichier `.env`** : copier `.env.example` en `.env`, puis régler :
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://eventianj.com
   APP_KEY=        # php artisan key:generate (ou générer en local et coller la valeur)
   ```
   Le fichier `.env` ne doit jamais être versionné ni placé dans un dossier public.
4. **Racine du site** : faire pointer le domaine vers le dossier `public` de Laravel.
   - cPanel → Websites → eventianj.com → Settings → **Website Folder** : `/home/eventianjadmin/eventia-laravel/public`.
   - Ne jamais exposer la racine du projet : `.env`, `vendor/` et `app/` doivent rester hors du dossier public.
5. **Permissions** : `storage/` et `bootstrap/cache/` doivent être accessibles en écriture par PHP (755 / 775 selon l'hébergement).
6. **Optimisation** (après chaque déploiement) :
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
7. **Vérifier** les 14 URLs, le changement de langue FR / EN et une URL inconnue (page 404).

Le fichier `public/.htaccess` fourni par Laravel gère la réécriture d'URL (Apache `mod_rewrite`).

## Points connus

- **Formulaire de devis** : comme sur le site Next.js, il n'y a pas d'envoi côté serveur. Le formulaire ouvre la messagerie du visiteur avec la demande pré-remplie vers `contact@eventianj.com` (`resources/js/modules/quote-form.js`, méthode `send`).
- **Images** : comme `next/image`, le site sert des copies WebP redimensionnées (qualité 75, mêmes largeurs que Next.js) via `srcset`, générées dans `public/media-optimized/` par `npm run images` (lancé aussi par `npm run build`). Les originaux de `public/media/` ne sont jamais modifiés. Après l'ajout ou le remplacement d'une photo, relancez `npm run build` et versionnez `public/media-optimized/`.
- **Médias manquants** (déjà absents du site Next.js, affichés comme « Média à remplacer ») : `public/media/realisations/littoral-sud-ouest-2026/main.jpg` et `detail-1.jpg`.
