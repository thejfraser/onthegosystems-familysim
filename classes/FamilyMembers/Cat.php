<?php

namespace FamilyMembers;

use Interfaces\FamilyMemberInterface;
use Interfaces\RequiresOtherMemberInterface;
use Traits\EntityNameTrait;
use Traits\RequiresMumOrDadTrait;

class Cat implements FamilyMemberInterface, RequiresOtherMemberInterface
{
    use RequiresMumOrDadTrait;
    use EntityNameTrait;

    public function getMonthlyFoodCost(int $entityCount): float
    {
        return 10;
    }


}