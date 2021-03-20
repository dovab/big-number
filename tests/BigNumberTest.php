<?php

namespace Dovab\Utility\Number;

use PHPUnit\Framework\TestCase;

/**
 * Class BigNumberTest
 *
 * @package Tests
 */
class BigNumberTest extends TestCase
{
    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testAddition($number1, $number2, $scale) {
        $num = new BigNumber($number1);
        $num->setScale($scale)->add($number2);

        $this->assertEquals(bcadd($number1, $number2, $scale), (string)$num);
    }

    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testSubtraction($number1, $number2, $scale) {
        $num = new BigNumber($number1);
        $num->setScale($scale)->subtract($number2);

        $this->assertEquals(bcsub($number1, $number2, $scale), (string)$num);
    }

    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testMultiplication($number1, $number2, $scale) {
        $num = new BigNumber($number1);
        $num->setScale($scale)->multiply($number2);

        $this->assertEquals(bcmul($number1, $number2, $scale), (string)$num);
    }

    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testDivision($number1, $number2, $scale) {
        $num = new BigNumber($number1);
        $num->setScale($scale)->divide($number2);

        $this->assertEquals(bcdiv($number1, $number2, $scale), (string)$num);
    }

    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testModulus($number1, $number2, $scale) {
        $num = new BigNumber($number1);
        $num->setScale($scale)->modulus($number2);

        $this->assertEquals(bcmod($number1, $number2, $scale), (string)$num);
    }

    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testEquals($number1, $number2, $scale) {
        $num = new BigNumber($number1);

        $this->assertEquals(bccomp($number1, $number2, $scale) === 0, $num->setScale($scale)->equals($number2));
    }

    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testGreaterThan($number1, $number2, $scale) {
        $num = new BigNumber($number1);

        $this->assertEquals(bccomp($number1, $number2, $scale) === 1, $num->setScale($scale)->greaterThan($number2));
    }

    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testLowerThan($number1, $number2, $scale) {
        $num = new BigNumber($number1);

        $this->assertEquals(bccomp($number1, $number2, $scale) === -1, $num->setScale($scale)->lowerThan($number2));
    }

    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testGreaterThanOrEquals($number1, $number2, $scale) {
        $num = new BigNumber($number1);

        $this->assertEquals(bccomp($number1, $number2, $scale) >= 0, $num->setScale($scale)->greaterThanOrEquals($number2));
    }

    /**
     * @dataProvider basicData
     * @param $number1
     * @param $number2
     * @param $scale
     */
    public function testLowerThanOrEquals($number1, $number2, $scale) {
        $num = new BigNumber($number1);

        $this->assertEquals(bccomp($number1, $number2, $scale) <= 0, $num->setScale($scale)->lowerThanOrEquals($number2));
    }

    /**
     * Tests the division by zero exception
     */
    public function testDivisionByZero() {
        $this->expectException(BigNumberException::class);

        $num = new BigNumber($this->randomLong());
        $num->setScale(10)->divide(0);
    }

    /**
     * Tests the modulus by zero exception
     */
    public function testModulusByZero() {
        $this->expectException(BigNumberException::class);

        $num = new BigNumber($this->randomLong());
        $num->setScale(10)->modulus(new BigNumber('0.00000'));
    }

    /**
     * @return array
     */
    public function basicData() {
        return [
            'int-values' => [
                $this->randomInt(),
                $this->randomInt(),
                3,
            ],
            'float-values' => [
                $this->randomFloat(),
                $this->randomFloat(),
                8,
            ],
            'long-values' => [
                $this->randomLong(),
                $this->randomLong(),
                4
            ],
            'double-values' => [
                $this->randomDouble(),
                $this->randomDouble(),
                6
            ],
            'bignumber-values' => [
                new BigNumber($this->randomDouble()),
                new BigNumber($this->randomDouble()),
                10,
            ],
        ];
    }

    /**
     * @return int
     */
    private function randomInt() {
        return rand(1, PHP_INT_MAX);
    }

    /**
     * @return float|int
     */
    private function randomFloat() {
        return mt_rand() / mt_getrandmax();
    }

    /**
     * @return int|string
     *
     * @see https://stackoverflow.com/questions/21789115/generate-big-random-number-php/21789246
     */
    private function randomLong() {
        $length = rand(20, 40);

        // prevent the first number from being 0
        $output = rand(1, 9);

        for($i=0; $i<($length-1); $i++) {
            $output .= rand(0,9);
        }

        return $output;
    }

    /**
     * @return string
     */
    private function randomDouble()
    {
        $output = rand(1, 9);
        $length = rand(5, 25);
        for ($i = 0; $i < $length; $i++) {
            $output .= rand(0, 9);
        }

        $output .= '.';
        $length = rand(5, 25);
        for ($i = 0; $i < $length; $i++) {
            $output .= rand(0, 9);
        }

        return $output;
    }
}
