<?php

namespace DomainProvider\Services;

use DomainProvider\Exceptions\CloudflareException;
use DomainProvider\Models\ApiKey;
use DomainProvider\Models\Zone;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * This class used for access cloudflare v4 using guzzlehttp
 *
 * @author Indra Gunawan <indra@studionesia.com>
 */
class CloudflareAPI
{
    /**
     * @var GuzzleHttp\Client
     */
    private $client;
    private $zoneId;
    private $methods = [];

    public function __construct()
    {
        $zone = get_class(new Zone());
        $apiKey = get_class(new ApiKey());

        $this->methods = [
            'getUserDetail' => [$apiKey, 0],
            'createZone' => [$apiKey, 1],
            'deleteZone' => [$zone, 0],
            'createDnsRecord' => [$zone, 1],
            'updateDnsRecord' => [$zone, 2],
            'deleteDnsRecord' => [$zone, 1],
            'disableEmailObfuscation' => [$zone, 0],
        ];
    }

    public function __call($name, $args)
    {
        $argsCount = count($args);
        if (0 === $argsCount) {
            throw new \InvalidArgumentException(
                'Minimal 1 argument.'
            );
        }

        if (!array_key_exists($name, $this->methods)) {
            throw new \Exception(
                sprintf("Call undefined method '%s'", $name)
            );
        }

        // create guzzle client
        $email = '';
        $apikey = '';
        if ($args[0] instanceof ApiKey) {
            $email = $args[0]->email;
            $apikey = $args[0]->api_key;
        } else if ($args[0] instanceof Zone) {
            $api = $args[0]->apiKey;
            $email = $api->email;
            $apikey = $api->api_key;
            $this->zoneId = $args[0]->cf_id;
        } else {
            throw new \InvalidArgumentException(
                'First argument must be instance of ApiKey or Zone.'
            );
        }

        $this->client = new Client([
            'base_url' => 'https://api.cloudflare.com/client/v4/',
            'defaults' => [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Auth-Email' => $email,
                    'X-Auth-Key' => $apikey
                ]
            ]
        ]);

        // execute the method
        $method = $this->methods[$name];

        if ($args[0] instanceof $method[0] && $argsCount - 1 === $method[1]) {
            switch ($argsCount - 1)
            {
                case 0:
                    return $this->$name();
                case 1:
                    return $this->$name($args[1]);
                case 2:
                    return $this->$name($args[1], $args[2]);
                case 3:
                    return $this->$name($args[1], $args[2], $args[3]);
                case 4:
                    return $this->$name($args[1], $args[2], $args[3], $args[4]);

                default:
                    return call_user_func_array(array($this, $name), $args);
            }
        }

        throw new \Exception(
            sprintf("Call undefined method '%s'", $name)
        );
    }

    /**
     * https://api.cloudflare.com/#user-user-details
     * @return JSONObject
     */
    private function getUserDetail()
    {
        try {
            $response = $this->client->get('user');

            return $response->json(['object' => true])->result;
        } catch (ClientException $e) {
            throw new CloudflareException('cloudflare.http_response_codes.'.$e->getCode(), $e->getCode());
        }
    }

    /**
     * https://api.cloudflare.com/#zone-create-a-zone
     * @param  string $name
     * @return JSONObject
     */
    private function createZone($name)
    {
        try {
            $response = $this->client->post('zones', [
                'json' => [
                    'name' => $name,
                    'jump_start' => false
                ]
            ]);

            return $response->json(['object' => true])->result;
        } catch (Exception $e) {
            throw $this->createCloudflareException($e);
        }
    }

    /**
     * https://api.cloudflare.com/#zone-delete-a-zone
     * @return JSONObject
     */
    private function deleteZone()
    {
        try {
            $response = $this->client->delete('zones/'.$this->zoneId);

            return $response->json(['object' => true])->result;
        } catch (Exception $e) {
            throw $this->createCloudflareException($e);
        }
    }

    /**
     * https://api.cloudflare.com/#dns-records-for-a-zone
     * @param  array  $datas
     * @return JSONObject
     */
    private function createDnsRecord(array $datas)
    {
        try {
            $response = $this->client->post('zones/'.$this->zoneId.'/dns_records', [
                'json' => $datas
            ]);

            return $response->json(['object' => true])->result;
        } catch (Exception $e) {
            throw $this->createCloudflareException($e);
        }
    }

    /**
     * https://api.cloudflare.com/#dns-records-for-a-zone-update-dns-record
     * @param  string $dnsCfId
     * @param  array  $datas
     * @return JSONObject
     */
    private function updateDnsRecord($dnsCfId, array $datas)
    {
        try {
            $response = $this->client->put('zones/'.$this->zoneId.'/dns_records/'.$dnsCfId, [
                'json' => $datas
            ]);

            return $response->json(['object' => true])->result;
        } catch (Exception $e) {
            throw $this->createCloudflareException($e);
        }
    }

    /**
     * https://api.cloudflare.com/#dns-records-for-a-zone-delete-dns-record
     * @param  string $dnsCfId
     * @return JSONObject
     */
    private function deleteDnsRecord($dnsCfId)
    {
        try {
            $response = $this->client->delete('zones/'.$this->zoneId.'/dns_records/'.$dnsCfId);

            return $response->json(['object' => true])->result;
        } catch (Exception $e) {
            throw $this->createCloudflareException($e);
        }
    }

    private function createCloudflareException($e)
    {
        if ($e instanceof ClientException) {
            $response = $e->getResponse()->json(['object' => true]);

            if (isset($response->errors) && isset($response->errors[0]->error_chain)) {
                $errors = $response->errors[0];
                $error = $errors->error_chain[count($errors->error_chain) - 1];

                throw new CloudflareException($error->message, $error->code);
            }

            throw new CloudflareException('cloudflare.http_response_codes.'.$e->getCode(), $e->getCode());
        }

        throw new CloudflareException(trans('front.error.please_contact_admin'), '0');
    }

    private function disableEmailObfuscation()
    {
        try {
            $response = $this->client->patch('zones/'.$this->zoneId.'/settings/email_obfuscation', [
                'json' => [
                    'value' => 'off',
                ]
            ]);

            return $response->json(['object' => true])->result;
        } catch (Exception $e) {
            throw $this->createCloudflareException($e);
        }
    }
}
