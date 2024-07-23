<?php
/**
 *
 */
namespace FishPig\ThemeApp\Plugin\Magento\Framework\View\Model\Layout\Update;

use Magento\Framework\View\Model\Layout\Update\Validator;

class ValidatorPlugin
{
    /**
     *
     */
    public function beforeIsValid(
        Validator $subject,
        $value,
        $schema = Validator::LAYOUT_SCHEMA_PAGE_HANDLE,
        $isSecurityCheck = true
    ): array {
        if ($value) {
            $value = preg_replace('/ (htmlTag|htmlClass|htmlId)=""/', '', $value);
        }

        return [$value, $schema, $isSecurityCheck];
    }
}