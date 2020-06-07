<?php

namespace FamilyMembers;

use Interfaces\FamilyMemberInterface;
use Interfaces\LimitedQuantityInterface;
use Traits\EntityNameTrait;
use Traits\LimitedToOne;

class Dad implements FamilyMemberInterface, LimitedQuantityInterface
{
    use LimitedToOne;
    use EntityNameTrait;

    public function getMonthlyFoodCost(int $entityCount): float
    {
        return 200;
    }
}