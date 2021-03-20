# PHP wrapper for the BC Math extension
Wrapper to make working with the BC Math extension of PHP easier to use.

## Installation
Install the package using composer:
`composer require dovab/big-number`

## Usage
Create an instance of `BigNumber` with the first value. The value can be an integer, float, or a really big number 
as a string. 

After creating the instance you can manipulate the value using the provided functions:
* `add` - To add another value to it
* `subtract` - To subtract a value from it
* `multiply` - To multiply the value by the given value
* `divide` - To divide the value by the given value
* `modulus` - To get the modulus of the given value

For example:
```php
$number = new BigNumber('4839276542939265829734291003');
$number->setScale(4)
    ->add(5)
    ->multiply(11.98)
    ->subtract(new BigNumber('19478320759'))
    ->divide('9894675903.83755');
    
echo $number;
```

The `BigNumber` instance also has methods to compare the value to another value:
* `equals`
* `greaterThan`
* `greaterThanOrEquals`
* `lowerThan`
* `lowerThenOrEquals`
