<?php
namespace Sdk\Statistical\Translator;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Translator\RestfulTranslatorTrait;
use Sdk\Statistical\Model\Statistical;
use Sdk\Statistical\Model\NullStatistical;

class StatisticalRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function arrayToObject(array $expression, $statistical = null)
    {
        return $this->translateToObject($expression, $statistical);
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $statistical = null)
    {
        if (empty($expression)) {
            return NullStatistical::getInstance();
        }

        if ($statistical == null) {
            $statistical = new Statistical();
        }

        $data = $expression['data'];

        $id = $data['id'];
        $statistical->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['result'])) {
            $statistical->setResult($attributes['result']);
        }
        
        return $statistical;
    }

    public function objectToArray($statistical, array $keys = array())
    {
        unset($statistical);
        unset($keys);
        return false;
    }
}
