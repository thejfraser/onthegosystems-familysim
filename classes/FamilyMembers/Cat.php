<?php

namespace FamilyMembers;

use Interfaces\FamilyMemberInterface;
use Interfaces\RequiresSomeOtherMemberInterface;
use Traits\EntityNameTrait;
use Traits\RequiresMumOrDadTrait;

class Cat implements FamilyMemberInterface, RequiresSomeOtherMemberInterface
{
    use RequiresMumOrDadTrait;
    use EntityNameTrait;

    public function getMonthlyFoodCost(int $entityCount): float
    {
        return 10;
    }


}