<?php
/**
 *
 * Copyright © 2018 Codazon, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Codazon\Shopbybrandpro\Controller\Adminhtml\Index;

class MassEnable extends \Codazon\Shopbybrandpro\Controller\Adminhtml\MassStatusAbstract
{
    protected $primary = 'option_id';
     
    protected $modelClass = 'Codazon\Shopbybrandpro\Model\Brand';
    
    protected $fieldValue = 1;
    
    protected $successText = 'Your selected items have been enabled.';
}