<?php
namespace Sdk\Crew\Translator;

use Sdk\Crew\Model\Crew;
use Sdk\Crew\Model\NullCrew;
use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\User\Translator\UserRestfulTranslator;

class CrewRestfulTranslator extends UserRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function arrayToObject(array $expression, $crew = null)
    {
        return $this->translateToObject($expression, $crew);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function translateToObject(array $expression, $crew = null)
    {
        if (empty($expression)) {
            return NullCrew::getInstance();
        }

        if ($crew == null) {
            $crew = new Crew();
        }

        $crew = parent::translateToObject($expression, $crew);

        $data =  $expression['data'];

        $attributes = isset($data['attributes']) ? $data['attributes'] : array();

        if (isset($attributes['workNumber'])) {
            $crew->setWorkNumber($attributes['workNumber']);
        }
        
        return $crew;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($crew, array $keys = array())
    {

        $user = parent::objectToArray($crew, $keys);
        
        if (!$crew instanceof Crew) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'workNumber'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'crews',
                'id'=>$crew->getId()
            )
        );

        $attributes = array();

        if (in_array('workNumber', $keys)) {
            $attributes['workNumber'] = $crew->getWorkNumber();
        }

        $expression['data']['attributes'] = array_merge($user['data']['attributes'], $attributes);

        return $expression;
    }
}
