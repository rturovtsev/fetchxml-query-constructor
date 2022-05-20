<?php

namespace App\Model\FetchXml;

use App\Model\FetchXml\Traits\FetchXmlParamTrait;
use App\Model\FetchXml\Traits\FetchXmlTrait;
use Doctrine\Common\Collections\ArrayCollection;

class FetchXmlFilter
{
    use FetchXmlParamTrait;
    use FetchXmlTrait;

    /**
     * @var ArrayCollection
     */
    private $fetchXmlParam;

    /**
     * @var ArrayCollection
     */
    private $fetchXmlCondition;

    public function __construct(?array $param = [])
    {
        $this->fetchXmlParam = new ArrayCollection();
        $this->fetchXmlCondition = new ArrayCollection();

        if ($param) {
            foreach ($param as $key => $value) {
                $fetchParam = new FetchXmlParam($key, $value);
                $this->addFetchXmlParam($fetchParam);
            }
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getFetchXmlCondition(): ArrayCollection
    {
        return $this->fetchXmlCondition;
    }

    /**
     * @param ArrayCollection $fetchXmlCondition
     * @return $this
     */
    public function setFetchXmlCondition(ArrayCollection $fetchXmlCondition): self
    {
        $this->fetchXmlCondition = $fetchXmlCondition;
        return $this;
    }

    /**
     * @param FetchXmlCondition $fetchXmlCondition
     * @return $this
     */
    public function addFetchXmlCondition(FetchXmlCondition $fetchXmlCondition): self
    {
        if (!$this->fetchXmlCondition->contains($fetchXmlCondition)) {
            $this->fetchXmlCondition[] = $fetchXmlCondition;
        }

        return $this;
    }

    /**
     * @param FetchXmlCondition $fetchXmlCondition
     * @return $this
     */
    public function removeFetchXmlCondition(FetchXmlCondition $fetchXmlCondition): self
    {
        if ($this->fetchXmlCondition->contains($fetchXmlCondition)) {
            $this->fetchXmlCondition->removeElement($fetchXmlCondition);
        }

        return $this;
    }


    public function create(): string
    {
        $str = "<filter";

        $fetchParam = $this->arrayFetchXmlParamToString($this->getFetchXmlParam());
        if ($fetchParam) {
            $str .= " " . $fetchParam . ">";
        } else {
            $str .= ">";
        }

        foreach ($this->getFetchXmlCondition() as $condition) {
            $str .= $condition->create();
        }

        return $str . "</filter>";
    }
}