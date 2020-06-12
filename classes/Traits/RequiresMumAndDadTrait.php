<?php

namespace Traits;

use FamilyMembers\Dad;
use FamilyMembers\Mum;

trait RequiresMumAndDadTrait
{
    public function getRequiredMember(): array
    {
        return [
            Mum::class,
            Dad::class
        ];
    }
}