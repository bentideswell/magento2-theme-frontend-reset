<?php

namespace FishPig\ThemeApp\Block\Search;

use Magento\Search\Model\QueryFactory;

class Result extends \Magento\Framework\View\Element\Template
{
    /**
     * 
     */
    private $products = [];

    /**
     * 
     */
    public function getRecommendationUrl(\Magento\Search\Model\QueryResult $recommendation)
    {
        return $this->getUrl(
            'catalogsearch/result',
            ['_query' => [QueryFactory::QUERY_VAR_NAME => $recommendation->getQueryText()]]
        );
    }

    /**
     * 
     */
    public function getViewAllResultsUrl(): string
    {
        return $this->getUrl(
            'catalogsearch/result', 
            ['_query' => [QueryFactory::QUERY_VAR_NAME => $this->getQuery()->getQueryText()]]
        );
    }

    /**
     *  
     */
    public function getQuery(): \Magento\Search\Model\QueryInterface
    {
        return $this->getData('query');
    }

    /**
     * 
     */
    public function getProducts(): iterable
    {
        return $this->products;
    }

    /**
     * 
     */
    public function setProduct(iterable $products): self
    {
        $this->products = $products;
        return $this;
    }
}