<?php

namespace App;

use Exception;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; 

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    use AddressTrait;

    public $timestamps = false;

    public function getDestinationAliases() : Collection
    {
        $aliases = Alias::where('destination', $this->getAddress())->get();

        return $aliases;
    }

    public static function checkValidLocal(string $string) : bool
    {
        $regexes = [
            '/^\./',
            '/\.$/',
            '/[^\.\'\/a-zA-Z0-9!#$%&*-=?^_`{|}~]/',
        ];

        foreach ($regexes as $regex) {
            $result = preg_match($regex, $string);

            // check if the regex engine broke
            if ($result === false) {
                throw new Exception('Regex match failed');
            }

            // check if anything matched
            if ($result > 0) {
                return false;
            }
        }

        return true;
    }
}
