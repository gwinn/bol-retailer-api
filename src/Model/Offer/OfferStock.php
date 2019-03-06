<?php

// this file is auto-generated by prolic/fpp
// don't edit this file manually

declare(strict_types=1);

namespace BolCom\RetailerApi\Model\Offer;

final class OfferStock
{
    private $amount;
    private $correctedStock;
    private $managedByRetailer;

    public function __construct(QuantityInStock $amount, QuantityInStock $correctedStock, bool $managedByRetailer)
    {
        $this->amount = $amount;
        $this->correctedStock = $correctedStock;
        $this->managedByRetailer = $managedByRetailer;
    }

    public function amount(): QuantityInStock
    {
        return $this->amount;
    }

    public function correctedStock(): QuantityInStock
    {
        return $this->correctedStock;
    }

    public function managedByRetailer(): bool
    {
        return $this->managedByRetailer;
    }

    public function withAmount(QuantityInStock $amount): OfferStock
    {
        return new self($amount, $this->correctedStock, $this->managedByRetailer);
    }

    public function withCorrectedStock(QuantityInStock $correctedStock): OfferStock
    {
        return new self($this->amount, $correctedStock, $this->managedByRetailer);
    }

    public function withManagedByRetailer(bool $managedByRetailer): OfferStock
    {
        return new self($this->amount, $this->correctedStock, $managedByRetailer);
    }

    public static function fromArray(array $data): OfferStock
    {
        if (! isset($data['amount']) || ! \is_int($data['amount'])) {
            throw new \InvalidArgumentException("Key 'amount' is missing in data array or is not a int");
        }

        $amount = QuantityInStock::fromScalar($data['amount']);

        if (! isset($data['correctedStock']) || ! \is_int($data['correctedStock'])) {
            throw new \InvalidArgumentException("Key 'correctedStock' is missing in data array or is not a int");
        }

        $correctedStock = QuantityInStock::fromScalar($data['correctedStock']);

        if (! isset($data['managedByRetailer']) || ! \is_bool($data['managedByRetailer'])) {
            throw new \InvalidArgumentException("Key 'managedByRetailer' is missing in data array or is not a bool");
        }

        $managedByRetailer = $data['managedByRetailer'];

        return new self(
            $amount,
            $correctedStock,
            $managedByRetailer
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount->toScalar(),
            'correctedStock' => $this->correctedStock->toScalar(),
            'managedByRetailer' => $this->managedByRetailer,
        ];
    }
}