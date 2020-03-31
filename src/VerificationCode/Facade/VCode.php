<?php


namespace Huyibin\VerificationCode\Facade;


use Illuminate\Support\Facades\Facade;
/**
 * @method static bool generateAndStore(string $identifier,string $code)
 * @method static bool check(string $identifier,string $code)
 * @see \Huyibin\VerificationCode\VCode
 */
class VCode extends Facade
{
    protected static function getFacadeAccessor()
    {

        return 'VCode';
    }

}
