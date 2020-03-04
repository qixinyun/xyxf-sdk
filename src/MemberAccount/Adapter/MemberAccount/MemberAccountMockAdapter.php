<?php
namespace Sdk\MemberAccount\Adapter\MemberAccount;

use Sdk\MemberAccount\Model\MemberAccount;
use Sdk\MemberAccount\Utils\MockFactory;

class MemberAccountMockAdapter implements IMemberAccountAdapter
{
    public function fetchOne($id)
    {
        return MockFactory::generateMemberAccountObject($id);
    }
}
