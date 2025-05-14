<?php
/**
 * @package FishPig_WordPress
 * @author  Ben Tideswell (ben@fishpig.com)
 * @url     https://fishpig.co.uk/magento/wordpress-integration/
 */
declare(strict_types=1);

namespace FishPig\ThemeApp\Controller\System\Init;

class Js extends \Magento\Framework\App\Action\Action
{
    /**
     * 
     */
    public const ROUTE = '_system/init/js';

    /**
     *
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        private \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    /**
     *
     */
    public function execute()
    {
        $page = $this->resultPageFactory->create();

        // Page Title   
        if ($pageMainTitle = $page->getLayout()->getBlock('page.main.title')) {
            $pageMainTitle->setPageTitle('--');
        }

        // Robots
        $page->getConfig()->setRobots('NOINDEX,FOLLOW');

        // Cleanup HTML
        $page->getLayout()->unsetElement('header.container');
        $page->getLayout()->unsetElement('footer');

        return $page;
    }
}
