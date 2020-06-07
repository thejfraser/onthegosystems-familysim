<?php

use Exceptions\LimitedQuantityException;
use Exceptions\MissingRequiredMemberException;
use FamilyMembers\Cat;
use FamilyMembers\Child;
use FamilyMembers\Dad;
use FamilyMembers\Dog;
use FamilyMembers\Goldfish;
use FamilyMembers\Mum;
use PHPUnit\Framework\TestCase;

class FamilyTest extends TestCase
{
    public function testOneDad()
    {
        $family = new Family();
        $family->addMember(new Dad());
        $this->expectException(LimitedQuantityException::class);
        $family->addMember(new Dad);
    }

    public function testOneMum()
    {
        $family = new Family();
        $family->addMember(new Mum());
        $this->expectException(LimitedQuantityException::class);
        $family->addMember(new Mum);
    }

    public function testChildRequiresParent()
    {
        $family = new Family();
        $this->expectException(MissingRequiredMemberException::class);
        $family->addMember(new Child());
    }

    public function testCatRequiresParent()
    {
        $family = new Family();
        $this->expectException(MissingRequiredMemberException::class);
        $family->addMember(new Cat());
    }

    public function testDogRequiresParent()
    {
        $family = new Family();
        $this->expectException(MissingRequiredMemberException::class);
        $family->addMember(new Dog());
    }

    public function testGoldfishRequiresParent()
    {
        $family = new Family();
        $this->expectException(MissingRequiredMemberException::class);
        $family->addMember(new Goldfish());
    }

    public function testAddParentAddChild()
    {
        $family = new Family();

        $this->assertTrue(($family->addMember(new Mum()) && $family->addMember(new Child())));
    }

    public function testMonthlyFoodCostOneDad()
    {
        $dad = new Dad();
        $family = new Family();
        $family->addMember($dad);
        $this->assertEquals($dad->getMonthlyFoodCost(1), $family->getMonthlyFoodCost());
    }

    public function testMonthlyFoodCostOneDadOneCat()
    {
        $dad = new Dad();
        $cat = new Cat();
        $family = new Family();
        $family->addMember($dad);
        $family->addMember($cat);
        $this->assertEquals(($dad->getMonthlyFoodCost(1) + $cat->getMonthlyFoodCost(1)), $family->getMonthlyFoodCost());
    }

    public function testReducedCostForMoreChild()
    {
        $child = new Child();
        $this->assertNotEquals($child->getMonthlyFoodCost(2), $child->getMonthlyFoodCost(3));
    }

    public function testMonthlyFoodCostPer3Child()
    {
        $child = new Child();
        $this->assertEquals(100, $child->getMonthlyFoodCost(3));
    }

    public function testGetAllCount()
    {
        $family = new Family;

        $family->addMember(new Mum());
        $family->addMember(new Dad());
        $family->addMember(new Child());
        $family->addMember(new Child());
        $family->addMember(new Child());

        $expected = [
            Mum::class => 1,
            Dad::class => 1,
            Child::class => 3
        ];

        $this->assertEquals($expected, $family->getAllCount());
    }

    public function testReset()
    {
        $family = new Family;

        $family->addMember(new Mum());
        $family->addMember(new Dad());
        $family->addMember(new Child());
        $family->addMember(new Child());
        $family->addMember(new Child());
        $family->breakup();
        $this->assertEquals([], $family->getAllCount());
    }
}