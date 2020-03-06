<?php
namespace Sdk\User\Translator;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Translator\RestfulTranslatorTrait;

use Sdk\User\Model\User;

abstract class UserRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function arrayToObject(array $expression, $user = null)
    {
        return $this->translateToObject($expression, $user);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $user = null)
    {
        $data =  $expression['data'];

        $id = $data['id'];

        $user->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['cellphone'])) {
            $user->setCellphone($attributes['cellphone']);
        }
        if (isset($attributes['realName'])) {
            $user->setRealName($attributes['realName']);
        }
        if (isset($attributes['userName'])) {
            $user->setUserName($attributes['userName']);
        }
        if (isset($attributes['password'])) {
            $user->setPassword($attributes['password']);
        }
        if (isset($attributes['oldPassword'])) {
            $user->setOldPassword($attributes['oldPassword']);
        }
        if (isset($attributes['avatar'])) {
            $user->setAvatar($attributes['avatar']);
        }
        if (isset($attributes['cardID'])) {
            $user->setCardId($attributes['cardID']);
        }
        if (isset($attributes['gender'])) {
            $user->setGender($attributes['gender']);
        }
        if (isset($attributes['createTime'])) {
            $user->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $user->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $user->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $user->setStatusTime($attributes['statusTime']);
        }

        return $user;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($user, array $keys = array())
    {
        $expression = array();

        if (!$user instanceof User) {
            return $expression;
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'cellphone',
                'realName',
                'userName',
                'password',
                'oldPassword',
                'avatar',
                'gender',
                'cardId',
            );
        }

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $user->getId();
        }

        $attributes = array();

        if (in_array('cellphone', $keys)) {
            $attributes['cellphone'] = $user->getCellphone();
        }
        if (in_array('realName', $keys)) {
            $attributes['realName'] = $user->getRealName();
        }
        if (in_array('userName', $keys)) {
            $attributes['userName'] = $user->getUserName();
        }
        if (in_array('password', $keys)) {
            $attributes['password'] = $user->getPassword();
        }
        if (in_array('oldPassword', $keys)) {
            $attributes['oldPassword'] = $user->getOldPassword();
        }
        if (in_array('avatar', $keys)) {
            $attributes['avatar'] = $user->getAvatar();
        }
        if (in_array('cardId', $keys)) {
            $attributes['cardID'] = $user->getCardId();
        }
        if (in_array('gender', $keys)) {
            $attributes['gender'] = $user->getGender();
        }

        $expression['data']['attributes'] = $attributes;

        return $expression;
    }
}
