<?php

/**
 * Vite Helper Functions
 *
 * Helper functions for integrating Vite with CodeIgniter 4.
 */

if (!function_exists('vite')) {
    /**
     * Generate Vite asset tags for development or production.
     *
     * @param string|array $entrypoints
     * @return string
     */
    function vite($entrypoints = ['resources/js/app.js']): string
    {
        $entrypoints = (array) $entrypoints;
        $output = '';

        if (isViteDevServerRunning()) {
            // Development mode - use Vite dev server
            $output .= '<script type="module" src="http://localhost:5173/@vite/client"></script>' . PHP_EOL;

            foreach ($entrypoints as $entry) {
                if (str_ends_with($entry, '.css')) {
                    $output .= '<link rel="stylesheet" href="http://localhost:5173/' . $entry . '">' . PHP_EOL;
                } else {
                    $output .= '<script type="module" src="http://localhost:5173/' . $entry . '"></script>' . PHP_EOL;
                }
            }
        } else {
            // Production mode - use built assets from manifest
            $manifest = getViteManifest();

            if ($manifest) {
                foreach ($entrypoints as $entry) {
                    if (isset($manifest[$entry])) {
                        $asset = $manifest[$entry];

                        // CSS files
                        if (isset($asset['css'])) {
                            foreach ($asset['css'] as $css) {
                                $output .= '<link rel="stylesheet" href="' . base_url('build/' . $css) . '">' . PHP_EOL;
                            }
                        }

                        // Main CSS file (for CSS entrypoints)
                        if (str_ends_with($entry, '.css') && isset($asset['file'])) {
                            $output .= '<link rel="stylesheet" href="' . base_url('build/' . $asset['file']) . '">' . PHP_EOL;
                        }

                        // JS files
                        if (!str_ends_with($entry, '.css') && isset($asset['file'])) {
                            $output .= '<script type="module" src="' . base_url('build/' . $asset['file']) . '"></script>' . PHP_EOL;
                        }
                    }
                }
            }
        }

        return $output;
    }
}

if (!function_exists('viteAsset')) {
    /**
     * Get the URL for a specific Vite asset.
     *
     * @param string $path
     * @return string
     */
    function viteAsset(string $path): string
    {
        if (isViteDevServerRunning()) {
            return 'http://localhost:5173/' . $path;
        }

        $manifest = getViteManifest();

        if ($manifest && isset($manifest[$path]['file'])) {
            return base_url('build/' . $manifest[$path]['file']);
        }

        return base_url($path);
    }
}

if (!function_exists('isViteDevServerRunning')) {
    /**
     * Check if Vite dev server is running.
     *
     * @return bool
     */
    function isViteDevServerRunning(): bool
    {
        // In production, always use built assets
        if (ENVIRONMENT === 'production') {
            return false;
        }

        // Check for hot file
        $hotFile = FCPATH . 'hot';
        if (file_exists($hotFile)) {
            return true;
        }

        // Try to connect to Vite dev server
        static $isRunning = null;

        if ($isRunning === null) {
            $handle = @fsockopen('localhost', 5173, $errno, $errstr, 0.1);
            $isRunning = $handle !== false;

            if ($handle) {
                fclose($handle);
            }
        }

        return $isRunning;
    }
}

if (!function_exists('getViteManifest')) {
    /**
     * Get the Vite manifest file contents.
     *
     * @return array|null
     */
    function getViteManifest(): ?array
    {
        static $manifest = null;

        if ($manifest === null) {
            $manifestPath = FCPATH . 'build/.vite/manifest.json';

            // Fallback to old manifest location
            if (!file_exists($manifestPath)) {
                $manifestPath = FCPATH . 'build/manifest.json';
            }

            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
            }
        }

        return $manifest;
    }
}

if (!function_exists('viteStyles')) {
    /**
     * Generate only CSS link tags for Vite.
     *
     * @param string|array $entrypoints
     * @return string
     */
    function viteStyles($entrypoints = ['resources/css/app.css']): string
    {
        $entrypoints = (array) $entrypoints;
        $output = '';

        if (isViteDevServerRunning()) {
            foreach ($entrypoints as $entry) {
                $output .= '<link rel="stylesheet" href="http://localhost:5173/' . $entry . '">' . PHP_EOL;
            }
        } else {
            $manifest = getViteManifest();

            if ($manifest) {
                foreach ($entrypoints as $entry) {
                    if (isset($manifest[$entry]['file'])) {
                        $output .= '<link rel="stylesheet" href="' . base_url('build/' . $manifest[$entry]['file']) . '">' . PHP_EOL;
                    }
                }
            }
        }

        return $output;
    }
}

if (!function_exists('viteScripts')) {
    /**
     * Generate only script tags for Vite.
     *
     * @param string|array $entrypoints
     * @return string
     */
    function viteScripts($entrypoints = ['resources/js/app.js']): string
    {
        $entrypoints = (array) $entrypoints;
        $output = '';

        if (isViteDevServerRunning()) {
            $output .= '<script type="module" src="http://localhost:5173/@vite/client"></script>' . PHP_EOL;

            foreach ($entrypoints as $entry) {
                $output .= '<script type="module" src="http://localhost:5173/' . $entry . '"></script>' . PHP_EOL;
            }
        } else {
            $manifest = getViteManifest();

            if ($manifest) {
                foreach ($entrypoints as $entry) {
                    if (isset($manifest[$entry]['file'])) {
                        $output .= '<script type="module" src="' . base_url('build/' . $manifest[$entry]['file']) . '"></script>' . PHP_EOL;
                    }
                }
            }
        }

        return $output;
    }
}
