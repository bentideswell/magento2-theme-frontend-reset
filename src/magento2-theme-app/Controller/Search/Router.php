<?php

declare(strict_types=1);

namespace FishPig\ThemeApp\Controller\Search;

use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    /**
     * 
     */
    public function __construct(
        private \FishPig\ThemeApp\Controller\Search\ResultFactory $resultFactory
    ) {
    }

    /**
     *
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $matchResult = preg_match(
            '/^\/search\/result\/(.*)\.json$/',
            $request->getPathInfo(),
            $searchMatch
        );

        if (!$matchResult) {
            return false;
        }

        return $this->resultFactory->create([
            'searchTerm' => $searchMatch[1]
        ]);
    }
}
