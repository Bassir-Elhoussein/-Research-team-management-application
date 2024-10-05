<?php

namespace ExportHtmlAdmin\extract_meta_images;
class extract_meta_images
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
    public function get_meta_images($url="")
    {
        $src = $this->admin->site_data;
        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        //preg_match_all("/(?<=\<img).*?(?=\/\>)/",$src,$matches_images);

        /*Extract shortcut icons*/
        foreach ($src->find('link') as $img) {
            if(isset($img->rel) && ($img->rel == "shortcut icon" || $img->rel == "icon"  || $img->rel == "apple-touch-icon" || $img->rel == "manifest" ) && isset($img->href) && !empty($img->href)){

                if (strpos($img->href, 'data:') == false && strpos($img->href, 'svg+xml') == false && strpos($img->href, 'base64') == false) {
                    $img_src = html_entity_decode($img->href, ENT_QUOTES);
                    $img_src = $this->admin->ltrim_and_rtrim($img_src);
                    $src_link = url_to_absolute($url, $img_src);

                    $imgExts = $this->admin->getImageExtensions();
                    $urlExt = pathinfo($src_link, PATHINFO_EXTENSION);

                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $src_link);
                    if ( (in_array($urlExt, $imgExts) || in_array($urlExt, array('webmanifest')) ) && !$exclude_url) {
                        $this->save_images($src_link, $url);
                        $basename = $this->admin->url_to_basename($src_link);
                        $basename = $this->admin->filter_filename($basename);
                        $this->admin->update_export_log($img->href);
                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                            $img->setAttribute('href', $path_to_dot . $middle_p . $basename);
                        }
                        else {
                            $img->setAttribute('href', $path_to_dot . 'images/' . $basename);
                        }
                    }
                }
            }
        }

        /*Extract meta images*/
        foreach ($src->find('meta') as $img) {
            if(isset($img->name) && $img->name == "thumbnail" && isset($img->content) && !empty($img->content)){
                if (strpos($img->content, 'data:') == false && strpos($img->content, 'svg+xml') == false && strpos($img->content, 'base64') == false) {
                    $src_link = html_entity_decode($img->content, ENT_QUOTES);
                    $src_link = $this->admin->ltrim_and_rtrim($src_link);
                    $src_link = url_to_absolute($url, $src_link);

                    $imgExts = $this->admin->getImageExtensions();
                    $urlExt = pathinfo($src_link, PATHINFO_EXTENSION);

                    if (in_array($urlExt, $imgExts)) {
                        $this->save_images($src_link, $url);
                        $basename = $this->admin->url_to_basename($src_link);
                        $basename = $this->admin->filter_filename($basename);

                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                            $img->setAttribute('content', $path_to_dot . $middle_p . $basename);
                        }
                        else {
                            $img->setAttribute('content', $path_to_dot . 'images/' . $basename);
                        }
                    }
                }
            }
        }

        /*Extract og images*/
        foreach ($src->find('meta') as $img) {
            if(isset($img->property) && $img->property == "og:image" && isset($img->content) && !empty($img->content)){
                if (strpos($img->content, 'data:') == false && strpos($img->content, 'svg+xml') == false && strpos($img->content, 'base64') == false) {
                    $src_link = html_entity_decode($img->content, ENT_QUOTES);
                    $src_link = $this->admin->ltrim_and_rtrim($src_link);
                    $src_link = url_to_absolute($url, $src_link);

                    $imgExts = $this->admin->getImageExtensions();
                    $urlExt = pathinfo($src_link, PATHINFO_EXTENSION);
                    if (in_array($urlExt, $imgExts)) {
                        $this->save_images($src_link, $url);
                        $basename = $this->admin->url_to_basename($src_link);
                        $basename = $this->admin->filter_filename($basename);

                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                            $img->setAttribute('content', $path_to_dot . $middle_p . $basename);
                        }
                        else {
                            $img->setAttribute('content', $path_to_dot . 'images/' . $basename);
                        }
                    }
                }
            }
        }

        $this->admin->site_data = $src;

        return true;
    }

    public function save_images($img_src = "", $found_on = "")
    {
        $pathname_images = $this->admin->getImgPath();
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $exportTempDir = $this->admin->getExportTempDir();



        $basename = $this->admin->url_to_basename($img_src);
        $basename = $this->admin->filter_filename($basename);

        if (!(strpos($img_src, 'data:') !== false)) {
            $this->admin->add_urls_log($img_src, $found_on, 'image5');

            if (strpos($basename, ".") == false) {
                $basename = rand(5000, 9999) . ".jpg";
            }
            $basename = $this->admin->filter_filename($basename);

            $my_file = $pathname_images . $basename;

            if(!$saveAllAssetsToSpecificDir){
                $middle_p = $this->admin->rc_get_url_middle_path_for_assets($img_src);
                if(!file_exists($exportTempDir .'/'. $middle_p)){
                    @mkdir($exportTempDir .'/'. $middle_p, 0777, true);
                }
                $my_file = $exportTempDir .'/'. $middle_p .'/'. $basename;
            }

            if (!file_exists($my_file)) {
                $this->admin->saveFile($img_src, $my_file);
            }

        }
    }
}