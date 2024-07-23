<?php
/**
 *
 */
namespace FishPig\ThemeApp\Plugin\Magento\Framework\View\Page\Config;

use Magento\Framework\View\Page\Config\Renderer;

class RendererPlugin
{
    /**
     *
     */
    public function __construct(
        private \Magento\Framework\View\Page\Config $pageConfig,
        private string $faviconUrl = '/favicon.ico'
    ) {
        $this->pageConfig = $pageConfig;
    }

    /**
     *
     */
    public function aroundPrepareFavicon(Renderer $subject, \Closure $proceed)
    {
        // This method no longer does anything. We will manually add the HTML
        // for the favicon in self::afterRenderHeadContent
    }

    /**
     *
     */
    public function afterRenderHeadContent(Renderer $subject, $result)
    {
        foreach (['icon', 'shortcut icon'] as $rel) {
            $result .= sprintf(
                '<link rel="%s" type="image/x-icon" href="%s"/>',
                $rel,
                $this->faviconUrl
            ) . "\n";
        }

        return $result;
    }
}