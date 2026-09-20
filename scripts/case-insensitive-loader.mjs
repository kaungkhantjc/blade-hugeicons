import fs from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

export async function resolve(specifier, context, nextResolve) {
    try {
        // Attempt standard strict-case resolution first
        return await nextResolve(specifier, context);
    } catch (error) {
        // If resolution fails for a relative file path inside the package
        if (error.code === 'ERR_MODULE_NOT_FOUND' && specifier.startsWith('.')) {
            try {
                const parentDir = path.dirname(fileURLToPath(context.parentURL));
                const targetName = path.basename(specifier);
                
                // Read the actual files on the Linux disk
                const files = await fs.readdir(parentDir);
                
                // Find a file that matches case-insensitively
                const match = files.find(f => f.toLowerCase() === targetName.toLowerCase());
                
                if (match) {
                    // Reconstruct the import with the exact correct casing and try again
                    const newSpecifier = specifier.slice(0, -targetName.length) + match;
                    return await nextResolve(newSpecifier, context);
                }
            } catch {
                // Fail silently to throw the original error below
            }
        }
        throw error;
    }
}