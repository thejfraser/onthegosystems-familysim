<?php

namespace FamilyMembers;

use Interfaces\FamilyMemberInterface;
use Interfaces\RequiresAllOtherMemberInterface;
use Traits\EntityNameTrait;
use Traits\RequiresMumAndDadTrait;

class Child implements FamilyMemberInterface, RequiresAllOtherMemberInterface
{
    use RequiresMumAndDadTrait;
    use EntityNameTrait;

    public function getMonthlyFoodCost(int $entityCount): float
    {
        if ($entityCount > 2) {
            return 100;
        }
        return 150;
    }
}