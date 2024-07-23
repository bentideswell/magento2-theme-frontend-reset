<?php
/**
 *
 */
namespace FishPig\ThemeApp\Plugin;

use Magento\Framework\App\RouterInterface;
use Magento\UrlRewrite\Controller\Router as UrlRewriteRouter;

class DisableRouterPlugin
{
    /**
     * @ToDo move to DisableRouterPlugin\SystemModuleFrontNamePool
     * to allow for injection and modification
     */
    private $systemModuleFrontNames = [
        'api',
        'catalog',
        'catalogsearch',
        'checkout',
        'cms',
        'contact',
        'customer',
        'downloadable',
        'sales'
    ];

    /**
     *
     */
    public function aroundMatch(
        RouterInterface $subject,
        \Closure $callback,
        $request
    ) {
        $pathInfo = trim($request->getPathInfo(), '/');
        $frontNamesString = implode('|', $this->systemModuleFrontNames);

        if (!$pathInfo && $subject instanceof UrlRewriteRouter) {
            // Path info is empty so UrlRewrite router cannot run
            return null;
        } elseif (preg_match('/^(' . $frontNamesString . ')\//', $pathInfo)) {
            // These are system URLs and do not need to be checked as a CMS page
            // or a URL rewrite. This saves DB queries.
            return null;
        } elseif (preg_match('/^(' . $frontNamesString . ')$/', $pathInfo)) {
            return null;
        }

        return $callback($request);
    }
}
