<?php

declare(strict_types=1);

namespace FishPig\ThemeApp\Controller\Search;

class Result extends \Magento\Framework\App\Action\Action
{
    /**
     *
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        private \FishPig\ThemeApp\Model\Search\AjaxResultBuilderFactory $ajaxSearchResultBuilderFactory,
        private string $searchTerm
    ) {
        parent::__construct($context);
    }

    /**
     *
     */
    public function execute()
    {
        $jsonResult = $this->resultFactory->create('json');
        
        try {
            $jsonResult->setData(
                $this->ajaxSearchResultBuilderFactory->create(['searchTerm' => $this->searchTerm])()
            );
        } catch (\Throwable $e) {
            $jsonResult->setData([
                'term' => $this->searchTerm,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return $jsonResult;
    }
}
