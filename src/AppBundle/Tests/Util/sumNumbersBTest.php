<?php
/**
 * Created by PhpStorm.
 * User: pecalleja
 * Date: 08/12/2017
 * Time: 12:51 AM
 */

namespace AppBundle\Tests\Util;

use AppBundle\Util\sumNumbers;

class sumNumbersBTest extends \PHPUnit_Framework_TestCase
{
    public function testSumB()
    {
        $sum = new sumNumbers();

        $this->assertEquals(4725, $sum->sumNumbersB());
    }
}