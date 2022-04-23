<?php

namespace Amasty\Geoip\Controller\Adminhtml\Geoip;

use Amasty\Geoip\Controller\Adminhtml\GeoipAbstract;

class Commit extends GeoipAbstract
{
    public function execute()
    {
        $result = [];

        try {
            $type       = $this->getRequest()->getParam('type');
            $action     = $this->getRequest()->getParam('action');
            $isDownload = false;
            if ($action == 'download_and_import') {
                $isDownload = true;
            }
            $this->importModel->commitProcess($type, $isDownload);
            $result['status']           = 'done';
            $result['full_import_done'] = $this->geoipHelper->isDone() ? "1" : "0";
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        $this->getResponse()->setBody($this->jsonHelper->jsonEncode($result));
    }
}
