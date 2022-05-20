<?php

namespace App\Model\FetchXml;

use App\Model\FetchXml\Traits\FetchXmlFilterTrait;
use App\Model\FetchXml\Traits\FetchXmlParamTrait;
use App\Model\FetchXml\Traits\FetchXmlTrait;
use Doctrine\Common\Collections\ArrayCollection;

class FetchXmlLinkEntity
{
    use FetchXmlParamTrait;
    use FetchXmlFilterTrait;
    use FetchXmlTrait;

    /**
     * @var ArrayCollection
     */
    private $fetchXmlParam;

    /**
     * @var ArrayCollection
     */
    private $fetchXmlFilter;

    /**
     * @var ArrayCollection
     */
    private $fetchXmlAttribute;

    public function __construct(?array $param = [])
    {
        $this->fetchXmlParam = new ArrayCollection();
        $this->fetchXmlAttribute = new ArrayCollection();
        $this->fetchXmlFilter = new ArrayCollection();

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
    public function getFetchXmlAttribute(): ArrayCollection
    {
        return $this->fetchXmlAttribute;
    }

    /**
     * @param ArrayCollection $fetchXmlAttribute
     * @return $this
     */
    public function setFetchXmlAttribute(ArrayCollection $fetchXmlAttribute): self
    {
        $this->fetchXmlAttribute = $fetchXmlAttribute;
        return $this;
    }

    /**
     * @param FetchXmlAttribute $fetchXmlAttribute
     * @return $this
     */
    public function addFetchXmlAttribute(FetchXmlAttribute $fetchXmlAttribute): self
    {
        if (!$this->fetchXmlAttribute->contains($fetchXmlAttribute)) {
            $this->fetchXmlAttribute[] = $fetchXmlAttribute;
        }

        return $this;
    }

    /**
     * @param FetchXmlAttribute $fetchXmlAttribute
     * @return $this
     */
    public function removeFetchXmlAttribute(FetchXmlAttribute $fetchXmlAttribute): self
    {
        if ($this->fetchXmlAttribute->contains($fetchXmlAttribute)) {
            $this->fetchXmlAttribute->removeElement($fetchXmlAttribute);
        }

        return $this;
    }

    public function addAttributeByName(?string $name): self
    {
        $attr = new FetchXmlAttribute(['name' => $name]);
        $this->addFetchXmlAttribute($attr);
        return $this;
    }


    public function addAttributesByName(?array $attrArray): self
    {
        foreach ($attrArray as $name) {
            $attr = new FetchXmlAttribute(['name' => $name]);
            $this->addFetchXmlAttribute($attr);
        }

        return $this;
    }


    public function createFilter(?array $param = []): FetchXmlFilter
    {
        $filter = new FetchXmlFilter($param);
        $this->addFetchFilter($filter);

        return $filter;
    }


    public function create(): string
    {
        $str = "<link-entity";

        $entityParam = $this->arrayFetchXmlParamToString($this->getFetchXmlParam());
        if ($entityParam) {
            $str .= " " . $entityParam . ">";
        } else {
            $str .= ">";
        }

        foreach ($this->getFetchXmlAttribute() as $attribute) {
            $str .= $attribute->create();
        }

        foreach ($this->getFetchXmlFilter() as $filter) {
            $str .= $filter->create();
        }

        return $str . "</link-entity>";
    }
}