<?php
/**
 * Copyright © Codazon, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Codazon\GoogleAmpManager\Block\Html;

use Magento\Backend\Model\Menu;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree\Node\Collection;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\DataObject;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;

class Categorymenu extends Template implements IdentityInterface
{    
    /**
     * Cache identities
     *
     * @var array
     */
    protected $identities = [];

    /**
     * Top menu data tree
     *
     * @var Node
     */
    protected $_menu;

    /**
     * @var NodeFactory
     */
    private $nodeFactory;

    /**
     * @var TreeFactory
     */
    private $treeFactory;
    
    protected $helper;

    /**
     * @param Template\Context $context
     * @param NodeFactory $nodeFactory
     * @param TreeFactory $treeFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        NodeFactory $nodeFactory,
        TreeFactory $treeFactory,
		\Codazon\GoogleAmpManager\Helper\Category $catalogCategory,
        \Codazon\GoogleAmpManager\Helper\Data $helper,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Catalog\Observer\MenuCategoryData $menuCategoryData,
        array $data = []
    ) {
        parent::__construct($context, $data);
		$this->catalogCategory = $catalogCategory;
        $this->categoryFlatState = $categoryFlatState;
        $this->menuCategoryData = $menuCategoryData;
		$this->helper = $helper;
        $this->nodeFactory = $nodeFactory;
        $this->treeFactory = $treeFactory;
    }

    /**
     * Get block cache life time
     *
     * @return int
     * @since 100.1.0
     */
    protected function getCacheLifetime()
    {
        return parent::getCacheLifetime() ?: 3600;
    }

    protected function _getParentId()
    {
        return $this->getData('parent_id') ? $this->getData('parent_id') : $this->_storeManager->getStore()->getRootCategoryId();
    }

    /**
     * Get top menu html
     *
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string
     */
    public function getHtml($outermostClass = '', $childrenWrapClass = '', $limit = 0)
    {
        $this->_eventManager->dispatch(
            'page_block_html_topmenu_gethtml_before',
            ['menu' => $this->getMenu(), 'block' => $this, 'request' => $this->getRequest()]
        );
        
        $parentId = $this->_getParentId();
        $this->_addCategoriesToMenu($this->catalogCategory->getCategoriesByParentId($parentId), $this->_menu, $this);
        
        $this->getMenu()->setOutermostClass($outermostClass);
        $this->getMenu()->setChildrenWrapClass($childrenWrapClass);

        $transportObject = new DataObject(
            [
                'html' => $this->_getHtml(
                    $this->getMenu(),
                    $childrenWrapClass,
                    $limit
                )
            ]
        );

        $this->_eventManager->dispatch(
            'page_block_html_topmenu_gethtml_after',
            ['menu' => $this->getMenu(), 'transportObject' => $transportObject]
        );

        return $transportObject->getHtml();
    }
    
    
    protected function _addCategoriesToMenu($categories, $parentCategoryNode, $block)
    {
        foreach ($categories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }
            $block->addIdentity(\Magento\Catalog\Model\Category::CACHE_TAG . '_' . $category->getId());

            $tree = $parentCategoryNode->getTree();
            $categoryData = $this->menuCategoryData->getMenuCategoryData($category);
            $categoryNode = new \Magento\Framework\Data\Tree\Node($categoryData, 'id', $tree, $parentCategoryNode);
            $parentCategoryNode->addChild($categoryNode);

            if ($this->categoryFlatState->isFlatEnabled() && $category->getUseFlatResource()) {
                $subcategories = (array)$category->getChildrenNodes();
            } else {
                $subcategories = $category->getChildren();
            }

            $this->_addCategoriesToMenu($subcategories, $categoryNode, $block);
        }
    }
    
    /**
     * Count All Subnavigation Items
     *
     * @param Menu $items
     * @return int
     */
    protected function _countItems($items)
    {
        $total = $items->count();
        foreach ($items as $item) {
            /** @var $item Menu\Item */
            if ($item->hasChildren()) {
                $total += $this->_countItems($item->getChildren());
            }
        }
        return $total;
    }

    /**
     * Building Array with Column Brake Stops
     *
     * @param Menu $items
     * @param int $limit
     * @return array|void
     *
     * @todo: Add Depth Level limit, and better logic for columns
     */
    protected function _columnBrake($items, $limit)
    {
        $total = $this->_countItems($items);
        if ($total <= $limit) {
            return;
        }

        $result[] = ['total' => $total, 'max' => (int)ceil($total / ceil($total / $limit))];

        $count = 0;
        $firstCol = true;

        foreach ($items as $item) {
            $place = $this->_countItems($item->getChildren()) + 1;
            $count += $place;

            if ($place >= $limit) {
                $colbrake = !$firstCol;
                $count = 0;
            } elseif ($count >= $limit) {
                $colbrake = !$firstCol;
                $count = $place;
            } else {
                $colbrake = false;
            }

            $result[] = ['place' => $place, 'colbrake' => $colbrake];

            $firstCol = false;
        }

        return $result;
    }

    /**
     * Add sub menu HTML code for current menu item
     *
     * @param Node $child
     * @param string $childLevel
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string HTML code
     */
    protected function _addSubMenu($child, $childLevel, $childrenWrapClass, $limit)
    {
        $html = '';
        if (!$child->hasChildren()) {
            return $html;
        }

        $colStops = [];
        /* if ($childLevel == 0 && $limit) {
            $colStops = $this->_columnBrake($child->getChildren(), $limit);
        } */
        $html .= '<div class="cdz-sec-content ' . $childrenWrapClass . '">';
        $html .= '<h4 class="cdz-sec-heading view-all"><a href="' . $child->getUrl() . '">' . __('View all %1', '<strong>'.$this->escapeHtml($child->getName()) . '</strong>') . '</a></h4>'; 
        $html .= '<amp-accordion animate disable-session-states>';
        $html .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
        $html .= '</amp-accordion>';
        $html .= '</div>';        
        return $html;
    }

    /**
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param Node $menuTree
     * @param string $childrenWrapClass
     * @param int $limit
     * @param array $colBrakes
     * @return string
     */
    protected function _getHtml(
        Node $menuTree,
        $childrenWrapClass,
        $limit,
        array $colBrakes = []
    ) {
        $html = '';

        $children = $menuTree->getChildren();
        $childLevel = $this->getChildLevel($menuTree->getLevel());
        $this->removeChildrenWithoutActiveParent($children, $childLevel);

        $counter = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        //$itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        /** @var Node $child */
        foreach ($children as $child) {
            $hasChildren = $child->hasChildren();
            $child->setLevel($childLevel);
            $child->setIsFirst($counter === 1);
            $child->setIsLast($counter === $childrenCount);
            $child->setUrl($this->helper->transformToAmpUrl($child->getUrl()));
            //$child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel === 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $this->setCurrentClass($child, $outermostClass);
            }

            /* if ($this->shouldAddNewColumn($colBrakes, $counter)) {
                $html .= '</ul></li><li class="column"><ul>';
            } */

            
            $html .= '<section ' . $this->_getRenderedMenuItemAttributes($child) . '>';
            if ($hasChildren) {
                $html .= '<h4 class="cdz-sec-heading parent">' . $this->escapeHtml($child->getName()) . '</h4>';
            } else {
                $html .= '<h4 class="cdz-sec-heading"><a href="' . $child->getUrl() . '" ' . $outermostClassCode . '><span>' . $this->escapeHtml($child->getName()) . '</span></a></h4>';
                $html .= '<div></div>';
            }
            $html .= $this->_addSubMenu(
                $child,
                $childLevel,
                $childrenWrapClass,
                $limit
            );
            $html .= '</section>';
            $counter++;
        }
        /* if (is_array($colBrakes) && !empty($colBrakes) && $limit) {
            $html = '<li class="column"><ul>' . $html . '</ul></li>';
        } */

        return $html;
    }

    /**
     * Generates string with all attributes that should be present in menu item element
     *
     * @param Node $item
     * @return string
     */
    protected function _getRenderedMenuItemAttributes(Node $item)
    {
        $html = '';
        foreach ($this->_getMenuItemAttributes($item) as $attributeName => $attributeValue) {
            $html .= ' ' . $attributeName . '="' . str_replace('"', '\"', $attributeValue) . '"';
        }
        return $html;
    }

    /**
     * Returns array of menu item's attributes
     *
     * @param Node $item
     * @return array
     */
    protected function _getMenuItemAttributes(Node $item)
    {
        return ['class' => implode(' ', $this->_getMenuItemClasses($item))];
    }

    /**
     * Returns array of menu item's classes
     *
     * @param Node $item
     * @return array
     */
    protected function _getMenuItemClasses(Node $item)
    {
        $classes = [
            'level' . $item->getLevel(),
            //$item->getPositionClass(),
        ];

        /* if ($item->getIsCategory()) {
            $classes[] = 'category-item';
        } */

        if ($item->getIsFirst()) {
            $classes[] = 'first';
        }

        /* if ($item->getIsActive()) {
            $classes[] = 'active';
        } elseif ($item->getHasActive()) {
            $classes[] = 'has-active';
        } */

        if ($item->getIsLast()) {
            $classes[] = 'last';
        }

        if ($item->getClass()) {
            $classes[] = $item->getClass();
        }

        if ($item->hasChildren()) {
            $classes[] = 'parent';
        }

        return $classes;
    }

    /**
     * Add identity
     *
     * @param string|array $identity
     * @return void
     */
    public function addIdentity($identity)
    {
        if (!in_array($identity, $this->identities)) {
            $this->identities[] = $identity;
        }
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return $this->identities;
    }

    /**
     * Get tags array for saving cache
     *
     * @return array
     * @since 100.1.0
     */
    protected function getCacheTags()
    {
        return array_merge(parent::getCacheTags(), $this->getIdentities());
    }

    /**
     * Get menu object.
     *
     * Creates Tree root node object.
     * The creation logic was moved from class constructor into separate method.
     *
     * @return Node
     * @since 100.1.0
     */
    public function getMenu()
    {
        if (!$this->_menu) {
            $this->_menu = $this->nodeFactory->create(
                [
                    'data' => [],
                    'idField' => 'root',
                    'tree' => $this->treeFactory->create()
                ]
            );
        }
        return $this->_menu;
    }

    /**
     * Remove children from collection when the parent is not active
     *
     * @param Collection $children
     * @param int $childLevel
     * @return void
     */
    private function removeChildrenWithoutActiveParent(Collection $children, int $childLevel): void
    {
        /** @var Node $child */
        foreach ($children as $child) {
            if ($childLevel === 0 && $child->getData('is_parent_active') === false) {
                $children->delete($child);
            }
        }
    }

    /**
     * Retrieve child level based on parent level
     *
     * @param int $parentLevel
     *
     * @return int
     */
    private function getChildLevel($parentLevel): int
    {
        return $parentLevel === null ? 0 : $parentLevel + 1;
    }

    /**
     * Check if new column should be added.
     *
     * @param array $colBrakes
     * @param int $counter
     * @return bool
     */
    private function shouldAddNewColumn(array $colBrakes, int $counter): bool
    {
        return count($colBrakes) && $colBrakes[$counter]['colbrake'];
    }

    /**
     * Set current class.
     *
     * @param Node $child
     * @param string $outermostClass
     */
    private function setCurrentClass(Node $child, string $outermostClass): void
    {
        $currentClass = $child->getClass();
        if (empty($currentClass)) {
            $child->setClass($outermostClass);
        } else {
            $child->setClass($currentClass . ' ' . $outermostClass);
        }
    }
}
