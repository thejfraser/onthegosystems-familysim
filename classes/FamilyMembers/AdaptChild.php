<?php

namespace FamilyMembers;

use Interfaces\FamilyMemberInterface;
use Interfaces\RequiresAllOtherMemberInterface;
use Traits\RequiresMumTrait;

class AdaptChild implements FamilyMemberInterface, RequiresAllOtherMemberInterface
{
    use RequiresMumTrait;

    public static function getEntityName(): string
    {
        return Child::getEntityName();
    }

    public function getMonthlyFoodCost(int $entityCount): float
    {
        if ($entityCount > 2) {
            return 100;
        }
        return 150;
    }
}