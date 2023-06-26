<?php
declare(strict_types=1);

namespace Bluethinkinc\AddNewAddressField\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

/**
 * Field Config used for display field label
 */
class FieldConfig extends AbstractFieldArray
{
    /**
     * @var VisibleField
     */
    private $visibilityRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn("field_label", [
            "label" => __("Field Label"),
            "class" => "required-entry",
        ]);
        $this->addColumn("field_code", [
            "label" => __("Field Code"),
        ]);
        $this->addColumn("sort_order", [
            "label" => __("Sort Order")
        ]);
        $this->addColumn("visible", [
            "label" => __("Visible on Frontend"),
            "renderer" => $this->getVisibilityRenderer()
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __("Add");
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];
        $visibility = $row->getVisible();
        if ($visibility !== null) {
            $options['option_' . $this->getVisibilityRenderer()->calcOptionHash($visibility)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }

    /**
     * Get visibility renderer
     *
     * @return VisibleField
     * @throws LocalizedException
     */
    private function getVisibilityRenderer(): VisibleField
    {
        if (!$this->visibilityRenderer) {
            $this->visibilityRenderer = $this->getLayout()->createBlock(
                VisibleField::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->visibilityRenderer;
    }
}
