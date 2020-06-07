<?php

namespace Traits;

use FamilyMembers\Dad;
use FamilyMembers\Mum;

trait RequiresMumOrDadTrait
{
    public function getPossibleRequiredMember(): array
    {
        return [
            Mum::class,
            Dad::class
        ];
    }
}