<?php
namespace Sdk\MemberAccount\Translator;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Translator\RestfulTranslatorTrait;
use Sdk\Member\Translator\MemberRestfulTranslator;

use Sdk\MemberAccount\Model\MemberAccount;
use Sdk\MemberAccount\Model\NullMemberAccount;

class MemberAccountRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function arrayToObject(array $expression, $memberAccount = null)
    {
        return $this->translateToObject($expression, $memberAccount);
    }

    public function getMemberRestfulTranslator()
    {
        return new MemberRestfulTranslator();
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $memberAccount = null)
    {
        if (empty($expression)) {
            return NullMemberAccount::getInstance();
        }

        if ($memberAccount == null) {
            $memberAccount = new MemberAccount();
        }

        $data = $expression['data'];

        $id = $data['id'];
        $memberAccount->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['accountBalance'])) {
            $memberAccount->setAccountBalance($attributes['accountBalance']);
        }
        if (isset($attributes['frozenAccountBalance'])) {
            $memberAccount->setFrozenAccountBalance($attributes['frozenAccountBalance']);
        }
        if (isset($attributes['createTime'])) {
            $memberAccount->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $memberAccount->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $memberAccount->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $memberAccount->setStatusTime($attributes['statusTime']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['member']['data'])) {
            $member = $this->changeArrayFormat($relationships['member']['data']);
            $memberAccount->setMember(
                $this->getMemberRestfulTranslator()->arrayToObject($member)
            );
        }

        return $memberAccount;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($memberAccount, array $keys = array())
    {
        if (!$memberAccount instanceof MemberAccount) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'accountBalance',
                'frozenAccountBalance',
                'member',
            );
        }

        $expression = array(
            'data' => array(
                'type' => 'memberAccounts'
            )
        );

        if (in_array('id', $keys)) {
            $expression['data']['id'] = $memberAccount->getId();
        }

        $attributes = array();

        if (in_array('accountBalance', $keys)) {
            $attributes['accountBalance'] = $memberAccount->getAccountBalance();
        }
        if (in_array('frozenAccountBalance', $keys)) {
            $attributes['frozenAccountBalance'] = $memberAccount->getFrozenAccountBalance();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('member', $keys)) {
            $expression['data']['relationships']['member']['data'] = array(
                array(
                    'type'=>'members',
                    'id'=>$memberAccount->getMember()->getId()
                )
            );
        }

        return $expression;
    }
}
