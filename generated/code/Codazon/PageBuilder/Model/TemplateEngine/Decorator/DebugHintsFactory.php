<?php
namespace Codazon\PageBuilder\Model\TemplateEngine\Decorator;

/**
 * Factory class for @see \Codazon\PageBuilder\Model\TemplateEngine\Decorator\DebugHints
 */
class DebugHintsFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Codazon\\PageBuilder\\Model\\TemplateEngine\\Decorator\\DebugHints')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Codazon\PageBuilder\Model\TemplateEngine\Decorator\DebugHints
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
