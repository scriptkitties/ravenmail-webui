<?php

namespace App;

trait AddressTrait {
    public function getAddress() : string
    {
        return $this->local . '@' . $this->domain;
    }
}

