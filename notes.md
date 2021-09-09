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

## Strict types

It is enabled on a file by file basis by adding declare(strict_types=1); to the very top of each file.

Type declarations can be added to arguments, class properties, variables, constants, and return values of functions.

```php
declare(strict_types=1); // must be first line of code, even before namespace declarations.

// henceforth the php interpreter will use strict typing rules. Errors will be thrown, rather than warnings and type coercion. 

class User{

    public int $id;
    public string $name;

    // in addition to the specified string type, a null value is also acceptable. Prefix with ?
    public ?string $surname = null;

            // type declaration for method, :  and return value
    public function enroll(Course $course): int|bool { 
        // union types were added on php 8, type declarations can be more than one type separated by a | .
        return $course->enroll($this->id);
    }
}



function addTwoIntegers(int $a, int $b){

    echo 'Arg 1:', gettype($a), "\n";
    echo 'Arg 2:', gettype($b), "\n";

    return $a + $b;
}

var_dump(addTwoIntegers(7, 4.5)); 

// ^^ will throw an error if strict_types=1
// will coerce or warn, if strict typing isn't enabled

```

There are many Available types to use. These are only a few:

- TypeError
- class/interface names
- self
- array
- callable
- bool
- float
- int
- string
- iterable
- object

A helpful tool for working with strict types is the try/catch method for generating robust error messages.

```php
    declare(strict_types = 1);

    class Router {
        public function doStuff(string $someStr){
            echo $someStr;
        }
    }

    $router = new Router();

    // Error!: Router::doStuff(): Argument #1 ($someStr) must be of type string, int given, called in C:\xampp\htdocs\some-project\index.php on line $x.
    try {
        $router->doStuff(42);
        echo $router->doStuff(54);
    } catch (TypeError $e) {
        echo "Error!: " . $e->getMessage();
    }

```

## Declarative Shipping Calculator

As the project grows and functionality is added, perhaps a pdf printable receipt, or an order status page is added, a lot of this code is likely going to be duplicated, We could package it into a functions.php file somewhere, but then it's still disorganized among all the other functions we have hidden away for reusability.

The function could then, be misused by some associate in some manner it was not intended for. Maybe I come along and update the function later, but it's being used in all these strange manners around the program and this simple change breaks many other things. It would be great to have things tightly bound and limited to its' intended use.

> This example is quick and easy, but difficult to maintain and extend if the need arises. If it arises late, being the reason to write it this way, it will also be harder to work around and harder to extend given the lost context. OOP is a much more organized and robust approach, even if it takes longer and we struggle through errors in its' making.

```php
function calculateShipping($productWeight, $pricePerKilo) {
    return $productWeight * $pricePerKilo;
}

$products[1]['weight'] = 2;
$products[1]['price'] = 5;

$pricePerKilo = 5;
$totalShippingPrice = 0;
foreach($products as $product){
    $totalShippingPrice = calculateShipping($product['weight'], $pricePerKilo);
}

echo $totalShippingPrice;
```

### naive half OOP shipping calculator

```php
// Model \/\/
    class Product {
        private int $price;
        private int $weight;

        // reserved method that is called when we instantiate an object
        public function __construct($price, $weight){
            $this->weight = $weight;
            $this->price = $price;
        }

        function getWeight(){
            return $this->weight;
        }
    }

    class Shipping {
        private $totalShipping;
        public function calcShippingTotal($weight, $pricePerKilo){
            return $weight * $pricePerKilo;
        }
    }

// controller \/\/
    $product1 = new Product(46, 2);
    $product2 = new Product(23, 4);
    $product3 = new Product(12, 7);

    $pricePerKilo = 5;
    
    $shipping = new Shipping();

    $totalShippingPrice = $shipping->calcShippingTotal($product1->getWeight(), $pricePerKilo);
    
    var_dump($totalShippingPrice);
```

### better OOP shipping calculator

> Better example of OOP-PHP
> Each class could be in its' own file, making it easy to find and change or lookup later
> All scopes are tightly constrained and controlled.

```php
// Model \/\/
    class Product {
        private int $price;
        private int $weight;

        // reserved method that is called when we instantiate an object
        public function __construct(int $price, int $weight){
            $this->weight = $weight;
            $this->price = $price;
        }

        function getWeight(){
            return $this->weight;
        }
    
    }
// keeping everything nice and contained within a tightly specified scope
    class Shipping {
        private $totalShippingPrice;
        private $products;
        private $pricePerKilo;
        private $freeShipping = false;


        public function __construct($pricePerKilo){
            $this->pricePerKilo = $pricePerKilo;
        }

        // type-hint as type Product
        public function arrProducts(Product $product){
            $this=>products[] = $product;
        }

        // getters and setters are not needed as we can manipulate a public variable manually
        // using getters and setters allowing more rules into the methods in the future.
        function setFreeShipping(){
            $this->freeShipping = true;
        }

        function getFreeShipping(){
            return $this->freeShipping;
        }

        // just calculate and set value, do not return
        public function calcShippingTotal(){
            foreach ($this->products as $product){
                if(!$product->getFreeShipping()){
                    $this->totalShippingPrice += ($product->getWeight() * $this->pricePerKilo);
                }
            }
        }

        // return the results
        public function getTotalShippingPrice() {
            return $this->totalShippingPrice;
        }
    }

    // Controller \/\/


// these values and method calls would be in a loop, getting values from an array passed in from the view.
    $product1 = new Product(46, 2);
    $product2 = new Product(23, 4);
    $product3 = new Product(12, 7);
    $product3->setFreeShipping();

    $pricePerKilo = 5;

    $shipping = new Shipping($pricePerKilo);
// these values and method calls would be in a loop, getting values from an array passed in from the view.
    $shipping->arrProducts($product1);
    $shipping->arrProducts($product2);
    $shipping->arrProducts($product3);
    $shipping->calcShippingTotal();
    
    $totalShippingPrice = $shipping->getTotalShippingPrice();
    
    var_dump($totalShippingPrice);

```

## visibility

### Private

Private methods and properties are only available within the class that they were originally defined, not children extended, nor from the outside.

```php

class MyClass {
    private $var = 'I like OOP';

    public function __construct($) {
        $this->var = $text;
    }

// Private scope
    private function my_function() {
        echo $this->var;
    }
}
class NewClass extends myClass {

}

$myClass = new MyClass('Hi');
$myClass->my_function();  // produces an error, because the NewClass has no access to the private method of MyClass Class.

```

### Protected

Protected methods and properties are only available within the class that created them and any child classes, but not outside in an instantiation of those classes.

```php

class MyClass {
    private $var = 'I like OOP';

    public function __construct($) {
        $this->var = $text;
    }

// Protected scope
    protected function my_function() {
        echo $this->var;
    }
}
class NewClass extends myClass {

}

$myClass = new MyClass('Hi');
$myClass->my_function();  // produces an error, because the NewClass has no access to the protected method of MyClass Class.

```

### Public

```php

class MyClass {
    private $var = 'I like OOP';
    protected $var = "and I don't care who hears me";

    public function __construct($) {
        $this->var = $text;
    }

    public function my_function() {
        echo $this->var;
    }
}

class NewClass extends myClass {
    public function display(){
        echo $this->PrivVar; // it will not echo out a private property, even though the function is public
        echo $this->ProtVar; // echos out the protected var.
    }
}

$myClass = new MyClass('Hi');
$myClass->my_function();  // executes from within the class, any child classes, or from outside the class as in an instantiation

$newClass = new NewClass('Hi');
$newClass->display();

```

## Static

Create a static property or method when needing to access a property or method without first instantiating an object. This could be an anti-pattern if used when an object instantiation would be better suited, but there are legitimate reasons for using static properties.

They are used differently than object properties and methods. Use static when needing to create a property or method that cannot be usefully, directly linked to an object created from the class.

Within the object, static properties cannot be accessed. It will not be included as part of that object. Static properties must be accessed via class.

Use static when an object does not need access to it, but it seems like the logical class to classify it under for code organization purposes.

```php
class Person {
    private $name;
    private $eyeColor;
    private $age;
// since this will not change with each instantiation of an object, there is not need to make it available. drinking age will remain 21 for everyone in this example.
    public static $drinkingAge = 21;

    public function __construct($name, $eyeColor, $age){
        $this->name = $name;
        $this->eyeColor = $eyeColor;
        $this->age = $age;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

// static values may be accessed from an object's non static methods.
     public function getDrinkAge(){
        return $this->$drinkingAge;
    }

    public static function setDrinkingAge($newDrinkAge){
        self::$drinkingAge; = $newDrinkAge;
    }

}
// :: instead of -> for static properties.
echo Person::$drinkingAge;  // outputs 21

// calling the static method
Person::setDrinkingAge(18); 
echo Person::$drinkingAge; // outputs 18

$marty = new Person("marty", 'blue', 20);
$richard = new Person('richard', 'green', 67)

echo $marty->getName(); // returns "marty"

// static values may be accessed from an object's non static methods.
echo $richard->getDrinkAge(); // returns 18

```

## Singleton Pattern

Singletons are used when it is best to only allow one instantiation of a resource hungry object

1. A private constructor is used to prevent direct creation of objects from the class.
2. Expensive processes are executed from within the private constructor.
3. Define a single process to instantiate the class from a static method, creating the object only if it has not already been created.

```php

class SingleDingle {
    // hold class instance
    private static $instance = null;

    // private constructor
    private function __construct(){
        // expensive process here.
    }

    // object is created from inside the class
    // only once
    public static function getInstance(){

        if(self::$instance == null){
            self::$instance = new SingleDingle();
        }
        return self::$instance;
    }
}

// This instance will remain as the single reference to this single class, no duplication
```

>Database example

```php

class DbConnection {
    private static $instance = null;
    private $connection;
    private $host = 'localhost';
    private $user = 'root';
    private $password = '12345';
    private $dbName = 'dbName';

    private function __construct(){
        $this->connection = new PDO('mysql:host={$this->host}; dbname={$this->name}', $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new DbConnection();
        }
        return self::$instance;
    }
}

```

## Law of Demeter

- Each unit should have only limited knowledge about other units: only units "closely" related to the current unit.
- Each unit should only talk to its friends; don't talk to strangers.
- Only talk to your immediate friends.

## SOLID

**Single Responsibility Principle (SRP):** A class should have only one reason to change.

The original formulation was "a class should do one thing; it should do it all, it should do it well, and it should do it only." This was subject to a lot of interpretation and didn't address the dependency problems in software design, so it was reformulated. A feature of good design is that all classes have clear, crisp responsibility boundaries. When code is munged together or poorly organized by responsibility, it is hard to determine where a change should be made.

**Open-Closed Principle (OCP):** Software entities should be open for extension, but closed for modification.

This was originally formulated by Bertrand Meyer to say essentially that published interfaces should not change. It evolved to a larger meaning that new features should be added primarily as new code, and not as a series of edits to a number of existing classes. A quality of good design is the extent to which new features are bolted-on instead of woven-in.

**Liskov Substitution Principle:** Subtypes must be substitutable for their base types.

Barbara Liskov's paper Family Values addressed a notion of the proper use of inheritance. There have always been a lot of design errors from overuse or misuse of inheritance between classes. When a base class has methods that don't apply to all of its children, then something has gone wrong. When a class uses an interface, but some implementations are inadvisable or incompatible, then the design is unclean.

**Interface Segregation Principle (ISP):** Clients shouldn't be forced to depend on methods they don't use.

In a good design, dependencies are managed. To keep irrelevant changes from flowing up into classes that don't really care about them, it behooves the developer to keep interfaces small and focused.

Of course, the problems of conglomerated interfaces don't manifest the same way in dynamic languages because of late binding, but the problem lives on in C++, C#, Java and other statically-typed languages. In dynamic languages interfaces are not declared, but just understood to exist. If my python program only calls an add routine and an assignment on an argument, then it is understood that the argument must include an add and an assignment in its interface. I automatically depend only on the methods I use in my code, and changes to the underlying class do not seep unbidden into my code.

On the other hand, we find that some dynamic languages are adding declarative interfaces, and some do interface with java or C programs through declared interfaces. Maybe the principle lives on after all.

**Dependency Inversion Principle (DSP):** Abstractions should not depend on details; details should depend on abstractions.

Since abstractions are built with the intention of writing interface users and interface implementations, it is reasonable that most of our code should depend on abstractions (opening the code to open/closed goodness) rather than concrete implementations (making further change a matter of weaving new code with old). Again, problems with this principle do not manifest the same way in dynamic languages, but not everyone uses dynamic languages.

And of course, even if one uses dynamic languages one might find it useful to use an interface that limits exposure to details. This warning still applies to leaky abstractions.

If one follows the SOLID principles, one may find that their code becomes more fluidly maintainable than if they did not. Ultimately, that is what the whole good/bad thing was about from the beginning.
