<?php

namespace Traits;

trait LimitedToOne
{
    public function getQuantityLimit(): int
    {
        return 1;
    }
}