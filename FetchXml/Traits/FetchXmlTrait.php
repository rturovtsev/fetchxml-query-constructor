<?php

namespace App\Model\FetchXml\Traits;

use App\Model\FetchXml\FetchXmlParam;
use Doctrine\Common\Collections\ArrayCollection;

trait FetchXmlTrait
{
    private function arrayFetchXmlParamToString(ArrayCollection $array): string {
        $tmp = [];

        foreach ($array as $item) {
            /** @var FetchXmlParam $item */
            $tmp[] = $item->getName() . '="' . $item->getValue() . '"';
        }

        return implode(' ', $tmp);
    }
}