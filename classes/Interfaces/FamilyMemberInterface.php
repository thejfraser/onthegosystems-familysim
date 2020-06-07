<?php

namespace Interfaces;

Interface FamilyMemberInterface
{
    public Static function getEntityName(): string;

    public function getMonthlyFoodCost(int $entityCount): float;
}