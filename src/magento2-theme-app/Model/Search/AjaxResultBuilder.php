<?php

namespace FishPig\ThemeApp\Model\Search;

use Magento\Search\Model\QueryInterface;
use Magento\Search\Model\QueryFactory;

class AjaxResultBuilder
{
    /**
     * 
     */
    public function __construct(
        private QueryFactory $queryFactory,
        private \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        private \Magento\AdvancedSearch\Model\SuggestedQueries $suggestedQueries,
        private \Magento\AdvancedSearch\Model\Recommendations\DataProvider\Proxy $recommendationsDataProvider,
        private \Magento\Framework\App\RequestInterface $request,
        private \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        private string $searchTerm,
        private ?int $productPageSize = 3
    ) {
        $this->searchTerm = urldecode($searchTerm);
    }

    /**
     * 
     */
    public function __invoke(): array
    {        
        $this->request->setParam(QueryFactory::QUERY_VAR_NAME, $this->searchTerm);

        $this->layerResolver->create('search');
        $products = $this->layerResolver->get('search')->getProductCollection();
        $products->setPageSize($this->productPageSize);

        $query = $this->queryFactory->get();
        $recommendations = $this->recommendationsDataProvider->getItems($query);

        $resultLayout = $this->resultLayoutFactory->create();        
        $resultLayout->addHandle('fishpig_search_result');

        return [
            'html' => $resultLayout->getLayout()->getBlock('search.result')->setProducts(
                $products
            )->setSearchTerm(
                $this->searchTerm
            )->setQuery(
                $query
            )->setRecommendations(
                $recommendations
            )->toHtml()
        ];
    }
}