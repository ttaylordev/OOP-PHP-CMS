# Notes

## Nested Classes

- I could use namespaces to achieve similar results, but stick to one per file as to not gum up the autoloader.
- I could use json_encode(array) to achieve a nested JSON object, but that's not exactly what I'm looking for, unless I was using a document database instead of mysql.
- The most straightforward way of accomplishing this is using an associative array.

e.g.

```JSON
{ "client": {
    "build": "1.0",
    "name": "xxxxxx",
    "version": "1.0"
    },
    "protocolVersion": 4,
    "data": {
        "distributorId": "xxxx",
        "distributorPin": "xxxx",
        "locale": "en-US"
    }
}
```

> Using json_encode() method.

```php

$clientObject = array(
    "client"=> array( array(
        "build"=> "1.0",
        "name"=> "xxxxxx",
        "version"=> "1.0"
        ),
        "protocolVersion"=> 4,
        "data"=> array(
            "distributorId"=> "xxxx",
            "distributorPin"=> "xxxx",
            "locale"=> "en-US"
        )
    )
);

// header('Content-Type: application/json'); // turns the whole page into JSON formatted text

// converts an array into json
$json_element =  json_encode( $clientObject, JSON_PRETTY_PRINT);

// outputs json to the screen with no formatting
echo "<div style='white-space:pre;'>" . $json_element . "</div>";

// outputs json to the screen
echo "<pre>" . $json_element . "</pre>";

// outputs json to the screen
print_f("<pre>%s</pre>", $json_element);

```

> converted to php associative array

```php

array( "client"=> array(
    "build"=> "1.0",
    "name"=> "xxxxxx",
    "version"=> "1.0"
    ),
    "protocolVersion"=> 4,
    "data"=> array(
        "distributorId"=> "xxxx",
        "distributorPin"=> "xxxx",
        "locale"=> "en-US"
    )
)

```

## active record / ORM

Object relational mapping
>Laravel Eloquent library is a popular example.

ORM is a bit of an anti-pattern, breaking several OOP principles like the single-responsibility principle.

Two popular styles:

1. Data Mapper 
2. Active Record

I am using Active Record

- storing a virtual database that maps to an object within our code.
- fills out the objects to use within the code based on available data within the database
- allows me to work with data in an object oriented manner
- handles the SQL, building the queries from array data passed to the function.

A data mapper will be blind to database manipulation, which is done in a separate service, like an entity manager.
A good example of a data mapper with a very clean approach is Doctrine
> <https://symfony.com/doc/current/doctrine.html>
