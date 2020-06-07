<?php

namespace FamilyMembers;

use Interfaces\FamilyMemberInterface;
use Interfaces\RequiresOtherMemberInterface;
use Traits\EntityNameTrait;
use Traits\RequiresMumOrDadTrait;

class Child implements FamilyMemberInterface, RequiresOtherMemberInterface
{
    use RequiresMumOrDadTrait;
    use EntityNameTrait;

    public function getMonthlyFoodCost(int $entityCount): float
    {
        if ($entityCount > 2) {
            return 100;
        }
        return 150;
    }
}