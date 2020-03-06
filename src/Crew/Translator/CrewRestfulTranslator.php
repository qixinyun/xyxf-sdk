<?php
namespace Sdk\Crew\Translator;

use Sdk\Crew\Model\Crew;
use Sdk\Crew\Model\NullCrew;
use Sdk\Common\Translator\RestfulTranslatorTrait;
use Sdk\Crew\Model\Role;

use Sdk\User\Translator\UserRestfulTranslator;
use Sdk\UserGroup\Translator\UserGroupRestfulTranslator;


class CrewRestfulTranslator extends UserRestfulTranslator
{
    use RestfulTranslatorTrait;

    protected function getUserGroupRestfulTranslator() : UserGroupRestfulTranslator
    {
        return new UserGroupRestfulTranslator();
    }

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
            return new NullCrew();
        }

        if ($crew == null) {
            $crew = new Crew();
        }

        $data =  $expression['data'];
   
        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $crew = parent::translateToObject($expression, $crew);

        if (isset($attributes['passwordUpdateTime'])) {
            $crew->setPasswordUpdateTime($attributes['passwordUpdateTime']);
        }

        $data = $expression['data'];

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($relationships['roles']['data'])) {
            if (!empty($relationships['roles']['data'])) {
                foreach ($relationships['roles']['data'] as $each) {
                    $role = new Role($each['id']);
                    $crew->addRole($role);
                }
            }
        }

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['userGroup']['data'])) {
            $userGroup = $this->changeArrayFormat($relationships['userGroup']['data']);

            $crew->setUserGroup($this->getUserGroupRestfulTranslator()->arrayToObject($userGroup));
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
                'roles',
                'userGroup'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'crews',
                'id' => $crew->getId()
            )
        );
        
        $expression['data']['attributes'] = $user['data']['attributes'];

        if (in_array('roles', $keys)) {
            $role = array();

            if (!empty($crew->getRoles())) {
                foreach ($crew->getRoles() as $each) {
                    $role[] = array(
                        'type' => 'roles',
                        'id' => $each->getId()
                    );
                }
            }

            $expression['data']['relationships']['roles']['data'] = $role;
        }

        if (in_array('userGroup', $keys)) {
            $expression['data']['relationships']['userGroup']['data'] = array(
                array(
                    'type' => 'userGroups',
                    'id' => $crew->getUserGroup()->getId()
                )
            );
        }

        return $expression;
    }
}
