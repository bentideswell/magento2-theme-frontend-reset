<?php
/**
 *
 */
namespace FishPig\ThemeApp\Plugin\Magento\Csp\Model\Collector\CspWhitelistXml;

use Magento\Csp\Model\Collector\CspWhitelistXml\Data;

class DataPlugin
{
    /**
     *
     */

    /**
     *
     */
    private $keywordPoolRegex = null;

    public function __construct(
        array $keywordPool = []
    ) {
        if ($keywordPool) {
            $this->keywordPoolRegex = sprintf(
                '/%s/',
                implode(
                    '|',
                    array_map(
                        fn($keyword) => preg_quote($keyword, '/'),
                        $keywordPool
                    )
                )
            );
        }
    }
    /**
     *
     */
    public function afterGet(Data $subject, $result)
    {
        if ($this->keywordPoolRegex !== null) {
            foreach ($result as $policyType => $policyData) {
                if (!empty($policyData['hosts'])) {
                    foreach ($policyData['hosts'] as $key => $value) {
                        if (preg_match($this->keywordPoolRegex, $key . '::' . $value)) {
                            unset($result[$policyType]['hosts'][$key]);
                        }
                    }

                    if (empty($policyData['hosts']) && empty($policyData['hashes'])) {
                        unset($result[$policyType]);
                    }
                }
            }
        }

        return $result;
    }
}