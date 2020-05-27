<?php

// phpcs:ignoreFile
// this file is auto-generated by prolic/fpp
// don't edit this file manually

declare(strict_types=1);

namespace BolCom\RetailerApi\Model\Offer\Query;

final class ExportFile extends \Prooph\Common\Messaging\Query
{
    use \Prooph\Common\Messaging\PayloadTrait;

    const MESSAGE_NAME = 'BolCom\RetailerApi\Model\Offer\Query\ExportFile';

    protected $messageName = self::MESSAGE_NAME;

    public function entityId(): string
    {
        return $this->payload['entityId'];
    }

    public static function with(string $entityId): ExportFile
    {
        return new self([
            'entityId' => $entityId,
        ]);
    }

    protected function setPayload(array $payload)
    {
        if (! isset($payload['entityId']) || ! \is_string($payload['entityId'])) {
            throw new \InvalidArgumentException("Key 'entityId' is missing in payload or is not a string");
        }

        $this->payload = $payload;
    }
}