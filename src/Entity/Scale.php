<?php
namespace App\Entity;

use JsonSerializable;

class Scale implements JsonSerializable
{
    protected $scale;
    protected $pcSet;

    public function __construct(int $scale)
    {
        $this->scale = new \ianring\Scale($scale, 'C');
        $this->pcSet = new \ianring\PitchClassSet($this->scale->scale);
    }

    public function id()
    {
        return $this->scale->scale;
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
        return $this->pcSet->spectrum();
    }
    
    public function getEnantiomorph()
    {
        if ($this->isChiral()) {
            return $this->scale->enantiomorph()->scale;
        }

        return null;
    }

    public function getForte()
    {
        return $this->pcSet->forteNumber();
    }

    public function getImperfections()
    {
        return $this->nullIfEmpty($this->scale->imperfections());
    }

    public function getIntervalPattern()
    {
        if ($this->scale->hasRootTone()) {
            return $this->scale->intervalPattern();
        } else {
            $original = $this->scale->scale;
            $this->scale->scale = $this->getNormal();
            $pattern = $this->scale->intervalPattern();
            $this->scale->scale = $original;

            return $pattern;
        }
    }

    public function getInverse()
    {
        $original = $this->scale->scale;
        $this->scale->invert();
        $inverse = $this->scale->scale;
        $this->scale->scale = $original;

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
        return $this->scale->neighbours();
    }

    public function getNormal()
    {
        if ($this->isScale()) {
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
        return $this->pcSet->spectraVariation();
    }

    public function getSymmetries()
    {
        return $this->nullIfEmpty($this->scale->symmetries());
    }

    public function getTones()
    {
        return $this->scale->getTones();
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
        return $this->pcSet->isCoherent();
    }

    public function isDeep()
    {
        return $this->pcSet->isDeepScale();
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
        return $this->pcSet->hasMyhillProperty();
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
        if (count($result) === 0) {
            return null;
        }

        return $result;
    }
}
