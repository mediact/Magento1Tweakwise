<?php
/**
 * @copyright (c) Emico 2014
 */

/**
 * Class Emico_Tweakwise_Block_Catalog_Layer_Facet_Category
 */
class Emico_Tweakwise_Block_Catalog_Layer_Facet_Category extends Emico_Tweakwise_Block_Catalog_Layer_Facet_Attribute
{
    /**
     * @var
     */
    protected $_activeCategories;

    /**
     * {@inheritDoc}
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('emico_tweakwise/catalog/layer/facet/attribute.phtml');
    }

    public function getAttributes()
    {
        if ($this->_activeCategories === null) {
            $attributes = parent::getAttributes();
            $this->_activeCategories = [];

            foreach ($attributes as $attribute) {
                $this->_activeCategories[] = $attribute;
            }
        }

        return $this->_activeCategories;
    }

    /**
     * @return array
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function getFilteredQuery()
    {
        $query = Mage::app()->getRequest()->getQuery();
        if (!$query || empty($query)) {
            return [];
        }
        try {
            $store = Mage::app()->getStore();
        } catch (Mage_Core_Model_Store_Exception $e) {
            $store = null;
        }
        $ignoredQueryParameters = Mage::helper('emico_tweakwise')
            ->getIgnoredQueryParameters($store);
        return array_diff_key($query, array_flip($ignoredQueryParameters));
    }
}
