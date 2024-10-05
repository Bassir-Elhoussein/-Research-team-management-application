<?php
defined( 'ABSPATH' ) or exit;
function authorship_include_files( $path )
{
    if ( is_file( $path ) )
    {
        require_once $path;
    }

    elseif ( is_dir( $path ) )
    {
        foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $path ) ) as $file )
        {

            if ( $file->isFile() and 'php' === $file->getExtension() and 'index.php' !== $file->getFilename() )
            {
                require_once $file->getPathname();
            }
        }
    }
}
$paths = array
(
    MOLONGUI_AUTHORSHIP_DIR . 'includes/helpers/',
    MOLONGUI_AUTHORSHIP_DIR . 'includes/hooks/',
    MOLONGUI_AUTHORSHIP_DIR . 'includes/deprecated/',
    MOLONGUI_AUTHORSHIP_DIR . 'includes/compat.php',
);
foreach ( $paths as $path ) authorship_include_files( $path );