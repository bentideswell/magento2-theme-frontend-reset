<?php

declare(strict_types=1);

namespace FishPig\ThemeApp\Controller;

use Magento\Framework\App\RouterInterface;

class CompositeRouter implements RouterInterface
{
    /**
     *
     */
    private array $routers = [];

    /**
     * 
     */
    public function __construct(
        array $routers = []
    ) {
        foreach ($routers as $routerId => $router) {
            if (!($router instanceof RouterInterface)) {
                throw new \TypeError(sprintf(
                    'Router "%s" does implement "%s"',
                    $routerId,
                    RouterInterface::class
                ));
            }

            $this->routers[$routerId] = $router;
        }
    }

    /**
     *
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        foreach ($this->routers as $router) {
            if ($action = $router->match($request)) {
                return $action;
            }
        }

        return null;
    }
}
