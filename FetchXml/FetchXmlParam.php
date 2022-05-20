<?php

namespace App\Model\FetchXml;

class FetchXmlParam
{
    public function __construct(?string $name, ?string $value)
    {
        if ($name) {
            $this->name = $name;
        }
        if ($value) {
            $this->value = $value;
        }
    }

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $value;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }
}