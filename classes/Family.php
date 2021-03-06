<?php

use Exceptions\LimitedQuantityException;
use Exceptions\MissingRequiredMemberException;
use Factories\Storage;
use Interfaces\FamilyMemberInterface;
use Interfaces\LimitedQuantityInterface;
use Interfaces\RequiresAllOtherMemberInterface;
use Interfaces\RequiresSomeOtherMemberInterface;

class Family
{
    /**
     * @var array
     */
    protected $loadedFamily = [];
    /**
     * @var \Interfaces\StorageInterface
     */
    protected $storage;

    /**
     * Family constructor.
     */
    public function __construct()
    {
        $this->storage = Storage::get();
    }

    /**
     * @return bool
     */
    public function load(): bool
    {
        $this->loadedFamily = $this->storage->loadFamily();
        return true;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->storage->storeFamily($this->loadedFamily)) {
            echo 'storage failed';
            return false;
        }

        return true;
    }

    /**
     *
     */
    public function breakup()
    {
        $this->loadedFamily = [];
    }

    /**
     * @param FamilyMemberInterface $familyMember
     * @throws LimitedQuantityException
     * @throws MissingRequiredMemberException
     */
    public function addMember(FamilyMemberInterface $familyMember): bool
    {
        if ($familyMember instanceof LimitedQuantityInterface && !$this->validateLimitedQuantity($familyMember)) {
            throw new LimitedQuantityException($familyMember::getEntityName());
        }


        if ($familyMember instanceof RequiresSomeOtherMemberInterface && !$this->validateRequiredMembers($familyMember)) {
            $names = array_map(function ($class) {
                return call_user_func([$class, 'getEntityName']);
            }, $familyMember->getPossibleRequiredMember());

            $nameList = array_pop($names);
            if (count($names) > 0) {
                $nameList = implode(', ', $names) . ' or ' . $nameList;
            }
            throw new MissingRequiredMemberException($nameList);
        }


        if ($familyMember instanceof RequiresAllOtherMemberInterface && !$this->validateRequiredMembers($familyMember)) {
            $names = array_map(function ($class) {
                return call_user_func([$class, 'getEntityName']);
            }, $familyMember->getRequiredMember());

            $nameList = array_pop($names);
            if (count($names) > 0) {
                $nameList = implode(', ', $names) . ' and ' . $nameList;
            }
            throw new MissingRequiredMemberException($nameList);
        }

        $class = $familyMember::getEntityName();
        if (!isset($this->loadedFamily[$class])) {
            $this->loadedFamily[$class] = [];
        }

        $this->loadedFamily[$class][] = $familyMember;

        return true;
    }

    /**
     * @param FamilyMemberInterface $familyMember
     * @return bool
     */
    public function validateLimitedQuantity(FamilyMemberInterface $familyMember): bool
    {
        if (!($familyMember instanceof LimitedQuantityInterface)) {
            return true;
        }
        return $this->getCountOfMember($familyMember::getEntityName()) < $familyMember->getQuantityLimit();

    }

    /**
     * @param string $memberClass
     * @return int
     */
    public function getCountOfMember(string $memberClass): int
    {
        if (!isset($this->loadedFamily[$memberClass])) {
            return 0;
        }

        return count($this->loadedFamily[$memberClass]);
    }

    /**
     * @param FamilyMemberInterface $familyMember
     * @return bool|float|int
     */
    public function validateRequiredMembers(FamilyMemberInterface $familyMember)
    {
        if ($familyMember instanceof RequiresSomeOtherMemberInterface) {

            $familyMemberCount = array_map(function ($class) {
                return $this->getCountOfMember(call_user_func([$class, 'getEntityName']));
            }, $familyMember->getPossibleRequiredMember());

            return array_sum($familyMemberCount) > 0;
        }

        if ($familyMember instanceof RequiresAllOtherMemberInterface) {

            $familyMemberCount = array_map(function ($class) {
                return $this->getCountOfMember(call_user_func([$class, 'getEntityName']));
            }, $familyMember->getRequiredMember());

            return array_search(0, $familyMemberCount) === FALSE;
        }

        return true;


    }

    /**
     * @return array
     */
    public function getAllCount(): array
    {
        $members = [];

        if (count($this->loadedFamily)) {
            foreach ($this->loadedFamily as $group => $entites) {
                $members[$group] = count($entites);
            }
        }
        return $members;
    }

    /**
     * @return float
     */
    public function getMonthlyFoodCost(): float
    {
        $totalFoodCost = 0;
        foreach ($this->loadedFamily as $group => $entities) {
            $entityCount = count($entities);
            array_walk($entities, function (FamilyMemberInterface $entity) use (&$totalFoodCost, $entityCount) {
                $totalFoodCost = bcadd($totalFoodCost, $entity->getMonthlyFoodCost($entityCount));
            });
        }

        return $totalFoodCost;
    }

}