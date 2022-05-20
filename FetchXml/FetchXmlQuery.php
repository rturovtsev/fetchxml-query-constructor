<?php

namespace App\Model\FetchXml;

use App\Model\FetchXml\Traits\FetchXmlParamTrait;
use App\Model\FetchXml\Traits\FetchXmlTrait;
use Doctrine\Common\Collections\ArrayCollection;

class FetchXmlQuery
{
    use FetchXmlParamTrait;
    use FetchXmlTrait;

    /**
     * @var ArrayCollection
     */
    private $fetchXmlParam;

    /**
     * @var FetchXmlEntity
     */
    private $fetchXmlEntity;

    public function __construct(?array $param = [])
    {
        $this->fetchXmlParam = new ArrayCollection();

        if ($param) {
            foreach ($param as $key => $value) {
                $fetchParam = new FetchXmlParam($key, $value);
                $this->addFetchXmlParam($fetchParam);
            }
        }
    }

    /**
     * @return FetchXmlEntity
     */
    public function getFetchXmlEntity(): FetchXmlEntity
    {
        return $this->fetchXmlEntity;
    }

    /**
     * @param FetchXmlEntity $fetchXmlEntity
     * @return $this
     */
    public function setFetchXmlEntity(FetchXmlEntity $fetchXmlEntity): self
    {
        $this->fetchXmlEntity = $fetchXmlEntity;
        return $this;
    }


    public function createEntity(?array $param = []): FetchXmlEntity
    {
        $entity = new FetchXmlEntity($param);
        $this->setFetchXmlEntity($entity);

        return $entity;
    }


    public function create(): string
    {
        $str = "<fetch";

        $fetchParam = $this->arrayFetchXmlParamToString($this->getFetchXmlParam());
        if ($fetchParam) {
            $str .= " " . $fetchParam . ">";
        } else {
            $str .= ">";
        }

        return $str . $this->getFetchXmlEntity()->create() . "</fetch>";

    }


}