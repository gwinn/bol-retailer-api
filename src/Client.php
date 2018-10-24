<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace BolCom\RetailerApi;

use BolCom\RetailerApi\Client\JsonStream;
use BolCom\RetailerApi\Client\ResponseInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;

/**
 * @method ResponseInterface get(string|UriInterface $uri, array $options = [])
 * @method ResponseInterface head(string|UriInterface $uri, array $options = [])
 * @method ResponseInterface put(string|UriInterface $uri, array $options = [])
 * @method ResponseInterface post(string|UriInterface $uri, array $options = [])
 * @method ResponseInterface patch(string|UriInterface $uri, array $options = [])
 * @method ResponseInterface delete(string|UriInterface $uri, array $options = [])
 */
class Client extends \GuzzleHttp\Client
{
    public function __construct(
        LoggerInterface $logger = null,
        string $apiKey = '4c25a73d-31a4-402d-ac4c-83f0f869bca1',
        string $apiSecret = 'CqXYlOHp3t-8WSu_FWTZi1GU7ivy9opskEGKEvj4K5WrJh1Tkdj0K0FvRDrMnxV1oIIJ2T4mBeloaXxMuOp93Q'
    ) {
        $stack = HandlerStack::create();

        $stack->push($this->oauthMiddleware($apiKey, $apiSecret));

        if ($logger) {
            $stack->push(Middleware::log($logger, new \GuzzleHttp\MessageFormatter()));
        }

        $stack->push($this->apiVersion());

        $stack->push(Middleware::mapResponse(function(\Psr\Http\Message\ResponseInterface $response) {
            return $response->withBody(new JsonStream($response->getBody()));
        }));

        parent::__construct([
            'stack' => $stack,
            'base_uri' => 'http://httpbin.org',
            'headers' => [
                'User-Agent' => 'BolCom_RetailerApi/1.0'
            ],
            'connect_timeout' => 5,
            'http_error' => true, //Enables exceptions on 4xx or 5xx errors.
        ]);
    }

    /**
     * Middleware that requires explicit api_version and api_type options.
     *
     * @return callable Returns a function that accepts the next handler.
     */
    private function apiVersion() : callable
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if (empty($options['api_version'])) {
                    throw new \InvalidArgumentException(
                        'api_version should be explicitly set when making a call, ex: 3, 4'
                    );
                }
                if (empty($options['api_type'])) {
                    throw new \InvalidArgumentException(
                        'api_type should be explicitly set when making a call, ex: json, pdf'
                    );
                }

                $version = $options['api_version'];
                $type = $options['api_type'];
                $request->withHeader('Accept', "application/vnd.retailer.v{$version}+{$type}");

                return $handler($request, $options);
            };
        };
    }

    /**
     * @param string $apiKey
     * @param string $apiSecret
     *
     * @return OAuth2Middleware
     */
    private function oauthMiddleware(string $apiKey, string $apiSecret): OAuth2Middleware
    {
        $reauthClient = new \GuzzleHttp\Client(['base_uri' => 'https://login.bol.com/token']);
        $oauthMiddleware = new OAuth2Middleware(new ClientCredentials($reauthClient, [
            'client_id' => $apiKey,
            'client_secret' => $apiSecret,
        ]));
        return $oauthMiddleware;
    }
}
