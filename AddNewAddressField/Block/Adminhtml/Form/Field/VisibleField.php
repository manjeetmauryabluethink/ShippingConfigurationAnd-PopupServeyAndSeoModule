<?php
declare(strict_types=1);

namespace Bluethinkinc\AddNewAddressField\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;

class VisibleField extends Select
{
    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param int $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * Get source options yes and no
     *
     * @return array[]
     */
    private function getSourceOptions(): array
    {
        return [
            ["label" => "Yes", "value" => "1"],
            ["label" => "No", "value" => "0"],
        ];
    }
}
