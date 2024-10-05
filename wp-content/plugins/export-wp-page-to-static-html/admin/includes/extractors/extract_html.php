<?php

namespace ExportHtmlAdmin\extract_html;

class extract_html
{

    private $admin;

    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    /**
     * @since 2.0.0
     * @param string $url
     * @return array
     */
    public function get_HTMLs($url="")
    {
        $src = $this->admin->site_data;
        $htmlHrefLinks = $src->find('a');
        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);

        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        
        if (!empty($htmlHrefLinks)){
            foreach ($htmlHrefLinks as $link) {
                if (isset($link->href) && !empty($link->href)) {
                    $src_link = $link->href;
                    $src_link = html_entity_decode($src_link, ENT_QUOTES);

                    $src_link = $this->admin->ltrim_and_rtrim($src_link);

                    $src_link = \url_to_absolute($url, $src_link);
                    $host = $this->admin->get_host($src_link);

                    $htmlExts = $this->admin->getHtmlExtensions();
                    $htmlBasename = $this->admin->url_to_basename($src_link);
                    $htmlBasename = $this->admin->filter_filename($htmlBasename);

                    $urlExt = pathinfo($htmlBasename, PATHINFO_EXTENSION);


                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $src_link);

                    if ( in_array($urlExt, $htmlExts) && strpos($url, $host) !== false && !$exclude_url) {

                        $this->save_html($src_link, $url);

                        $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                        $link->href = $path_to_dot . $middle_p . $htmlBasename;
                        $link->src = $path_to_dot . $middle_p . $htmlBasename;


                    }
                }
            }
        }
        $this->admin->site_data = $src;

    }

    public function save_html($html_url_prev = "", $found_on = "")
    {
        $html_url = $html_url_prev;
        $html_url = \url_to_absolute($found_on, $html_url);
        $exportTempDir = $this->admin->getExportTempDir();
        $host = $this->admin->get_host($html_url);
        $basename = $this->admin->url_to_basename($html_url);

        if (
            !$this->admin->is_link_exists($html_url)
            && $this->admin->update_export_log($html_url)
        ) {
            $this->admin->add_urls_log($html_url, $found_on, 'html');


            if (!(strpos($basename, ".") !== false)) {
                $basename = rand(5000, 9999) . ".mp3";
                $this->admin->update_urls_log($html_url_prev, $basename, 'new_file_name');
            }
            $basename = $this->admin->filter_filename($basename);

            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($html_url);

            if(!file_exists($exportTempDir .'/'. $middle_p)){
                @mkdir($exportTempDir .'/'. $middle_p, 0777, true);
            }
            $my_file = $exportTempDir .'/'. $middle_p .'/'. $basename;


            if (!file_exists($my_file)) {
                $this->admin->saveFile($html_url, $my_file);

                $this->admin->update_urls_log($html_url_prev, 1);

            }

        }

        return false;
    }
}
