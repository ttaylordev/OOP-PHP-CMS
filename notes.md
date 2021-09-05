# Notes

Nested Classes

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
