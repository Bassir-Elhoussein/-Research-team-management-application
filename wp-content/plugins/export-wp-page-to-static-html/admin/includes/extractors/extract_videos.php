<?php

namespace ExportHtmlAdmin\extract_videos;

class extract_videos
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
    public function get_videos($url="")
    {
        $src = $this->admin->site_data;
        $videoLinks = $src->find('video');
        $sourceLinks = $src->find('source');
        $videoHrefLinks = $src->find('a');
        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();

        if (!empty($videoLinks)) {
            $videos_path = $this->admin->getVideosPath();
            if (!file_exists($videos_path)) {
                @mkdir($videos_path);
            }

            foreach ($videoLinks as $link) {
                if (isset($link->src) && !empty($link->src)) {
                    $src_link = $link->src;
                    $src_link = html_entity_decode($src_link, ENT_QUOTES);
                    $src_link = $this->admin->ltrim_and_rtrim($src_link);

                    $src_link = \url_to_absolute($url, $src_link);
                    $host = $this->admin->get_host($src_link);

                    $videoExts = $this->admin->getVideoExtensions();
                    $videoBasename = $this->admin->url_to_basename($src_link);
                    $videoBasename = $this->admin->filter_filename($videoBasename);
                    $urlExt = pathinfo($videoBasename, PATHINFO_EXTENSION);
                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $src_link);

                    if (in_array($urlExt, $videoExts) && strpos($url, $host) !== false && !$exclude_url) {
                        $newlyCreatedBasename = $this->save_video($src_link, $url);

                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                            $link->href = $path_to_dot . $middle_p . $newlyCreatedBasename;
                            $link->src = $path_to_dot . $middle_p . $newlyCreatedBasename;
                        }
                        else {
                            $link->href = $path_to_dot .'videos/'. $newlyCreatedBasename;
                            $link->src = $path_to_dot .'videos/'. $newlyCreatedBasename;
                        }

                    }
                }
            }
        }

        if (!empty($sourceLinks)) {
            $videos_path = $this->admin->getVideosPath();
            if (!file_exists($videos_path)) {
                @mkdir($videos_path);
            }

            foreach ($sourceLinks as $link) {
                if (isset($link->src) && !empty($link->src)) {
                    $src_link = $link->src;
                    $src_link = html_entity_decode($src_link, ENT_QUOTES);
                    $src_link = $this->admin->ltrim_and_rtrim($src_link);

                    $src_link = \url_to_absolute($url, $src_link);
                    $host = $this->admin->get_host($src_link);

                    $videoExts = $this->admin->getVideoExtensions();
                    $videoBasename = $this->admin->url_to_basename($src_link);
                    $videoBasename = $this->admin->filter_filename($videoBasename);
                    $urlExt = pathinfo($videoBasename, PATHINFO_EXTENSION);
                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $src_link);

                    if (in_array($urlExt, $videoExts) && strpos($url, $host) !== false && !$exclude_url) {
                        $newlyCreatedBasename = $this->save_video($src_link, $url);

                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                            $link->href = $path_to_dot . $middle_p . $newlyCreatedBasename;
                            $link->src = $path_to_dot . $middle_p . $newlyCreatedBasename;
                        }
                        else {
                            $link->href = $path_to_dot .'videos/'. $newlyCreatedBasename;
                            $link->src = $path_to_dot .'videos/'. $newlyCreatedBasename;
                        }

                    }
                }
            }
        }

        if (!empty($videoHrefLinks)){
            foreach ($videoHrefLinks as $link) {
                if (isset($link->href) && !empty($link->href)) {
                    $src_link = $link->href;
                    $src_link = html_entity_decode($src_link, ENT_QUOTES);

                    $src_link = $this->admin->ltrim_and_rtrim($src_link);

                    $src_link = \url_to_absolute($url, $src_link);
                    $host = $this->admin->get_host($src_link);

                    $videoExts = $this->admin->getVideoExtensions();
                    $audioBasename = $this->admin->url_to_basename($src_link);
                    $audioBasename = $this->admin->filter_filename($audioBasename);

                    $urlExt = pathinfo($audioBasename, PATHINFO_EXTENSION);


                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $src_link);

                    if ( in_array($urlExt, $videoExts) && strpos($url, $host) !== false && !$exclude_url) {

                        $newlyCreatedBasename = $this->save_video($src_link, $url);
                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                            $link->href = $path_to_dot . $middle_p . $newlyCreatedBasename;
                            $link->src = $path_to_dot . $middle_p . $newlyCreatedBasename;
                        }
                        else {

                            $link->href = $path_to_dot .'videos/' . $newlyCreatedBasename;
                            $link->src = $path_to_dot .'videos/' . $newlyCreatedBasename;
                        }

                    }
                }
            }
        }


        $this->admin->site_data = $src;


    }

    public function save_video($video_url_prev = "", $found_on = "")
    {
        $video_url = $video_url_prev;
        $videos_path = $this->admin->getVideosPath();
        $video_url = \url_to_absolute($found_on, $video_url);
        $m_basename = $this->admin->middle_path_for_filename($video_url);
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $exportTempDir = $this->admin->getExportTempDir();
        $keepSameName = $this->admin->getKeepSameName();
        $host = $this->admin->get_host($video_url);
        $basename = $this->admin->url_to_basename($video_url);

        if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
            $m_basename = explode('-', $m_basename);
            $m_basename = implode('/', $m_basename);
        }

        if (
            !$this->admin->is_link_exists($video_url)
            && $this->admin->update_export_log($video_url)
        ) {
            $this->admin->add_urls_log($video_url, $found_on, 'video');


            if (!(strpos($basename, ".") !== false)) {
                $basename = rand(5000, 9999) . ".mp4";
                $this->admin->update_urls_log($video_url_prev, $basename, 'new_file_name');
            }
            $basename = $this->admin->filter_filename($basename);

            $my_file = $videos_path . $m_basename . $basename;

            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($video_url);
            if(!$saveAllAssetsToSpecificDir){

                if(!file_exists($exportTempDir .'/'. $middle_p)){
                    @mkdir($exportTempDir .'/'. $middle_p, 0777, true);
                }
                $my_file = $exportTempDir .'/'. $middle_p .'/'. $basename;
            }
            else{
                if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                    if(!file_exists($videos_path .'/'. $m_basename)){
                        @mkdir($videos_path . $m_basename, 0777, true);
                    }

                    $my_file = $videos_path . $m_basename . $basename;
                }
                else{
                    if(!file_exists($videos_path)){
                        @mkdir($videos_path);
                    }
                }
            }

            if (!file_exists($my_file)) {
                $this->admin->saveFile($video_url, $my_file);
                $this->admin->update_urls_log($video_url_prev, 1);
            }

            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;
        }
        else{

            if (!(strpos($basename, ".") !== false) && $this->admin->get_newly_created_basename_by_url($video_url) != false){
                return $m_basename . $this->admin->get_newly_created_basename_by_url($video_url);
            }

            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;
        }


        return false;
    }
}

