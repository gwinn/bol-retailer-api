<?php

// this file is auto-generated by prolic/fpp
// don't edit this file manually

declare(strict_types=1);

namespace BolCom\RetailerApi\Model\Offer\Command;

final class CreateOrUpdateOffer
{
    private $retailOffer;

    public function __construct(\BolCom\RetailerApi\Model\Offer\RetailerOfferUpsert $retailOffer)
    {
        $this->retailOffer = $retailOffer;
    }

    public function retailOffer(): \BolCom\RetailerApi\Model\Offer\RetailerOfferUpsert
    {
        return $this->retailOffer;
    }

    public function withRetailOffer(\BolCom\RetailerApi\Model\Offer\RetailerOfferUpsert $retailOffer): CreateOrUpdateOffer
    {
        return new self($retailOffer);
    }
}