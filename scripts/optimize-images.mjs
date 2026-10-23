// Builds the resized WebP copies that next/image served on the Next.js site.
// Originals in public/media are never modified; copies go to public/media-optimized/<path>/<width>.webp.
// Same settings as the Next.js image optimizer: widths from images.imageSizes + images.deviceSizes,
// WebP at quality 75, auto-orientation, and no upscaling past the original width.
import { mkdirSync, readdirSync, statSync, writeFileSync, existsSync } from 'node:fs';
import { dirname, extname, join, relative, sep } from 'node:path';
import sharp from 'sharp';

export const ALL_SIZES = [32, 48, 64, 96, 128, 256, 384, 640, 750, 828, 1080, 1200, 1920, 2048, 3840];
const QUALITY = 75;
const SOURCE = 'public/media';
const TARGET = 'public/media-optimized';

const walk = (dir) =>
    readdirSync(dir).flatMap((name) => {
        const path = join(dir, name);
        return statSync(path).isDirectory() ? walk(path) : [path];
    });

const manifest = {};
let created = 0;

for (const file of walk(SOURCE).filter((path) => /\.(jpe?g|png)$/i.test(path))) {
    const input = sharp(file).rotate();
    const { width, height } = await input.metadata();
    const relativePath = relative('public', file).split(sep).join('/');
    const folder = join(TARGET, relative(SOURCE, file).slice(0, -extname(file).length));
    // Widths at or above the original are served at the original size, as the Next.js optimizer does.
    const widths = [...new Set(ALL_SIZES.map((size) => Math.min(size, width)))];

    for (const target of widths) {
        const output = join(folder, `${target}.webp`);
        if (existsSync(output) && statSync(output).mtimeMs >= statSync(file).mtimeMs) continue;
        mkdirSync(dirname(output), { recursive: true });
        await sharp(file).rotate().resize({ width: target, withoutEnlargement: true }).webp({ quality: QUALITY }).toFile(output);
        created++;
    }

    manifest[`/${relativePath}`] = {
        width,
        height,
        folder: `/${relative('public', folder).split(sep).join('/')}`,
    };
}

writeFileSync(join(TARGET, 'manifest.json'), `${JSON.stringify(manifest, null, 2)}\n`);
console.log(`media-optimized: ${Object.keys(manifest).length} images, ${created} new file(s).`);
