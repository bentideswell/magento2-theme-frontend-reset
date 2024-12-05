<?php
/**
 *
 */
namespace FishPig\ThemeApp\ViewModel;

class PageSpeed implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * 
     */
    private $objectManager;

    /**
     *
     */
    public function __construct(
        private \Magento\Framework\Module\Manager $moduleManager
    ) {
        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     *
     */
    public function isModuleEnabled(): bool
    {
        return $this->moduleManager->isEnabled('FishPig_PageSpeed');
    }

    /**
     *
     */
    public function isEnabled(): bool
    {
        if (!$this->isModuleEnabled()) {
            return false;
        }

        return $this->getDataHelper()->isEnabled();
    }

    /**
     *
     */
    public function isEnabledMinifyJs(): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->getJsAssetHelper()->isEnabledMinify();
    }

    /**
     *
     */
    public function isEnabledMinifyCss(): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->getCssAssetHelper()->isEnabledMinify();
    }

    /**
     *
     */
    public function getDataHelper()
    {
        return $this->objectManager->get(\FishPig\PageSpeed\Helper\Data::class);
    }

    /**
     *
     */
    public function getJsAssetHelper()
    {
        return $this->objectManager->get(\FishPig\PageSpeed\Model\AssetHelper\Javascript::class);
    }


    /**
     *
     */
    public function getCssAssetHelper()
    {
        return $this->objectManager->get(\FishPig\PageSpeed\Model\AssetHelper\Css::class);
    }
}
