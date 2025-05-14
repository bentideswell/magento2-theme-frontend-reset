<?php
/**
 * @package FishPig_WordPress
 * @author  Ben Tideswell (ben@fishpig.com)
 */
declare(strict_types=1);

namespace FishPig\ThemeApp\Controller;
use FishPig\ThemeApp\Controller\System\Init\Js as InitJs;

class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     *
     */
    public function __construct(
        private \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
    }

    /**
     *
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        /** @var \Magento\Framework\App\Request\Http $request */
        if ($request->getPathInfo() === '/' . InitJs::ROUTE) {
            return $this->objectManager->create(InitJs::class);
        }

        return false;
    }
}
