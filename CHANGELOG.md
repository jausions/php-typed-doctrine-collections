# Change Log

## Version 2.0.0-alpha
 - Extended support for PHP 5.6 to 8.2.
 - Extended support for Doctrine/Collection 1.4 to 2.1.
 - Bump dependencies to 2.0.0-alpha for
   [jausions/php-typed-collections](https://github.com/jausions/php-typed-collections)
 - Switched dev dependencies from [fzaninotto/faker](https://github.com/fzaninotto/Faker)
   to [fakerphp/faker](https://fakerphp.github.io/).
 - Added `CollectionOf::mapOf()` method to return a typed collection.
 - Fixed `map()` that was wrongly constraining the type of collection elements,
   making the method unusable in most cases.

## Version 1.0.0
 - Initial release
