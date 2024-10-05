<?php

namespace ExportHtmlAdmin\extract_scripts;
class extract_scripts
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
    public function get_scripts($url="")
    {
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $src = $this->admin->site_data;
        $jsLinks = $src->find('script');
        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);

        if (!empty($jsLinks)) {
            foreach ($jsLinks as $key => $link) {
                if (isset($link->src) && !empty($link->src)) {
                    $src_link = $link->src;
                    $src_link = html_entity_decode($src_link, ENT_QUOTES);
                    $src_link = $this->admin->ltrim_and_rtrim($src_link);
                    $src_link = \url_to_absolute($url, $src_link);
                    $host = $this->admin->get_host($src_link);
                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $src_link);

                    if (!empty($host) && strpos($src_link, '.js') !== false && strpos($url, $host) !== false && !$exclude_url) {
                        $newlyCreatedBasename = $this->save_scripts($src_link, $url);
                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                            $link->src = $path_to_dot . $middle_p . $newlyCreatedBasename;
                        }
                        else {
                            $link->src = $path_to_dot .'js/'. $newlyCreatedBasename;
                        }
                    }
                }
            }

            $this->admin->site_data = $src;
        }

    }

    public function save_scripts($script_url_prev = "", $found_on = "")
    {
        $script_url = $script_url_prev;
        $pathname_js = $this->admin->getJsPath();
        $script_url = \url_to_absolute($found_on, $script_url);
        $m_basename = $this->admin->middle_path_for_filename($script_url);
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $exportTempDir = $this->admin->getExportTempDir();
        $host = $this->admin->get_host($script_url);
        $keepSameName = $this->admin->getKeepSameName();
        $basename = $this->admin->url_to_basename($script_url);

        if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
            $m_basename = explode('-', $m_basename);
            $m_basename = implode('/', $m_basename);
        }

        if (!$this->admin->is_link_exists($script_url_prev)) {
            $this->admin->add_urls_log($script_url, $found_on, 'js');
            $this->admin->update_export_log($script_url);

            if (!(strpos($basename, ".") !== false)) {
                $basename = rand(5000, 9999) . ".js";
                $this->admin->update_urls_log($script_url_prev, $basename, 'new_file_name');
            }
            $basename = $this->admin->filter_filename($basename);

            $my_file = $pathname_js . $m_basename . $basename;

            if(!$saveAllAssetsToSpecificDir){
                $middle_p = $this->admin->rc_get_url_middle_path_for_assets($script_url);
                if(!file_exists($exportTempDir .'/'. $middle_p)){
                    @mkdir($exportTempDir .'/'. $middle_p, 0777, true);
                }
                $my_file = $exportTempDir .'/'. $middle_p .'/'. $basename;
            }
            else{
                if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                    if(!file_exists($pathname_js .'/'. $m_basename)){
                        @mkdir($pathname_js . $m_basename, 0777, true);
                    }

                    $my_file = $pathname_js . $m_basename . $basename;
                }
            }

            if (!file_exists($my_file)) {

                $this->admin->saveFile($script_url, $my_file);

                $this->admin->update_urls_log($script_url_prev, 1);

            }


            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;

        }
        else{

            if (!(strpos($basename, ".") !== false) && $this->admin->get_newly_created_basename_by_url($script_url) != false){
                return $m_basename . $this->admin->get_newly_created_basename_by_url($script_url);
            }

            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;
        }

        return false;
    }

}