<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
return [
    'di' => [
        'allowed_controllers' => [
            \Codazon\Setup\Controller\Navigation::class,
            \Codazon\Setup\Controller\Install::class,
        ],
        'instance' => [
            'preference' => [
                //'Magento\Setup\Model\Navigation' => 'Codazon\Setup\Model\Navigation',
                //'Magento\Setup\Model\InstallerFactory' => 'Codazon\Setup\Model\InstallerFactory'
            ],
        ],
    ],
];
