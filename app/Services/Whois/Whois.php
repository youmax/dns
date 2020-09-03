<?php
namespace App\Services\Whois;

class Whois
{

    public function getHostname($domain)
    {
        $domain = strtolower($domain);

        if (filter_var($domain, FILTER_VALIDATE_IP)) {
            return $domain;
        }
        $arr = array_slice(array_filter(explode('.', $domain, 4), function ($value) {
            return $value !== 'www';
        }), 0); //rebuild array indexes

        if (count($arr) > 2) {
            $count = count($arr);
            $_sub = explode('.', $count === 4 ? $arr[3] : $arr[2]);

            if (count($_sub) === 2) { // two level TLD
                $removed = array_shift($arr);
                if ($count === 4) { // got a subdomain acting as a domain
                    $removed = array_shift($arr);
                }
            } elseif (count($_sub) === 1) { // one level TLD
                $removed = array_shift($arr); //remove the subdomain

                if (strlen($_sub[0]) === 2 && $count === 3) { // TLD domain must be 2 letters
                    array_unshift($arr, $removed);
                } else {
                    // non country TLD according to IANA
                    $tlds = config('tld', []);
                    if (count($arr) > 2 && in_array($_sub[0], $tlds) !== false) { //special TLD don't have a country
                        array_shift($arr);
                    }
                }
            } else { // more than 3 levels, something is wrong
                for ($i = count($_sub); $i > 1; $i--) {
                    $removed = array_shift($arr);
                }
            }
        } elseif (count($arr) === 2) {
            $arr0 = array_shift($arr);

            if (strpos(join('.', $arr), '.') === false
                && in_array($arr[0], array('localhost', 'test', 'invalid')) === false) { // not a reserved domain
                // seems invalid domain, restore it
                array_unshift($arr, $arr0);
            }
        }
        return join('.', $arr);
    }
}
