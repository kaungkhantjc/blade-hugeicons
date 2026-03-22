// @ts-check
import fs from 'node:fs/promises';
import path from 'node:path';
import {kebabCase} from 'change-case';

import React from 'react';
import {renderToStaticMarkup} from 'react-dom/server';
import {HugeiconsIcon} from '@hugeicons/react';
import * as Icons from '@hugeicons/core-free-icons';

const DEST_DIR = path.resolve('resources/svg');

async function generate() {
    try {
        console.log(`🧹 Cleaning the /resources/svg directory...`);
        await fs.rm(DEST_DIR, {recursive: true, force: true});
        await fs.mkdir(DEST_DIR, {recursive: true});

        let generatedCount = 0;
        const seenIcons = new Set();

        for (const [iconName, iconData] of Object.entries(Icons)) {
            if (!iconName.endsWith('Icon')) {
                continue;
            }

            if (seenIcons.has(iconData)) {
                continue;
            }
            seenIcons.add(iconData);

            const nameWithoutIcon = iconName.replace(/Icon$/, '');
            const svgFilename = `${kebabCase(nameWithoutIcon)}.svg`;

            const reactElement = React.createElement(/** @type {any} */ (HugeiconsIcon), /** @type {any} */{
                icon: iconData,
                "aria-hidden": true,
                size: null,
                color: null,
                stroke: null,
                strokeWidth: null, // we override strokeWidth to default: 1.5 in @config/blade-hugeicons.php file
                className: null,
            });

            let svgString = renderToStaticMarkup(reactElement);

            // Convert explicit closing tags into self-closing tags (<path ...></path> -> <path ... />)
            svgString = svgString.replace(/<([a-zA-Z0-9]+)([^>]*)><\/\1>/g, '<$1$2/>');

            await fs.writeFile(path.join(DEST_DIR, svgFilename), svgString, 'utf-8');
            generatedCount++;

        }

        console.log(`✅ Successfully generated ${generatedCount} clean, Blade-ready SVG files!`);
    } catch (error) {
        console.error('❌ An error occurred during SVG generation:');
        console.error(error);
        process.exit(1);
    }
}

await generate();