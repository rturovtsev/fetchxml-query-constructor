<?php

namespace App\Model\FetchXml\Traits;

use App\Model\FetchXml\FetchXmlFilter;
use Doctrine\Common\Collections\ArrayCollection;

trait FetchXmlFilterTrait
{
    /**
     * @return ArrayCollection
     */
    public function getFetchXmlFilter(): ArrayCollection
    {
        return $this->fetchXmlFilter;
    }

    /**
     * @param ArrayCollection $fetchXmlFilter
     * @return $this
     */
    public function setFetchXmlFilter(ArrayCollection $fetchXmlFilter): self
    {
        $this->fetchXmlFilter = $fetchXmlFilter;
        return $this;
    }

    /**
     * @param FetchXmlFilter $fetchXmlFilter
     * @return $this
     */
    public function addFetchFilter(FetchXmlFilter $fetchXmlFilter): self
    {
        if (!$this->fetchXmlFilter->contains($fetchXmlFilter)) {
            $this->fetchXmlFilter[] = $fetchXmlFilter;
        }

        return $this;
    }

    /**
     * @param FetchXmlFilter $fetchXmlFilter
     * @return $this
     */
    public function removeFetchXmlFilter(FetchXmlFilter $fetchXmlFilter): self
    {
        if ($this->fetchXmlFilter->contains($fetchXmlFilter)) {
            $this->fetchXmlFilter->removeElement($fetchXmlFilter);
        }

        return $this;
    }
}