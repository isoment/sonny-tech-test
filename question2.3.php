<?php

interface RemoteControl
{
    public function powerOn();
}

class Television
{
    public function setPower($state)
    {
        // Truncate code
    }
}

class CableBox
{
    public function setPower($state)
    {
        // Truncate code
    }
}

class TVRemote implements RemoteControl
{
   private $tv;

   public function __construct(Television $tv) {
       $this->tv = $tv;
   }

   public function powerOn() {
       $this->tv->setPower(true);
   }
}

/**
 *  Create a universal remote that can power on a TV and CableBox
 */
class UniversalRemote implements RemoteControl
{
    private Television $tv;
    private CableBox $cableBox;

    public function __construct(Television $tv, CableBox $cableBox) {
        $this->tv = $tv;
        $this->cableBox = $cableBox;
    }
 
    public function powerOn() {
        $this->tv->setPower(true);
        $this->cableBox->setPower(true);
    }
}

/**
 *  A User can be given a TV Remote or a Universal remote to power on
 *  those devices.
 */
class User
{
    public function useTVRemote(TVRemote $tvRemote)
    {
        $tvRemote->powerOn();
    }

    public function useUniversalRemote(UniversalRemote $universalRemote)
    {
        $universalRemote->powerOn();
    }
}

// Create a Television and a CableBox
$tv = new Television();
$cableBox = new CableBox();

// Create a TV Remote and a Universal Remote and link them to
// the above TV and Cable Box
$tvRemote = new TVRemote($tv);
$universalRemote = new UniversalRemote($tv, $cableBox);

// Create a user 
$user = new User();
// Give them a TV Remote to use
$user->useTVRemote($tvRemote);
// Give them a Universal Remote to use
$user->useUniversalRemote($universalRemote);