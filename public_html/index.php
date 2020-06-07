<?php

use Exceptions\LimitedQuantityException;
use Exceptions\MissingRequiredMemberException;
use FamilyMembers\Cat;
use FamilyMembers\Child;
use FamilyMembers\Dad;
use FamilyMembers\Dog;
use FamilyMembers\Goldfish;
use FamilyMembers\Mum;

require('../vendor/autoload.php');

$family = new Family();
$family->load();

if (isset($_REQUEST['control'])) {
    try {
        $lastModel = '';
        switch ($_REQUEST['control']) {
            case 'reset':
                $family->breakup();
                $family->save();
                break;
            case 'add_dad':
                $lastModel = new Dad();
                $family->addMember($lastModel);
                $family->save();
                break;
            case 'add_mum':
                $lastModel = new Mum();
                $family->addMember($lastModel);
                $family->save();
                break;
            case 'add_child':
                $lastModel = new Child();
                $family->addMember($lastModel);
                $family->save();
                break;
            case 'add_cat':
                $lastModel = new Cat();
                $family->addMember($lastModel);
                $family->save();
                break;
            case 'add_dog':
                $lastModel = new Dog();
                $family->addMember($lastModel);
                $family->save();
                break;
            case 'add_goldfish':
                $lastModel = new Goldfish();
                $family->addMember($lastModel);
                $family->save();
                break;
        }

    } catch (LimitedQuantityException $e) {
        echo "ERROR: Too many {$e->getMessage()}s. (No support for modern families yet. :))";
    } catch (MissingRequiredMemberException $e) {
        echo "ERROR: No {$lastModel::getEntityName()} without {$e->getMessage()}";
    }
    exit;
}

function summary(Family $family)
{
    $familyMembers = $family->getAllCount();

    if (count($familyMembers) <= 0) {
        echo ' ';
        return;
    }

    $map = [
        Mum::class => 'Mum',
        Dad::class => 'Dad',
        Child::class => 'Children',
        Cat::class => 'Cats',
        Dog::class => 'Dogs',
        Goldfish::class => 'Goldfish',
    ];

    echo '<h2>Family</h2>';
    echo '<ul>';
    foreach ($map as $class => $name) {
        echo isset($familyMembers[$class]) ? sprintf('<li>%s: %d</li>', $name, $familyMembers[$class]) : '';
    }
    echo '<li><b>Total Members</b>: ' . array_sum($familyMembers) . '</li>';
    echo '<li><b>Monthly Food Costs</b>: ' . $family->getMonthlyFoodCost() . ' $ </li>';
    echo '</ul>';
}

if (isset($_REQUEST['refresh'])) {
    summary($family);
    exit;
}

?>

<html>
<head>
    <title>Family Simulator</title>
</head>
<body>
<h1>Family Simulator</h1>
<form>
    <input type="submit" name="add_mum" value="Add Mum"/>
    <input type="submit" name="add_dad" value="Add Dad"/>
    <input type="submit" name="add_child" value="Add Child"/>
    <input type="submit" name="add_cat" value="Add Cat"/>
    <input type="submit" name="add_dog" value="Add Dog"/>
    <input type="submit" name="add_goldfish" value="Add Goldfish"/>
    <input type="submit" name="reset" value="Reset"/>
</form>

<div>
    <?php
    summary($family);
    ?>
</div>


<script src="jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    (function ($) {
        $('input').on('click', function () {
            $('input').removeAttr('data-clicked');
            $(this).attr('data-clicked', 'clicked');
        });
        $('form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                method: "POST",
                data: {control: $('[data-clicked]').attr('name')}
            }).done(function (error) {
                if (error) {
                    alert(error);
                } else {
                    $.ajax({
                        method: "POST",
                        data: {refresh: 1}
                    }).done(function (sum) {
                        if (sum) {
                            $('div').html(sum);
                        }
                    });
                }
            });
        });
    })(jQuery);
</script>
</body>
</html>

