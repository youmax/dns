<?php
namespace App\Services\Whois;

use Carbon\Carbon;
use Str;

class Whois
{
    protected $domainRegex = [
        'domain name:*\s+([\w\.\-]+)',
        'domain:*\s+([\w\.\-]+)',
    ];
    protected $registrarRegex = [
        'registrar:\s+([\w\.\-\s\,\/\(\)]+)',
        'organisation:\s+([\w\.\-\s\,\/\(\)]+)',
    ];
    protected $emailRegex = [
        'contact email:\s+([\w\.\-\_@]+)',
        'e-mail:\s+([\w\.\-\_@]+)',
    ];
    protected $phoneRegex = [
        'contact phone:\s+([\s\+\w\.\-\_@]+)',
        'phone:\s+([\s\+\w\.\-\_@]+)',
    ];
    protected $created_atRegex = [
        'creation date:\s+([\w\.\-\_@\:]+)',
        'created:\s+([\w\.\-\_@\:]+)',
    ];
    protected $expired_atRegex = [
        'expiration date:\s+([\w\.\-\_@\:]+)',
        'registry expiry date:\s+([\w\.\-\_@\:]+)',
    ];
    protected $updated_atRegex = [
        'updated date:\s+([\w\.\-\_@\:]+)',
        'changed:\s+([\w\.\-\_@\:]+)',
    ];
    protected $whoisRegex = [
        'registrar whois server:\s+([\w\.\-\_@\:]+)',
        'whois:\s+([\w\.\-\_@\:]+)',
    ];
    protected $nsRegex = [
        'name server:\s+([\w\.\-\_@\:]+)',
        'nserver:\s+([\w\.\-\_@\:]+)',
    ];

    protected $fields = [
        'domain',
        'registrar',
        'email',
        'phone',
        'created_at',
        'updated_at',
        'expired_at',
        'whois',
        'ns',
    ];

    public function getHostname($domain)
    {
        $domain = strtolower($domain);

        if (filter_var($domain, FILTER_VALIDATE_IP)) {
            return $domain;
        }
        if (!Str::contains($domain, '//')) {
            $domain = '//' . $domain;
        }
        $domain = parse_url($domain)['host'];

        $arr = array_slice(array_filter(explode('.', $domain, 4), function ($value) {
            return $value !== 'www';
        }), 0); //rebuild array indexes

        if (count($arr) > 2) {
            $count = count($arr);
            $_sub = explode('.', $count === 4 ? $arr[3] : $arr[2]);

            if (count($_sub) === 2) {
                // second level TLD
                $removed = array_shift($arr);
                if ($count === 4) { // got a subdomain acting as a domain
                    $removed = array_shift($arr);
                }
            } elseif (count($_sub) === 1) {
                // one level TLD
                // $removed = array_shift($arr); //remove the subdomain
                // non country TLD according to IANA
                $tlds = config('tld', []);
                if (count($arr) > 2 && in_array(strtoupper($_sub[0]), $tlds) !== false) {
                    //special TLD don't have a country
                    array_shift($arr);
                }

            } else {
                // more than 3 levels, something is wrong
                for ($i = count($_sub); $i > 1; $i--) {
                    $removed = array_shift($arr);
                }
            }
        } elseif (count($arr) === 2) {
            $arr0 = array_shift($arr);

            if (strpos(join('.', $arr), '.') === false
                && in_array($arr[0], array('localhost', 'test', 'invalid')) === false) {
                // not a reserved domain
                // seems invalid domain, restore it
                array_unshift($arr, $arr0);
            }
        }
        return join('.', $arr);
    }

    protected function find($name, $line)
    {
        $regexName = $name . 'Regex';
        foreach ($this->$regexName as $regex) {
            if (preg_match("/{$regex}/", trim(strtolower($line)), $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    public function getInfo($domain)
    {
        $domain = $this->getHostname($domain);
        exec("whois $domain 2>&1", $output);
        // $output = explode('#', $output);
        $info = [
            'ns' => [],
        ];

        foreach ($output as $row) {
            foreach ($this->fields as $field) {
                if ($str = $this->find($field, $row)) {
                    if ($field == 'ns') {
                        if (!in_array($str, $info['ns'])) {
                            $info[$field][] = $str;
                        }
                    } else {
                        $info[$field] = $str;
                    }
                    continue;
                }
            }
        }
        try {
            if (!empty($info['created_at'])) {
                $info['created_at'] = Carbon::parse($info['created_at'])->toDateTimeString();
            }
        } catch (\Exception $e) {

        }
        try {
            if (!empty($info['updated_at'])) {
                $info['updated_at'] = Carbon::parse($info['updated_at'])->toDateTimeString();
            }
        } catch (\Exception $e) {

        }
        try {
            if (!empty($info['expired_at'])) {
                $info['expired_at'] = Carbon::parse($info['expired_at'])->toDateTimeString();
            }
        } catch (\Exception $e) {

        }
        if (empty($info['ns'])) {
            unset($info['ns']);
        };
        return $info;
    }
}
