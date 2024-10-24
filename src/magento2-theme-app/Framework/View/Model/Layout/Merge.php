<?php
/**
 * 
 */
namespace FishPig\ThemeApp\Framework\View\Model\Layout;

use FishPig\ThemeApp\Framework\View\Layout\Update\RemoveHandleByRoute;
use Magento\Framework\App\ObjectManager;

class Merge extends \Magento\Framework\View\Model\Layout\Merge
{
    /**
     * 
     */
    private $removeHandleByRoute = null;

    /**
     * 
     */
    protected function _merge($handle)
    {
        if ($this->getRemoveHandleByRoute()->isHandleReverted($handle)) {
            return $this;
        }
        
        return parent::_merge($handle);
    }

    /**
     * 
     */
    private function getRemoveHandleByRoute(): RemoveHandleByRoute
    {
        if ($this->removeHandleByRoute === null) {
            $this->removeHandleByRoute = ObjectManager::getInstance()->get(
                RemoveHandleByRoute::class
            );
        }

        return $this->removeHandleByRoute;
    }
}