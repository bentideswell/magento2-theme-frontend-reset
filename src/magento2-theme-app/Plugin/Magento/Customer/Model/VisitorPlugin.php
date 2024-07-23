<?php
/**
 *
 */
namespace FishPig\ThemeApp\Plugin\Magento\Customer\Model;

use Magento\Customer\Model\Visitor;

class VisitorPlugin
{
    /**
     *
     */
    public function aroundIsModuleIgnored(
        Visitor $subject,
        \Closure $proceed,
        $observer
    ): bool {
        return true;
    }

    /**
     *
     */
    public function aroundInitByRequest(
        Visitor $subject,
        \Closure $proceed,
        $observer
    ): Visitor {
        $subject->setSkipRequestLogging(true);
        return $proceed($observer);
    }

    /**
     *
     */
    public function aroundSaveByRequest(
        Visitor $subject,
        \Closure $proceed,
        $observer
    ): Visitor {
        $subject->setSkipRequestLogging(true);
        return $proceed($observer);
    }
}
