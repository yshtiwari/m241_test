<?php namespace Mca\Suppliers\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\TestFramework\ErrorLog\Logger;

class Save extends \Magento\Backend\App\Action
{
    protected $_jsHelper;
	
	protected $_contactCollectionFactory;
	
	public function __construct(
        Context $context,
        \Magento\Backend\Helper\Js $jsHelper,
        \Mca\Suppliers\Model\ResourceModel\Suppliers\CollectionFactory $contactCollectionFactory
    ) {
        $this->_jsHelper = $jsHelper;
        $this->_contactCollectionFactory = $contactCollectionFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
	    $data = $this->getRequest()->getPostValue();
		$resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
		    $suppliers_email = $data['suppliers_email'];
            $id = $this->getRequest()->getParam('id');
			$model = $this->_objectManager->create('Mca\Suppliers\Model\Suppliers');
			$custom_email_check = $this->_objectManager->create('Mca\Suppliers\Model\Suppliers')->load($suppliers_email,'suppliers_email');
			if($custom_email_check->getId() == ''){
                if ($id) {
			        $custom_email_check = $this->_objectManager->create('Mca\Suppliers\Model\Suppliers')->load($suppliers_email,'suppliers_email');
			    	$model->load($id);
			    	if ($id != $model->getId()) {
			    		throw new \Magento\Framework\Exception\LocalizedException(__('The wrong suppliers is specified.'));
			    	}
                }
			    $model->setData($data);
			    try {
                    $model->save();
                    $this->messageManager->addSuccess(__('You saved this suppliers.'));
                    $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                    if ($this->getRequest()->getParam('back')) {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                    }
                    return $resultRedirect->setPath('*/*/');
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $this->messageManager->addError($e->getMessage());
                } catch (\RuntimeException $e) {
                    $this->messageManager->addError($e->getMessage());
                } catch (\Exception $e) {
                    $this->messageManager->addException($e, __('Something went wrong while saving the suppliers.'));
                }
                
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
			}else{
			    $this->messageManager->addError('Suppliers email already used');
				$this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
			}
        }
        return $resultRedirect->setPath('*/*/');
    }
}