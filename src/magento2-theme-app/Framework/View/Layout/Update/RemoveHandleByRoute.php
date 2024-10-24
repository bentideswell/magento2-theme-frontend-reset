<?php
/**
 * 
 */
namespace FishPig\ThemeApp\Framework\View\Layout\Update;

class RemoveHandleByRoute
{
    /**
     * 
     */
    private $handleRouteMap = [];

    /**
     * 
     */
    public function __construct(
        private \Magento\Framework\App\RequestInterface $request,
        array $handleRouteMap = []
    ) {
        foreach ($handleRouteMap as $map) {
            if (!isset($map['handle'], $map['route'])) {
                throw new \InvalidArgumentException(
                    'Invalid handleRouteMap: %s',
                    var_export($map, true)
                );
            }
            
            $this->add($map['handle'], $map['route']);
        }
    }

    /**
     * 
     */
    public function add(string $handle, string $route): void
    {
        if (!isset($this->handleRouteMap[$handle])) {
            $this->handleRouteMap[$handle] = [];
        }

        $this->handleRouteMap[$handle][] = $route;
    }

    /**
     * 
     */
    public function isHandleReverted(string $handle, string $route = null): bool
    {
        if ($route === null) {
            $route = $this->request->getFullActionName();
        }

        if (!empty($this->handleRouteMap[$handle])) {
            return in_array($route, $this->handleRouteMap[$handle]);
        }

        return false;
    }
}