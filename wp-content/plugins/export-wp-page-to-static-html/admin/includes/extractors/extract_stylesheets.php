<?php

namespace ExportHtmlAdmin\extract_stylesheets;
class extract_stylesheets
{

    private  $admin;

    public function __construct($admin)
    {
        $this->admin = $admin;
    }


    /**
     * @since 2.0.0
     * @param string $url
     * @return array
     */
    public function get_stylesheets($url="")
    {
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $src = $this->admin->site_data;
        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);
        //preg_match_all("/(?<=\<link rel='stylesheet|\<link rel=\"stylesheet).*?(?=\>)/",$src,$matches);
        $cssLinks = $src->find('link');

        if(!empty($cssLinks)){

            foreach ($cssLinks as $key => $link) {
                if(isset($link->href) && !empty($link->href) ){
                    $href_link = $link->href;
                    $href_link = \html_entity_decode($href_link, ENT_QUOTES);
                    $href_link = $this->admin->ltrim_and_rtrim($href_link);

                    $href_link = \url_to_absolute($url, $href_link);
                    $host = $this->admin->get_host($href_link);
                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls', false, $href_link);
                    if( !empty($host) && strpos($href_link, '.css')!==false && strpos($url, $host)!==false && !$exclude_url){
                        $newlyCreatedBasename = $this->save_stylesheet($href_link, $url);
                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($href_link);
                            $link->href = $path_to_dot . $middle_p . $newlyCreatedBasename;
                        }
                        else{
                            $link->href = $path_to_dot .'css/'. $newlyCreatedBasename;
                        }

                    }
                }
            }
            $this->admin->site_data = $src;
        }

    }

    /**
     * @since 2.0.0
     * @param string $stylesheet_url
     * @param string $found_on
     * @return false|string
     */
    public function save_stylesheet($stylesheet_url = "", $found_on = "")
    {
        $pathname_fonts = $this->admin->getFontsPath();
        $pathname_css = $this->admin->getCssPath();
        $pathname_images = $this->admin->getImgPath();
        $host = $this->admin->get_host($found_on);
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $exportTempDir = $this->admin->getExportTempDir();
        $keepSameName = $this->admin->getKeepSameName();

        //$stylesheet_url = url_to_absolute($found_on, $stylesheet_url);
        $m_basename = $this->admin->middle_path_for_filename($stylesheet_url);
        $basename = $this->admin->url_to_basename($stylesheet_url);

        if (!$this->admin->rc_is_link_already_generated($stylesheet_url)
        ) {
            $this->admin->update_export_log($stylesheet_url, 'copying', '');
            $data = $this->admin->get_url_data($stylesheet_url);
            $this->admin->add_urls_log($stylesheet_url, $found_on, 'css');
            preg_match_all("/(?<=url\().*?(?=\))/", $data, $images_links);

            foreach ($images_links as $key => $images) {
                foreach ($images as $image) {
                    $image_url = $this->admin->ltrim_and_rtrim($image);
                    if (strpos($image_url, 'data:') == false && strpos($image_url, 'data:image/') == false && strpos($image_url, 'image/svg') == false && strpos($image_url, 'base64') == false) {
                        $image_url = \html_entity_decode($image_url, ENT_QUOTES);
                        $image_url = $this->admin->ltrim_and_rtrim($image_url);
                        $newImageUrl = url_to_absolute($stylesheet_url, $image_url);
                        $this->admin->add_urls_log($image_url, $stylesheet_url, 'cssFile');
                        $item_url = $newImageUrl;
                        $url_basename = $this->admin->url_to_basename($item_url);
                        $url_basename = $this->admin->filter_filename($url_basename);

                        if(!$saveAllAssetsToSpecificDir){
                            $path_to_dot = $this->admin->rc_path_to_dot($item_url);
                        }
                        else{
                            if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                                $path_to_dot = $this->urlToDot($this->admin->middle_path_for_filename($item_url));
                            }
                            else{
                                $path_to_dot = './../';
                            }

                        }
                        if (strpos($item_url, $host)!==false) {
                            $urlExt = \pathinfo($url_basename, PATHINFO_EXTENSION);

                            $fontExt = array("eot", "woff", "woff2", "ttf", "otf");
                            if (in_array($urlExt, $fontExt)) {
                                $my_file = $pathname_fonts . $url_basename;
                                $data = \str_replace($image, $path_to_dot . 'fonts/' . $url_basename, $data);
                            }

                            if (in_array($urlExt, $this->admin->getImageExtensions())) {
                                $my_file = $pathname_images . $url_basename;
                                $data = \str_replace($image, $path_to_dot . 'images/' . $url_basename, $data);

                            }

                            if (strpos($item_url, 'css') !== false) {
                                $my_file = $pathname_css . $url_basename;
                                $data = \str_replace($image, $path_to_dot . 'css/' . $url_basename, $data);
                            }

                            if (isset($my_file) && !file_exists($my_file)) {
                                $this->admin->saveFile($item_url, $my_file);
                            }
                            else{
                                $this->admin->update_urls_log($image_url, $url_basename, 'new_file_name', false, $item_url);
                                $this->admin->update_urls_log($image_url, 1);
                            }
                        }
                    }
                }
            }

            if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                $m_basename = explode('-', $m_basename);
                $m_basename = implode('/', $m_basename);
            }

            if (strpos($basename, ".css") == false) {
                $basename = rand(5000, 9999) . ".css";
                $this->admin->update_urls_log($stylesheet_url, $basename, 'new_file_name');
            }
            $basename = $this->admin->filter_filename($basename);

            if (!empty($m_basename)) {
                $my_file = $pathname_css . $m_basename . $basename;
            } else {
                $my_file = $pathname_css . $basename;
            }

            if(!$saveAllAssetsToSpecificDir){
                $middle_p = $this->admin->rc_get_url_middle_path_for_assets($stylesheet_url);
                if(!file_exists($exportTempDir .'/'. $middle_p)){
                    @mkdir($exportTempDir .'/'. $middle_p, 0777, true);
                }
                $my_file = $exportTempDir .'/'. $middle_p .'/'. $basename;
            }
            else{
                if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                    if(!file_exists($exportTempDir .'/'. $m_basename)){
                        @mkdir($pathname_css . $m_basename, 0777, true);
                    }

                    $my_file = $pathname_css . $m_basename . $basename;
                }
            }

            if (!file_exists($my_file)) {
                $handle = @fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
                @fwrite($handle, $data);
                fclose($handle);
                $this->admin->update_urls_log($stylesheet_url, 1);
            }

            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;
        }

        else{

            if (!(strpos($basename, ".") !== false) && $this->admin->get_newly_created_basename_by_url($stylesheet_url) != false){
                return $m_basename . $this->admin->get_newly_created_basename_by_url($stylesheet_url);
            }

            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;
        }

    }

    public function urlToDot($url){
        $slashCount = explode('-', $url);
        $dot = './';
        for ($i=0; $i<count($slashCount); $i++){
            $dot .= '../';
        }
        return $dot;
    }

}
