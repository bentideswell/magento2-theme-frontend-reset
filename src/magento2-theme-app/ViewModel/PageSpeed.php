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
    public function __construct(
        private \Magento\Framework\Module\Manager $moduleManager
    ) {

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
}
