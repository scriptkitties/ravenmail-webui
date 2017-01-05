<?php

namespace App;

use Exception;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

use App\NoregAddress;

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    use AddressTrait;

    public function getDateFormat() : string
    {
        return 'Y-m-d H:i:s.u';
    }

    public static function isRegisterable(string $local, string $domain) : bool
    {
        // check for duplicate
        $count = self::where('local', $local)
            ->where('domain', $domain)
            ->count()
        ;

        if ($count > 0) {
            return false;
        }

        // check for local part on noreg list
        $count = NoregAddress::where('local', $local)
            ->where('domain', '')
            ->count()
        ;

        if ($count > 0) {
            return false;
        }

        // check for full address on noreg list
        $count = NoregAddress::where('local', $local)
            ->where('domain', $domain)
            ->count()
        ;

        if ($count > 0) {
            return false;
        }

        return true;
    }

    public static function isValidLocal(string $string) : bool
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

    public function getDestinationAliases() : Collection
    {
        $aliases = Alias::where('destination', $this->getAddress())->get();

        return $aliases;
    }
}
