<?php

namespace App\Model\FetchXml;

use App\Model\FetchXml\Traits\FetchXmlFilterTrait;
use App\Model\FetchXml\Traits\FetchXmlParamTrait;
use App\Model\FetchXml\Traits\FetchXmlTrait;
use Doctrine\Common\Collections\ArrayCollection;

class FetchXmlEntity
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

    /**
     * @var ArrayCollection
     */
    private $fetchXmlLinkEntity;

    public function __construct(?array $param = [])
    {
        $this->fetchXmlParam = new ArrayCollection();
        $this->fetchXmlFilter = new ArrayCollection();
        $this->fetchXmlAttribute = new ArrayCollection();
        $this->fetchXmlLinkEntity = new ArrayCollection();

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

    /**
     * @return ArrayCollection
     */
    public function getFetchXmlLinkEntity(): ArrayCollection
    {
        return $this->fetchXmlLinkEntity;
    }

    /**
     * @param ArrayCollection $fetchXmlLinkEntity
     * @return $this
     */
    public function setFetchLinkEntity(ArrayCollection $fetchXmlLinkEntity): self
    {
        $this->fetchXmlLinkEntity = $fetchXmlLinkEntity;
        return $this;
    }

    /**
     * @param FetchXmlLinkEntity $fetchXmlLinkEntity
     * @return $this
     */
    public function addFetchXmlLinkEntity(FetchXmlLinkEntity $fetchXmlLinkEntity): self
    {
        if (!$this->fetchXmlLinkEntity->contains($fetchXmlLinkEntity)) {
            $this->fetchXmlLinkEntity[] = $fetchXmlLinkEntity;
        }

        return $this;
    }

    /**
     * @param FetchXmlLinkEntity $fetchXmlLinkEntity
     * @return $this
     */
    public function removeFetchXmlLinkEntity(FetchXmlLinkEntity $fetchXmlLinkEntity): self
    {
        if ($this->fetchXmlLinkEntity->contains($fetchXmlLinkEntity)) {
            $this->fetchXmlLinkEntity->removeElement($fetchXmlLinkEntity);
        }

        return $this;
    }


    public function createFilter(?array $param = []): FetchXmlFilter
    {
        $filter = new FetchXmlFilter($param);
        $this->addFetchFilter($filter);

        return $filter;
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


    public function create(): string
    {
        $str = "<entity";

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

        foreach ($this->getFetchXmlLinkEntity() as $linkEntity) {
            $str .= $linkEntity->create();
        }

        return $str . "</entity>";
    }
}