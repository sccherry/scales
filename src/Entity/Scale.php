<?php
namespace App\Entity;

use JsonSerializable;

class Scale implements JsonSerializable
{
    protected $scale;

    public function __construct(int $scale)
    {
        $this->scale = new \ianring\Scale($scale, 'C');
    }

    public function id()
    {
        return $this->scale->set->bits;
    }

    public function length()
    {
        return $this->scale->countTones();
    }

    public function getCohemitonics()
    {
        return $this->nullIfEmpty($this->scale->cohemitonicTones());
    }

    public function getDistributionSpectra()
    {
        return $this->scale->set->spectrum();
    }
    
    public function getEnantiomorph()
    {
        if ($this->isChiral())
        {
            return $this->scale->enantiomorph()->set->bits;
        }

        return null;
    }

    public function getForte()
    {
        return $this->scale->set->forteNumber();
    }

    public function getImperfections()
    {
        return $this->nullIfEmpty($this->scale->imperfections());
    }

    public function getIntervalPattern()
    {
        if ($this->scale->hasRootTone())
        {
            return $this->scale->intervalPattern();
        }
        else
        {
            $normal = $this->getNormal();

            if ($normal === 0)
            {
                return null;
            }

            $original = $this->id();
            $this->scale->set->bits = $normal;
            $pattern = $this->scale->intervalPattern();
            $this->scale->set->bits = $original;

            return $pattern;
        }
    }

    public function getInverse()
    {
        $original = $this->id();
        $this->scale->invert();
        $inverse = $this->id();
        $this->scale->set->bits = $original;

        return $inverse;
    }

    public function getHemitonics()
    {
        return $this->nullIfEmpty($this->scale->hemitonicTones());
    }

    public function getIntervalVector()
    {
        return $this->scale->spectrum();
    }

    public function getModes()
    {
        return $this->nullIfEmpty($this->scale->modes(false, true));
    }

    public function getNames()
    {
        return $this->scale->name(true);
    }

    public function getNegative()
    {
        return $this->scale->negative();
    }

    public function getNeighbors()
    {
        return $this->nullIfEmpty($this->scale->neighbours());
    }

    public function getNormal()
    {
        if ($this->scale->hasRootTone() || $this->id() === 0)
        {
            return $this->id();
        }

        return $this->getModes()[0];
    }

    public function getPrime()
    {
        return $this->scale->primeForm();
    }

    public function getSpectraVariation()
    {
        return $this->scale->set->spectraVariation();
    }

    public function getSymmetries()
    {
        return $this->nullIfEmpty($this->scale->symmetries());
    }

    public function getTones()
    {
        return $this->nullIfEmpty($this->scale->getTones());
    }

    public function getTritonics()
    {
        return $this->nullIfEmpty($this->scale->tritonicTones());
    }

    public function isChiral()
    {
        return $this->scale->isChiral();
    }

    public function isCohemitonic()
    {
        return $this->scale->isCohemitonic();
    }

    public function isCoherent()
    {
        return $this->scale->set->isCoherent();
    }

    public function isDeep()
    {
        return $this->scale->set->isDeepScale();
    }

    public function isHeliotonic()
    {
        return $this->scale->isHeliotonic();
    }

    public function isHemitonic()
    {
        return $this->scale->isHemitonic();
    }

    public function isHeptatonic()
    {
        return $this->scale->isHeptatonic();
    }

    public function isPalindromic()
    {
        return $this->scale->isPalindromic();
    }

    public function isPrime()
    {
        return $this->scale->isPrime();
    }

    public function isScale()
    {
        return $this->scale->isTrueScale();
    }

    public function isSymmetric()
    {
        return !is_null($this->getSymmetries());
    }

    public function isTritonic()
    {
        return $this->scale->isTritonic();
    }

    public function hasMyhill()
    {
        return $this->scale->set->hasMyhillProperty();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id(),
            'names' => $this->getNames(),
            'length' => $this->length(),
            'tones' => $this->getTones(),
            'forte' => $this->getForte(),
            'symmetries' => $this->getSymmetries(),
            'isPalindromic' => $this->isPalindromic(),
            'hemitonics' => $this->getHemitonics(),
            'isHemitonic' => $this->isHemitonic(),
            'cohemitonics' => $this->getCohemitonics(),
            'isCohemitonic' => $this->isCohemitonic(),
            'tritonics' => $this->getTritonics(),
            'isTritonic' => $this->isTritonic(),
            'imperfections' => $this->getImperfections(),
            'modes' => $this->getModes(),
            'isPrime' => $this->isPrime(),
            'prime' => $this->getPrime(),
            'isChiral' => $this->isChiral(),
            'enantiomorph' => $this->getEnantiomorph(),
            'isDeep' => $this->isDeep(),
            'intervalVector' => $this->getIntervalVector(),
            'spectraVariation' => $this->getSpectraVariation(),
            'hasMyhill' => $this->hasMyhill(),
            'isCoherent' => $this->isCoherent(),
            'isHeliotonic' => $this->isHeliotonic(),
            'negative' => $this->getNegative(),
            'inverse' => $this->getInverse(),
            'neighbors' => $this->getNeighbors(),
            'isScale' => $this->isScale(),
            'normal' => $this->getNormal(),
            'intervalPattern' => $this->getIntervalPattern(),
            'distributionSpectra' => $this->getDistributionSpectra(),
            'isSymmetric' => $this->isSymmetric(),
            'isPalindromic' => $this->isPalindromic(),
            'isHeptatonic' => $this->isHeptatonic(),
        ];
    }

    protected function nullIfEmpty($result)
    {
        if (count($result) === 0)
        {
            return null;
        }

        return $result;
    }
}
