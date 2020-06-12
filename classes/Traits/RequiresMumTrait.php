<?php

namespace Traits;

use FamilyMembers\Mum;

trait RequiresMumTrait
{
    public function getRequiredMember(): array
    {
        return [
            Mum::class
        ];
    }
}