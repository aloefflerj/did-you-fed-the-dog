<?php

namespace Aloefflerj\FedTheDog;

class UserClass
{
    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}