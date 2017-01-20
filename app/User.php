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
    use AddressTrait;
    use AuthenticatableTrait;
    use UuidTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    public function aliases()
    {
        return Alias::where('local', $this->local)
            ->where('domain_uuid', $this->domain->uuid)
            ->get()
        ;
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_uuid', 'uuid');
    }

    public function domainsModerating()
    {
        return $this->belongsToMany(Domain::class, 'domain_moderators');
    }

    public static function isRegisterable(string $local, string $domain) : bool
    {
        $domain = Domain::findByNameOrFail($domain);

        // check for duplicate
        $count = self::where('local', $local)
            ->where('domain_uuid', $domain->uuid)
            ->count()
        ;

        if ($count > 0) {
            return false;
        }

        // check for local part on noreg list
        $count = NoregAddress::where('local', $local)
            ->where('domain_uuid', '')
            ->count()
        ;

        if ($count > 0) {
            return false;
        }

        // check for full address on noreg list
        $count = NoregAddress::where('local', $local)
            ->where('domain_uuid', $domain->uuid)
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
