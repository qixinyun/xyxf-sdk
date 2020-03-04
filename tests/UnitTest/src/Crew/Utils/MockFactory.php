<?php
namespace Sdk\Crew\Utils;

use Sdk\Crew\Model\Crew;

use Sdk\Common\Model\IEnableAble;

class MockFactory
{
    /**
     * [generateCrewArray 生成员工信息数组]
     * @return [array] [员工信息]
     */
    public static function generateCrewArray() : array
    {
        $faker = \Faker\Factory::create('zh_CN');

        $crew = array();

        $crew = array(
            'data'=>array(
                'type'=>'crews',
                'id'=>$faker->randomNumber(2)
            )
        );
        $value = array();
        $attributes = array();

        //workNumber
        $workNumber = self::generateWorkNumber($faker, $value);
        $attributes['workNumber'] = $workNumber;

        $user = \Sdk\User\Utils\MockFactory::generateUserArray();

        $crew['data']['attributes'] = array_merge($user['data']['attributes'], $attributes);
        
        return $crew;
    }
    /**
     * [generateCrewObject 生成员工信息对象]
     * @param  int|integer $id
     * @param  int|integer $seed
     * @param  array       $value
     * @return [object]             [员工信息]
     */
    public static function generateCrewObject(int $id = 0, int $seed = 0, array $value = array()) : Crew
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $crew = new Crew($id);

        $crew = \Sdk\User\Utils\MockFactory::generateUserObject($crew);

        //workNumber
        $workNumber = self::generateWorkNumber($faker, $value);
        $crew->setWorkNumber($workNumber);

        return $crew;
    }

    private static function generateWorkNumber($faker, array $value = array())
    {
        return $workNumber = isset($value['workNumber']) ?
        $value['workNumber'] : $faker->word;
    }
}
