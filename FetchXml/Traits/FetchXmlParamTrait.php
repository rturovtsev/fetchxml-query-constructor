<?php

namespace App\Model\FetchXml\Traits;

use App\Model\FetchXml\FetchXmlParam;
use Doctrine\Common\Collections\ArrayCollection;

trait FetchXmlParamTrait
{
    /**
     * @return ArrayCollection
     */
    public function getFetchXmlParam(): ArrayCollection
    {
        return $this->fetchXmlParam;
    }

    /**
     * @param ArrayCollection $fetchXmlParam
     * @return $this
     */
    public function setFetchXmlParam(ArrayCollection $fetchXmlParam): self
    {
        $this->fetchXmlParam = $fetchXmlParam;
        return $this;
    }

    /**
     * @param FetchXmlParam $fetchXmlParam
     * @return $this
     */
    public function addFetchXmlParam(FetchXmlParam $fetchXmlParam): self
    {
        if (!$this->fetchXmlParam->contains($fetchXmlParam)) {
            $this->fetchXmlParam[] = $fetchXmlParam;
        }

        return $this;
    }

    /**
     * @param FetchXmlParam $fetchXmlParam
     * @return $this
     */
    public function removeFetchXmlParam(FetchXmlParam $fetchXmlParam): self
    {
        if ($this->fetchXmlParam->contains($fetchXmlParam)) {
            $this->fetchXmlParam->removeElement($fetchXmlParam);
        }

        return $this;
    }
}