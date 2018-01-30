<?php

namespace Maxfactor\Support\Location;

use Symfony\Component\Intl\Intl;
use DvK\Vat\Countries as TaxRules;
use Illuminate\Support\Collection;

class Countries
{
    protected $defaultCountryCode = 'GB';

    protected $taxRules;

    protected $countryCode;
    protected $countryTaxApplicable;
    protected $countryTaxOptional;

    public function __construct(TaxRules $taxRules)
    {
        $this->taxRules = $taxRules;
    }

    public function list(): array
    {
        return Intl::getRegionBundle()->getCountryNames();
    }

    public function info(string $code): Collection
    {
        $location = collect([
            'countryCode' => $code,
        ]);

        if (!$location->has('countryCode')) {
            $location->put('countryCode', $this->$defaultCountryCode);
        }

        return $location
            ->put('taxApplicable', $this->isTaxApplicable($location->get('countryCode')))
            ->put('taxOptional', $this->isTaxOptional($location->get('countryCode')));
    }

    protected function isTaxOptional(string $code): bool
    {
        return $this->taxRules->inEurope($code)
            && !collect(['GB', 'UK'])->contains($code);
    }

    protected function isTaxApplicable(string $code): bool
    {
        return $this->taxRules->inEurope($code);
    }
}
