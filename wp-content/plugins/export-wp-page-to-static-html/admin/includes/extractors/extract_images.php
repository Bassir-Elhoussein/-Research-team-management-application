<?php

namespace ExportHtmlAdmin\extract_images;
class extract_images
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
    public function get_images($url="")
    {
        $src = $this->admin->site_data;
        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $imgExts = $this->admin->getImageExtensions();

        $images = $src->find('img');
        $image_links = $src->find('a');

        if (!empty($images)) {
            foreach ($images as $img) {
                if (strpos($img->src, 'data:') == false && strpos($img->src, 'svg+xml') == false && strpos($img->src, 'base64') == false) {
                    $img_src = html_entity_decode($img->src, ENT_QUOTES);
                    $img_src = $this->admin->ltrim_and_rtrim($img_src);
                    $img_src = \url_to_absolute($url, $img_src);

                    $urlExt  = pathinfo($img_src, PATHINFO_EXTENSION);

                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $img_src, true);

                    if (in_array($urlExt, $imgExts) && !$exclude_url) {


                        $basename = $this->save_image($img_src, $url);
//                        $this->admin->url_to_basename($img_src);
//                        $basename = $this->admin->filter_filename($basename);

                        if (!$saveAllAssetsToSpecificDir) {
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($img_src);
                            $img->setAttribute('src', $path_to_dot . $middle_p . $basename);
                        } else {
                            $img->setAttribute('src', $path_to_dot . 'images/' . $basename);
                        }

                    }
                }

                if (isset($img->attr['data-lazyload']) && strpos($img->attr['data-lazyload'], 'data:') == false && strpos($img->attr['data-lazyload'], 'svg+xml') == false && strpos($img->attr['data-lazyload'], 'base64') == false) {
                    $imgSrc = $img->attr['data-lazyload'];

                    $img_src = html_entity_decode($imgSrc, ENT_QUOTES);
                    $img_src = $this->admin->ltrim_and_rtrim($img_src);
                    $imgSrc  = \url_to_absolute($url, $img_src);

                    $urlExt  = pathinfo($imgSrc, PATHINFO_EXTENSION);

                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $imgSrc);

                    if (in_array($urlExt, $imgExts) && !$exclude_url) {
                        $basename = $this->save_image($imgSrc, $url);
//                        $basename = $this->admin->url_to_basename($imgSrc);
//                        $this->admin->filter_filename($basename);

                        if (!$saveAllAssetsToSpecificDir) {
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($img->src);
                            $img->setAttribute('data-lazyload', $path_to_dot . $middle_p . $basename);
                        } else {
                            $img->setAttribute('data-lazyload', $path_to_dot . 'images/' . $basename);
                        }
                    }
                }

                if (isset($img->srcset)) {
                    $srcset = $img->srcset;
                    $srcset = explode(' ', $srcset);

                    $imgFind    = array();
                    $imgReplace = array();
                    foreach ($srcset as $key => $item) {
                        $img_src = html_entity_decode($item, ENT_QUOTES);
                        $img_src = $this->admin->ltrim_and_rtrim($img_src);
                        $item_url = \url_to_absolute($url, $img_src);

                        $urlExt  = pathinfo($item_url, PATHINFO_EXTENSION);
                        //echo $urlExt;

                        $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $item_url);
                        if (in_array($urlExt, $imgExts) && !$exclude_url) {
//                            $basename  = $this->admin->url_to_basename($item);
//                            $basename  = $this->admin->filter_filename($basename);
                            $basename = $this->save_image($item_url, $url);
                            $imgFind[] = $item;

                            if (!$saveAllAssetsToSpecificDir) {
                                $middle_p     = $this->admin->rc_get_url_middle_path_for_assets($item_url);
                                $imgReplace[] = $path_to_dot . $middle_p . $basename;
                            } else {
                                $imgReplace[] = $path_to_dot . 'images/' . $basename;
                            }

                        }
                    }

                    $img->setAttribute('srcset', str_replace($imgFind, $imgReplace, $img->srcset));
                }

            }
        }

        if (!empty($image_links)){
            foreach ($image_links as $img) {
                if (isset($img->href) && !empty($img->href)) {
                    $src_link = $img->href;
                    $src_link = html_entity_decode($src_link, ENT_QUOTES);

                    $src_link = $this->admin->ltrim_and_rtrim($src_link);

                    $src_link = \url_to_absolute($url, $src_link);
                    $host = $this->admin->get_host($src_link);

                    $imageBasename = $this->admin->url_to_basename($src_link);
                    $imageBasename = $this->admin->filter_filename($imageBasename);

                    $urlExt = pathinfo($imageBasename, PATHINFO_EXTENSION);


                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $src_link);

                    if ( in_array($urlExt, $imgExts) && strpos($url, $host) !== false && !$exclude_url) {


                        $newlyCreatedBasename = $this->save_image($src_link, $url);
                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                            $img->href = $path_to_dot . $middle_p . $newlyCreatedBasename;
                            $img->src = $path_to_dot . $middle_p . $newlyCreatedBasename;
                        }
                        else {
                            $img->href = $path_to_dot .'images/' . $newlyCreatedBasename;
                        }

                    }
                }
            }
        }


        $this->admin->site_data = $src;
    }

    public function save_image($img_src = "", $found_on = "")
    {
        $pathname_images = $this->admin->getImgPath();
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $exportTempDir = $this->admin->getExportTempDir();
        $keepSameName = $this->admin->getKeepSameName();




        if (strpos($img_src, 'data:') == false) {
            $img_src = html_entity_decode($img_src, ENT_QUOTES);
            $basename = $this->admin->url_to_basename($img_src);
            $basename = $this->admin->filter_filename($basename);

            $img_src = \url_to_absolute($found_on, $img_src);

            $m_basename = $this->admin->middle_path_for_filename($img_src);
            if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                $m_basename = explode('-', $m_basename);
                $m_basename = implode('/', $m_basename);
            }
            $host = $this->admin->get_host($img_src);

            if (!$this->admin->is_link_exists($img_src)) {
                $this->admin->update_export_log($img_src);
                $this->admin->add_urls_log($img_src, $found_on, 'image');

                if (strpos($basename, '.') == false) {
                    $basename = rand(5000, 9999) . ".jpg";
                    $this->admin->update_urls_log($img_src, $basename, 'new_file_name');
                }
                $basename = $this->admin->filter_filename($basename);


                $middle_p = $this->admin->rc_get_url_middle_path_for_assets($img_src);
                if(!$saveAllAssetsToSpecificDir){
                    if(!file_exists($exportTempDir .'/'. $middle_p)){
                        @mkdir($exportTempDir .'/'. $middle_p, 0777, true);
                    }
                    $img_path_src = $exportTempDir .'/'. $middle_p .'/'. $basename;
                }
                else{
                    if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                        if(!file_exists($pathname_images . $m_basename)){
                            @mkdir($pathname_images . $m_basename, 0777, true);
                        }

                        $img_path_src = $pathname_images . $m_basename . $basename;
                    }else{
                        $img_path_src = $pathname_images . $m_basename . $basename;
                    }
                }

                if ($this->admin->getSettings('image_to_webp')){
                    $webp_basename = str_replace( array("jpg","jpeg", "png", 'bmp'), "webp", $basename);
                    $img_path_src = $pathname_images . $m_basename . $webp_basename;
                }


                if (!file_exists($img_path_src)) {
                    $urlExt = pathinfo($basename, PATHINFO_EXTENSION);
                    if ( in_array($urlExt, array('jpg', 'jpeg', 'png', 'bmp')) && $this->admin->getSettings('image_to_webp')){
                        $this->admin->saveImageToWebp($img_src, $img_path_src);
                        $basename = $webp_basename;
                    }
                    else{
                        $this->admin->saveFile($img_src, $img_path_src);
                    }

                    $this->admin->update_urls_log($img_src, 1);
                }

                if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                    return $m_basename . $basename;
                }
                return $basename;


            }
            else{

                /*if (!(strpos($basename, ".") !== false) && $this->admin->get_newly_created_basename_by_url($img_src) != false){
                    return $m_basename . $this->admin->get_newly_created_basename_by_url($img_src);
                }*/

                if ($this->admin->getSettings('image_to_webp')){
                    $basename = str_replace( array("jpg","jpeg", "png", 'bmp'), "webp", $basename);
                }

                if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                    return $m_basename . $basename;
                }
                return $basename;
            }




        }
        return false;

    }



    public function saveFile($url, $savePath)
    {
        $abs_url_to_path = $this->admin->abs_url_to_path($url);
        if (strpos($url, home_url()) !== false && file_exists($abs_url_to_path)){
            @copy($abs_url_to_path, $savePath);
        }
        else{
            $handle = @fopen($savePath, 'w') or die('Cannot open file:  ' . $savePath);
            $data = $this->admin->get_url_data($url);
            @fwrite($handle, $data);
            @fclose($handle);
        }

    }
}