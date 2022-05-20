<?php

namespace App\Model\FetchXml;

use App\Model\FetchXml\Traits\FetchXmlParamTrait;
use App\Model\FetchXml\Traits\FetchXmlTrait;
use Doctrine\Common\Collections\ArrayCollection;

class FetchXmlCondition
{
    use FetchXmlParamTrait;
    use FetchXmlTrait;

    /**
     * @var ArrayCollection
     */
    private $fetchXmlParam;

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


    public function create(): string
    {
        $str = "<condition";
        $fetchParam = $this->arrayFetchXmlParamToString($this->getFetchXmlParam());
        if ($fetchParam) {
            $str .= " " . $fetchParam . " />";
        } else {
            $str .= " />";
        }

        return $str;
    }
}