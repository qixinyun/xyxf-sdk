<?php
namespace Sdk\Policy\Translator;

use Sdk\Common\Translator\CategoryTranslator;

use Sdk\Policy\Model\NullPolicyCategory;

class PolicyCategoryTranslator extends CategoryTranslator
{
    public function arrayToObject(array $expression, $category = null)
    {
        unset($category);
        unset($expression);
        return new NullPolicyCategory(0, '');
    }
}
