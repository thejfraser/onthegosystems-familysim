<?php

namespace FamilyMembers;

use Interfaces\FamilyMemberInterface;
use Interfaces\RequiresOtherMemberInterface;
use Traits\EntityNameTrait;
use Traits\RequiresMumOrDadTrait;

class AdaptChild implements FamilyMemberInterface
{
    use RequiresMumOrDadTrait;

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