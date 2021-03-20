<?php

namespace Dovab\Utility\Number;

/**
 * Class BigNumber
 * @package Dovab\Utility
 */
class BigNumber
{
    /**
     * @var string
     */
    private string $value;

    /**
     * BigNumber constructor.
     *
     * @param $value
     */
    public function __construct($value) {
        $this->value = strval($value);
        bcscale(8);
    }

    /**
     * @param int $scale
     *
     * @return $this
     */
    public function setScale(int $scale): BigNumber {
        bcscale($scale);

        return $this;
    }

    /**
     * @param $number
     *
     * @return $this
     */
    public function add($number): BigNumber {
        $this->calculate('bcadd', $number);

        return $this;
    }

    /**
     * @param $number
     *
     * @return $this
     */
    public function subtract($number): BigNumber {
        $this->calculate('bcsub', $number);

        return $this;
    }

    /**
     * @param $number
     *
     * @return $this
     */
    public function multiply($number): BigNumber {
        $this->calculate('bcmul', $number);

        return $this;
    }

    /**
     * @param $number
     *
     * @return $this
     *
     * @throws BigNumberException
     */
    public function divide($number): BigNumber {
        $this->calculate('bcdiv', $number);

        return $this;
    }

    /**
     * @param $number
     *
     * @return $this
     * @throws BigNumberException
     */
    public function modulus($number): BigNumber {
        $this->calculate('bcmod', $number);

        return $this;
    }

    /**
     * @param $number
     *
     * @return bool
     */
    public function equals($number): bool {
        return $this->compare($number) === 0;
    }

    /**
     * @param $number
     *
     * @return bool
     */
    public function greaterThan($number): bool {
        return $this->compare($number) === 1;
    }

    /**
     * @param $number
     *
     * @return bool
     */
    public function greaterThanOrEquals($number): bool {
        return $this->compare($number) >= 0;
    }

    /**
     * @param $number
     *
     * @return bool
     */
    public function lowerThan($number): bool {
        return $this->compare($number) === -1;
    }

    /**
     * @param $number
     *
     * @return bool
     */
    public function lowerThanOrEquals($number): bool {
        return $this->compare($number) <= 0;
    }

    /**
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }

    /**
     * @return BigNumber
     */
    public function clone(): BigNumber {
        return new BigNumber($this->value);
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->getValue();
    }

    /**
     * @param string $method
     * @param $number
     *
     * @throws BigNumberException
     */
    private function calculate(string $method, $number): void {
        $secondOperand = $this->getStringValue($number);

        try {
            $this->value = $method($this->value, $secondOperand);
        } catch(\Error $e) {
            throw new BigNumberException($e->getMessage());
        }
    }

    /**
     * @param $number
     *
     * @return int
     */
    private function compare($number): int {
        return bccomp($this->value, $this->getStringValue($number));
    }

    /**
     * Converts the value given (BigNumber, integer, float, string) to a string
     *
     * @param $value
     *
     * @return string
     */
    private function getStringValue($value): string {
        return $value instanceof BigNumber ? $value->getValue() : strval($value);
    }
}
