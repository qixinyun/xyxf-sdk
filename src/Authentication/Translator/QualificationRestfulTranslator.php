<?php
namespace Sdk\Authentication\Translator;

use Marmot\Interfaces\IRestfulTranslator;
use Sdk\Authentication\Model\NullQualification;
use Sdk\Authentication\Model\Qualification;
use Sdk\Common\Translator\RestfulTranslatorTrait;
use Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator;

class QualificationRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function getServiceCategoryRestfulTranslator()
    {
        return new ServiceCategoryRestfulTranslator();
    }

    public function arrayToObject(array $expression, $qualification = null)
    {
        return $this->translateToObject($expression, $qualification);
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $qualification = null)
    {
        if (empty($expression)) {
            return NullQualification::getInstance();
        }

        if ($qualification == null) {
            $qualification = new Qualification();
        }

        $data = $expression['data'];

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['image'])) {
            $qualification->setImage($attributes['image']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['serviceCategory']['data'])) {
            $serviceCategory = $this->changeArrayFormat($relationships['serviceCategory']['data']);
            $qualification->setServiceCategory(
                $this->getServiceCategoryRestfulTranslator()->arrayToObject($serviceCategory)
            );
        }

        return $qualification;
    }
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($qualification, array $keys = array())
    {
        if (!$qualification instanceof Qualification) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'image',
                'serviceCategory',
            );
        }

        $expression = array(
            'type' => 'qualifications',
        );

        $attributes = array();

        if (in_array('image', $keys)) {
            $attributes['image'] = $qualification->getImage();
        }

        $expression['attributes'] = $attributes;

        if (in_array('serviceCategory', $keys)) {
            $expression['relationships']['serviceCategory']['data'] = array(
                array(
                    'type' => 'serviceCategories',
                    'id' => $qualification->getServiceCategory()->getId(),
                ),
            );
        }

        return $expression;
    }
}
