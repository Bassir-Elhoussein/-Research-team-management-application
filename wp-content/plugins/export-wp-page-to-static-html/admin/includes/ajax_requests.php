<?php

namespace ExportHtmlAdmin\EWPPTH_AjaxRequests;
/**
 * Class name: EWPPTH_AjaxRequests
 */
class EWPPTH_AjaxRequests
{

    public function __construct()
    {
        $this->initAjaxRequestsFiles();
        $this->initAjaxRequestsClass();
    }

    public function initAjaxRequestsFiles()
    {
        include 'AjaxRequests/requestForWpPageToStaticHtml.php';
        include 'AjaxRequests/seeLogsInDetails.php';
        include 'AjaxRequests/exportLogPercentage.php';
        include 'AjaxRequests/searchPosts.php';
        include 'AjaxRequests/checkExportingProcessOnSettingsPageLoad.php';
        include 'AjaxRequests/deleteExportedZipFile.php';
        include 'AjaxRequests/cancelRcExportProcess.php';
        include 'AjaxRequests/saveAdvancedSettings.php';
    }

    public function initAjaxRequestsClass()
    {
        new seeLogsInDetails\initAjax;
        new exportLogPercentage\initAjax;
        new searchPosts\initAjax;
        new requestForWpPageToStaticHtml\initAjax;
        new checkExportingProcessOnSettingsPageLoad\initAjax;
        new deleteExportedZipFile\initAjax;
        new cancelRcExportProcess\initAjax;
        new saveAdvancedSettings\initAjax;

    }

}

new EWPPTH_AjaxRequests;