<?php

declare(strict_types=1);

/**
 *  Let's use a composition approach. The question kinda makes us think we should use
 *  inheritance and try to define a relationship between all the entities but the Pet class throws
 *  a wrench in that, a Pet isn't a person. Sure we could define a new parent class like LifeForm
 *  and try to define the relationships in relation to that but it seems messy.
 *  
 *  Instead of creating an inheritance tree that gets more and more complex as we add new classes
 *  let's just create a Name class that has the sole responsibility of naming stuff. We can create a new
 *  instance of it whenever we need a name in one of our other classes.
 */
class Name
{
    public function __construct(
        protected string $firstName,
        protected ?string $lastName = null,
        protected ?string $middleName = null
    ) {}

    public function getName() : string
    {
        return "{$this->firstName} {$this->middleName} {$this->lastName}";
    }
}

class Person
{
    protected Name $name;

    public function __construct(
        string $firstName,
        string $lastName,
        ?string $middleName = null
    ){
        $this->name = new Name($firstName, $middleName, $lastName);
    }

    public function getName() : string
    {
        return $this->name->getName();
    }
}

class Employee
{
    protected Name $name;
    protected string $employeeId;

    public function __construct(
        string $firstName,
        string $lastName,
        string $employeeId,
        ?string $middleName = null
    ){
        $this->name = new Name($firstName, $middleName, $lastName);
        $this->employeeId = $employeeId;
    }

    public function getName() : string
    {
        return $this->name->getName();
    }

    public function getId() : string
    {
        return $this->employeeId;
    }
}

class Pet
{
    protected Name $name;

    public function __construct(
        string $firstName,
        ?string $middleName = null,
        ?string $lastName = null
    ){
        $this->name = new Name($firstName, $middleName, $lastName);
    }

    public function getName() : string
    {
        return $this->name->getName();
    }
}

// Person without middle name.
$person = new Person('John', 'Doe');
echo $person->getName();
echo '</br>';

// Employee with middle name.
$employee = new Employee('Jane', 'Doe', 'EID123456', 'Smith');
echo "{$employee->getName()}, Employee ID: {$employee->getId()}";
echo '</br>';

// Pet with only a first name.
$pet = new Pet('Spike');
echo $pet->getName();