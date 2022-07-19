# v2

Works with PHP 8.1.

### V2.1

Change: When comparing two instances with one another, they are only considered equal (by default) if they are of the same concrete class.
You can continue doing loose comparisons (only comparing the value) by passing the `$strictCheck=false` parameter.

Previously, a child class of UuidId was considered equal to another child class of UuidId if they both had the same value. Now they need to be both of the same child class as well as have the same value.
When using `$strictCheck=false`, you can even compare a UuidId instance with any other Identifier instance (for the value only).

In the case of `IntegerId`, the class to compare with must not only implement the `Identifier` interface, but also have a public `toInt` method returning an integer. If it does, it can be compared to any `IntegerId` class (only with `$strictCheck=false`) and will be considered equal if they contain the same integer value.
With `$strictCheck=true` (the default), the two objects will only be considered equal if they are of the same (child) class *and* have the same value.

Feature: Added `isNotEqual` method to both types of Identifiers, which is obviously the opposite of `isEqual`.


### v2.0.1

Dev: Brought unit test coverage to 100%. Remaining escaped mutants are false positives. Added Quality Control section to README.md.


### v2.0

Dev: Upgrade to PHP 8.1. Note that anything below PHP 8.1 is no longer supported.


# v1

Works with PHP 7.3 and above.
Tested with PHP 8.1


### v1.3.1
Composer: Updated licence name

Dev-only: Updated test namespace


### v1.3
Feature: Added new factory methods for UuidId and IntegerId. 

Dev-only: Added unit and mutation tests.


### v1.2.1
Dev-only: Removed left-over qualified bool


### v1.2
Dev-only: Removed qualifier of scalar types


### v1.1
Dev-only: Imported functions and scalar types


### v1.0 
Feature: Basic UUID and Int identifiers.