# PHP Objects with typed/constrained properties

A library for creating PHP objects with typed properties.

It supports all of the types that are supported by
[dealnews/constraints](https://github.com/dealnews/constraints).

## Object with Typed Properties Example

```php
// A very simple example
class Foo extends \DealNews\TypedObjects\TypedProperty {
    protected $id;
    protected $name;

    const CONSTRAINTS = [
        "id" => [
            "type" => "integer"
        ],
        "name" => [
            "type" => "string"
        ],
    ];
}

$foo = new Foo();
$foo->id = "1"; // will be integer 1
$foo->id = "string"; // will throw an exception
```

## Typed Array Example

```php
class FooSet extends \DealNews\TypedObjects\TypedArray {
    const REQUIRED_TYPE = "Foo";
}

$set = new FooSet();
$set[] = new Foo(); // allowed
$set[] = 1; // Throws an exception
```
