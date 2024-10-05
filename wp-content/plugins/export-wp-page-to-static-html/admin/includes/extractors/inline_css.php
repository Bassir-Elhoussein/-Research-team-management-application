<?php

namespace ExportHtmlAdmin\inline_css;
class inline_css
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
    public function get_inline_css($url="")
    {
        $host = $this->admin->get_host($url);
        $pathname_fonts = $this->admin->getFontsPath();
        $pathname_css = $this->admin->getCssPath();
        $pathname_images = $this->admin->getImgPath();
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $exportTempDir = $this->admin->getExportTempDir();

        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);
        //$m_basename = $this->admin->middle_path_for_filename($url);

        $src = $this->admin->site_data;
        //preg_match_all("/(?<=\<img).*?(?=\/\>)/",$src,$matches_images);
        $stylesSrc = $src->find('style');
        if(!empty($stylesSrc)){
            foreach ($stylesSrc as $style) {
                $data = $style->innertext;

                preg_match_all("/(?<=url\().*?(?=\))/", $data, $images_links);

                foreach ($images_links as $key => $images) {
                    foreach ($images as $key => $image) {
                        $img_path_src = "";
                        //$path_to_dot = $this->admin->rc_path_to_dot($url, true, true);
                        if (strpos($image, 'data:') == false && strpos($image, 'svg+xml') == false && strpos($image, 'svg') == false && strpos($image, 'base64') == false) {
                            $image = html_entity_decode($image, ENT_QUOTES);
                            $image = $this->admin->ltrim_and_rtrim($image);
                            $url_basename = $this->admin->url_to_basename($image);
                            $url_basename = $this->admin->filter_filename($url_basename);
                            $item_url = \url_to_absolute($url, $image);

                            if(strpos($item_url, $host)!==false){
                                $fontExt = array("eot", "woff", "woff2", "ttf", "otf");
                                $urlExt = pathinfo($url_basename, PATHINFO_EXTENSION);
                                if (in_array($urlExt, $fontExt)) {
                                    $img_path_src = $pathname_fonts . $url_basename;
                                    $data = str_replace($image, $path_to_dot . 'fonts/' . $url_basename, $data);
                                }

                                $urlExt = pathinfo($item_url, PATHINFO_EXTENSION);
                                if (in_array($urlExt, $this->admin->getImageExtensions())) {
                                    $img_path_src = $pathname_images . $url_basename;
                                    $data = str_replace($image, $path_to_dot . 'images/' . $url_basename, $data);

                                }

                                if (strpos($item_url, 'css') !== false) {
                                    $img_path_src = $pathname_css . $url_basename;
                                    $data = str_replace($image, $path_to_dot . 'css/' . $url_basename, $data);
                                }

                                if(!$saveAllAssetsToSpecificDir){
                                    $middle_p = $this->admin->rc_get_url_middle_path_for_assets($item_url);
                                    if(!file_exists($exportTempDir .'/'. $middle_p)){
                                        @mkdir($exportTempDir .'/'. $middle_p, 0777, true);
                                    }
                                    $img_path_src = $exportTempDir .'/'. $middle_p .'/'. $url_basename;
                                }

                                if ($this->admin->getSettings('image_to_webp')){
                                    $webp_basename = str_replace( array("jpg","jpeg", "png", 'bmp'), "webp", $url_basename);
                                    $img_path_src = $pathname_images . $webp_basename;
                                }

                                if (!empty($img_path_src)&&!file_exists($img_path_src)) {
                                    $this->admin->update_export_log($item_url);

                                    $urlExt = pathinfo($url_basename, PATHINFO_EXTENSION);
                                    if ( in_array($urlExt, array('jpg', 'jpeg', 'png')) && $this->admin->getSettings('image_to_webp')){
                                        $this->admin->saveImageToWebp($item_url, $img_path_src);
                                        $url_basename = isset($webp_basename) ? $webp_basename : $url_basename;
                                    }
                                    else{
                                        $this->admin->saveFile($item_url, $img_path_src);
                                    }

                                    $this->admin->update_urls_log($image, $url_basename, 'new_file_name');
                                    $this->admin->update_urls_log($image, 1);

                                }
                            }
                        }
                    }
                }

                $style->innertext = $data;
            }

            $this->admin->site_data = $src;
        }
        return true;
    }

    public function get_div_inline_css($url="")
    {
        $host = $this->admin->get_host($url);
        $pathname_fonts = $this->admin->getFontsPath();
        $pathname_css = $this->admin->getCssPath();
        $pathname_images = $this->admin->getImgPath();
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $keepSameName = $this->admin->getKeepSameName();
        $exportTempDir = $this->admin->getExportTempDir();

        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);
        //$m_basename = $this->admin->middle_path_for_filename($url);

        $src = $this->admin->site_data;
        //preg_match_all("/(?<=\<img).*?(?=\/\>)/",$src,$matches_images);
        $stylesDivs = $src->find('div[style]');
        if(!empty($stylesDivs)){
            foreach ($stylesDivs as $div) {

                if(isset($div->style)){
                    $data = $div->style;

                    preg_match_all("/(?<=url\().*?(?=\))/", $data, $images_links);

                    foreach ($images_links as $key => $images) {
                        foreach ($images as $key => $image) {
                            //$path_to_dot = $this->admin->rc_path_to_dot($url, true, true);
                            if (strpos($image, 'data:') == false && strpos($image, 'svg+xml') == false && strpos($image, 'svg') == false && strpos($image, 'base64') == false) {
                                //$this->admin->update_urls_log($image);
                                $image = html_entity_decode($image, ENT_QUOTES);
                                $image = $this->admin->ltrim_and_rtrim($image);

                                $url_basename = $this->admin->url_to_basename($image);
                                $url_basename = $this->admin->filter_filename($url_basename);
                                $item_url = \url_to_absolute($url, $image);
                                $img_path_src = "";

                                $m_basename = $this->admin->middle_path_for_filename($item_url);

                                if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                                    $m_basename = explode('-', $m_basename);
                                    $m_basename = implode('/', $m_basename);
                                }


                                if (strpos($item_url, $host) !== false) {
                                    $fontExt = array("eot", "woff", "woff2", "ttf", "otf");
                                    $urlExt = pathinfo($url_basename, PATHINFO_EXTENSION);
                                    if (in_array($urlExt, $fontExt)) {
                                        $img_path_src = $pathname_fonts . $url_basename;
                                        $data = str_replace($image, $path_to_dot . 'fonts/' . $url_basename, $data);
                                    }

                                    $urlExt = pathinfo($item_url, PATHINFO_EXTENSION);
                                    if (in_array($urlExt, $this->admin->getImageExtensions())) {
                                        $img_path_src = $pathname_images . $m_basename . $url_basename;
                                        $data = str_replace($image, $path_to_dot . 'images/' . $m_basename . $url_basename, $data);

                                    }

                                    if (strpos($item_url, 'css') !== false) {
                                        $img_path_src = $pathname_css . $url_basename;
                                        $data = str_replace($image, $path_to_dot . 'css/' . $url_basename, $data);
                                    }

                                    if(!$saveAllAssetsToSpecificDir){
                                        $middle_p = $this->admin->rc_get_url_middle_path_for_assets($item_url);
                                        if(!file_exists($exportTempDir .'/'. $middle_p)){
                                            @mkdir($exportTempDir .'/'. $middle_p, 0777, true);
                                        }
                                        $img_path_src = $exportTempDir .'/'. $middle_p .'/'. $url_basename;
                                    }

                                    if ($this->admin->getSettings('image_to_webp')){
                                        $basename = str_replace( array("jpg","jpeg", "png", 'bmp'), "webp", $url_basename);
                                        $img_path_src = $pathname_images . $m_basename . $basename;
                                    }

                                    if (!empty($img_path_src)&&!file_exists($img_path_src)) {
                                        $this->admin->update_export_log($item_url);

                                        $urlExt = pathinfo($url_basename, PATHINFO_EXTENSION);
                                        if ( in_array($urlExt, array('jpg', 'jpeg', 'png')) && $this->admin->getSettings('image_to_webp')){
                                            $this->admin->saveImageToWebp($item_url, $img_path_src);
                                        }
                                        else{
                                            $this->admin->saveFile($item_url, $img_path_src);
                                        }

                                        $this->admin->update_urls_log($image, $basename, 'new_file_name');
                                        $this->admin->update_urls_log($image, 1);

                                    }
                                }
                            }
                        }
                    }

                    $div->style = $data;
                }
            }

            $this->admin->site_data = $src;
        }
        return true;
    }
}
