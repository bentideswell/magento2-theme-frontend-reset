<?php
/**
 *
 */
namespace FishPig\ThemeApp\Plugin\Magento\Framework\View\Page;

use Magento\Framework\View\Page\Config;

class ConfigPlugin
{
    /**
     *
     */
    private $bodyClassMap = [
        'page-products' => null,
        'page-with-filter' => 'products',
        'page-layout-1column' => null,
        'page-layout-1column_narrow' => 'col1n',
        'page-layout-no_columns' => 'col0',
        'page-layout-2columns-left' => ['col2', '-left'],
        'page-layout-2columns-right' => ['col2', '-right'],
        'checkout-cart-index' => 'cart',
        'checkout-onepage-index' => 'checkout',
        'checkout-index-index' => 'checkout',
        'cms-home' => 'home',
        'cms-index-index' => null,
        'contact-index-index' => 'contact',
        'customer-account-login' => 'login',
        'customer-account-create' => 'register',
        'customer-account-register' => 'register',
        'customer-account-forgotpassword' => 'forgot',
        'customer-account-resetpassword' => 'reset',
        'downloadable-project-index' => 'projects',
        'downloadable-project-view' => 'project',
        'downloadable-product-downloadWait' => 'dwait',
        'wordpress-post-view' => ['blog', 'post'],
        'wordpress-postType-view' => ['blog', 'posts'],
        'docs-product-view' => 'docs',
        'catalog-category-view' => 'category',
        'catalog-product-view' => 'product',
        'cms-page-view' => 'page',
        'checkout-onepage-success' => 'success',
        'catalogsearch-result-index' => 'search'
    ];

    /**
     *
     */
    private $bodyClassPatternMap = [
        '/^category-.*/' => null,
        '/^categorypath-.*/' => null,
        '/^product-.*$/' => null,
        '/^cms-.*$/' => null
    ];

    /**
     *
     */
    public function aroundAddBodyClass(
        Config $subject,
        \Closure $proceed,
        string $className
    ) {
        if (array_key_exists($className, $this->bodyClassMap)) {
            $this->applyNewClassName($this->bodyClassMap[$className], $proceed);
            return $subject;
        } else {
            foreach ($this->bodyClassPatternMap as $pattern => $replace) {
                if (preg_match($pattern, $className)) {
                    $this->applyNewClassName($replace, $proceed);
                    return $subject;
                }
            }

            return $proceed($className);
        }
    }

    /**
     *
     */
    private function applyNewClassName($className, $proceed)
    {
        if (is_array($className)) {
            foreach ($className as $cls) {
                $proceed($cls);
            }
        } elseif ($className !== null) {
            $proceed($className);
        }
    }
}
