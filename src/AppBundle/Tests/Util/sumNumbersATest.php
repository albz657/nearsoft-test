<?php
/**
 * Created by PhpStorm.
 * User: pecalleja
 * Date: 08/12/2017
 * Time: 12:44 AM
 */

namespace AppBundle\Tests\Util;

use AppBundle\Util\sumNumbers;

class sumNumbersATest extends \PHPUnit_Framework_TestCase
{
    public function testSumA()
    {
        $sum = new sumNumbers();

        $this->assertEquals(4725,$sum->sumNumbersA());
    }
}
