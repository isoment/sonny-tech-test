<?php

declare(strict_types=1);

/**
 *  A pegasus is not a bird and it is not really a horse (I think?) so having a pegasus inherit behavior
 *  from either of these classes does not really make sense since it is not an IS-A relationship. We can
 *  create a Fly class and Gallop class to delegate these behaviors to.
 */

class Fly
{
    public function perform() : void
    {
        echo 'Flying...';
    }
}

class Gallop
{
    public function perform() : void
    {
        echo 'Galloping...';
    }
}

class Horse
{
    private Gallop $gallop;

    public function __construct()
    {
        $this->gallop = new Gallop();
    }

    public function gallop() : void
    {
        $this->gallop->perform();
    }
}

class Bird
{
    private Fly $fly;

    public function __construct()
    {
        $this->fly = new Fly();
    }

    public function fly() : void
    {
        $this->fly->perform();
    }
}

class Pegasus
{
    private Fly $fly;
    private Gallop $gallop;

    public function __construct()
    {
        $this->fly = new Fly();
        $this->gallop = new Gallop();
    }

    public function gallop() : void
    {
        $this->gallop->perform();
    }

    public function fly() : void
    {
        $this->fly->perform();
    }
}

$horse = new Horse();
$horse->gallop();
echo '</br>';

$horse = new Bird();
$horse->fly();
echo '</br>';

$pegasus = new Pegasus();
$pegasus->gallop();
echo '</br>';
$pegasus->fly();
echo '</br>';