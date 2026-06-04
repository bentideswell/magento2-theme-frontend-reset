<?php
/**
 *
 */
namespace FishPig\ThemeApp\Plugin;

use Magento\Framework\Event\Observer;

class DisableCustomerVisitorObserver
{
    /**
     *
     */
    public function aroundExecute(
        $subject,
        \Closure $callback,
        Observer $observer
    ) {
        return;
    }
}
