<?php

namespace app\modules\SertificateFill;

class SertificateFillExcelRow
{
    /** @var array */
    private $row;

    /**
     * @param array $excelRow
     */
    public function __construct($excelRow)
    {
        $this->row = $excelRow;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return "{$this->getFirstName()} {$this->getLastName()} {$this->getMiddleName()}";
    }

    /**
     * @return string|null
     */
    public function getFirstName()
    {
        return isset($this->row[0]) ? (string)$this->row[0] : null;
    }

    /**
     * @return string|null
     */
    public function getLastName()
    {
        return isset($this->row[1]) ? (string)$this->row[1] : null;
    }

    /**
     * @return string|null
     */
    public function getMiddleName()
    {
        return isset($this->row[2]) ? (string)$this->row[2] : null;
    }
}
