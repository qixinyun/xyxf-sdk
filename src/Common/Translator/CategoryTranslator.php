<?php
namespace Sdk\Common\Translator;

use Sdk\Common\Model\Category;

use Marmot\Interfaces\ITranslator;

abstract class CategoryTranslator implements ITranslator
{
    public function arrayToObjects(array $expression) : array
    {
        unset($expression);
        return array();
    }

    public function objectToArray($category, array $keys = array())
    {
        if (!$category instanceof Category) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'name',
            );
        }

        $expression = array();

        if (in_array('id', $keys)) {
            $expression['id'] = marmot_encode($category->getId());
        }
        if (in_array('name', $keys)) {
            $expression['name'] = $category->getName();
        }

         return $expression;
    }
}
