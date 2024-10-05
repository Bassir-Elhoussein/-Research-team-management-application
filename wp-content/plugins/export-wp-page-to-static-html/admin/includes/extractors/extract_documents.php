<?php

namespace ExportHtmlAdmin\extract_documents;

class extract_documents
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
    public function get_documents($url="")
    {
        $src = $this->admin->site_data;
        $documentHrefLinks = $src->find('a');
        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);

        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();

        if (!empty($documentHrefLinks)){
            foreach ($documentHrefLinks as $link) {
                if (isset($link->href) && !empty($link->href)) {
                    $src_link = $link->href;
                    $src_link = html_entity_decode($src_link, ENT_QUOTES);

                    $src_link = $this->admin->ltrim_and_rtrim($src_link);

                    $src_link = \url_to_absolute($url, $src_link);
                    $host = $this->admin->get_host($src_link);

                    $docsExts = $this->admin->getDocsExtensions();
                    $documentBasename = $this->admin->url_to_basename($src_link);
                    $documentBasename = $this->admin->filter_filename($documentBasename);

                    $urlExt = pathinfo($documentBasename, PATHINFO_EXTENSION);


                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls_settings_only', false, $src_link);

                    if ( in_array($urlExt, $docsExts) && strpos($url, $host) !== false && !$exclude_url) {

                        $newlyCreatedBasename = $this->save_document($src_link, $url);
                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($src_link);
                            $link->href = $path_to_dot . $middle_p . $newlyCreatedBasename;
                            $link->src = $path_to_dot . $middle_p . $newlyCreatedBasename;
                        }
                        else {

                            $link->href = $path_to_dot .'documents/' . $newlyCreatedBasename;
                            $link->src = $path_to_dot .'documents/' . $newlyCreatedBasename;
                        }

                    }
                }
            }
        }
        $this->admin->site_data = $src;


    }

    public function save_document($document_url_prev = "", $found_on = "")
    {
        $document_url = $document_url_prev;
        $documents_path = $this->admin->getDocsPath();
        $document_url = \url_to_absolute($found_on, $document_url);
        $m_basename = $this->admin->middle_path_for_filename($document_url);
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $exportTempDir = $this->admin->getExportTempDir();
        $keepSameName = $this->admin->getKeepSameName();
        $host = $this->admin->get_host($document_url);
        $basename = $this->admin->url_to_basename($document_url);

        if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
            $m_basename = explode('-', $m_basename);
            $m_basename = implode('/', $m_basename);
        }

        if (
            !$this->admin->is_link_exists($document_url)
            && $this->admin->update_export_log($document_url)
        ) {
            $this->admin->add_urls_log($document_url, $found_on, 'document');

            $basename = $this->admin->filter_filename($basename);

            $my_file = $documents_path . $m_basename . $basename;

            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($document_url);
            if(!$saveAllAssetsToSpecificDir){

                if(!file_exists($exportTempDir .'/'. $middle_p)){
                    @mkdir($exportTempDir .'/'. $middle_p, 0777, true);
                }
                $my_file = $exportTempDir .'/'. $middle_p .'/'. $basename;
            }
            else{
                if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                    if(!file_exists($documents_path .'/'. $m_basename)){
                        @mkdir($documents_path . $m_basename, 0777, true);
                    }

                    $my_file = $documents_path . $m_basename . $basename;
                }
                else{
                    if(!file_exists($documents_path)){
                        @mkdir($documents_path);
                    }
                }
            }

            if (!file_exists($my_file)) {
                $this->admin->saveFile($document_url, $my_file);

                $this->admin->update_urls_log($document_url_prev, 1);
            }

            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;
        }
        else{

            if (!(strpos($basename, ".") !== false) && $this->admin->get_newly_created_basename_by_url($document_url) != false){
                return $m_basename . $this->admin->get_newly_created_basename_by_url($document_url);
            }

            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;
        }


        return false;
    }


    public function saveFile($url, $savePath)
    {
        $abs_url_to_path = $this->admin->abs_url_to_path($url);
        if (strpos($url, home_url()) !== false && file_exists($abs_url_to_path)){
            @copy($abs_url_to_path, $savePath);
            $this->admin->setTotalDownloaded();
        }
        else{
            $handle = @fopen($savePath, 'w') or die('Cannot open file:  ' . $savePath);
            $data = $this->admin->get_url_data($url);
            @fwrite($handle, $data);
            @fclose($handle);
            $this->admin->setTotalDownloaded();
        }

    }
}
