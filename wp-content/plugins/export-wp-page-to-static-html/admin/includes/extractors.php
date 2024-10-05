<?php

namespace ExportHtmlAdmin\Extractors;
/**
 * Class name: Extractors
 */
class Extractors extends \ExportHtmlAdmin\Export_Wp_Page_To_Static_Html_Admin
{

    public function __construct()
    {
        $this->extractorFiles();
    }

    public function extractorFiles()
    {
        require 'extractors/extract_stylesheets.php';
        require 'extractors/extract_scripts.php';
        require 'extractors/extract_images.php';
        require 'extractors/inline_css.php';
        require 'extractors/extract_meta_images.php';
        require 'extractors/extract_videos.php';
        require 'extractors/extract_audios.php';
        require 'extractors/extract_documents.php';
        require 'extractors/extract_html.php';

    }



}

new Extractors;