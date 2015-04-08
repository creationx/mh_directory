<?php
namespace mhdev\MhDirectory\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class BackendObject extends AbstractEntity {
	 /**
     * serialized array for relations
     *
     * @var string
     */
    protected $relationsFederal;

    /**
     * serialized array for relations
     *
     * @var string
     */
    protected $relationsAdministrative;

    /**
     * serialized array for relations
     *
     * @var string
     */
    protected $relationsCities;

    /**
     * serialized array for relations
     *
     * @var string
     */
    protected $relationsEntries;

    /**
     * status
     *
     * @var string
     */
    protected $importStatus;

    /**
     * finished
     *
     * @var int
     */
    protected $finished;

    /**
     * timestamp created
     *
     * @var int
     */
    protected $tstamp;



    /**
     * Gets the serialized array for relations.
     *
     * @return string
     */
    public function getRelationsFederal()
    {
        return $this->relationsFederal;
    }

    /**
     * Sets the serialized array for relations.
     *
     * @param string $relationsFederal the relations federal
     *
     * @return self
     */
    public function setRelationsFederal($relationsFederal)
    {
        $this->relationsFederal = $relationsFederal;

        return $this;
    }

    /**
     * Gets the serialized array for relations.
     *
     * @return string
     */
    public function getRelationsAdministrative()
    {
        return $this->relationsAdministrative;
    }

    /**
     * Sets the serialized array for relations.
     *
     * @param string $relationsAdministrative the relations administrative
     *
     * @return self
     */
    public function setRelationsAdministrative($relationsAdministrative)
    {
        $this->relationsAdministrative = $relationsAdministrative;

        return $this;
    }

    /**
     * Gets the serialized array for relations.
     *
     * @return string
     */
    public function getRelationsCities()
    {
        return $this->relationsCities;
    }

    /**
     * Sets the serialized array for relations.
     *
     * @param string $relationsCities the relations cities
     *
     * @return self
     */
    public function setRelationsCities($relationsCities)
    {
        $this->relationsCities = $relationsCities;

        return $this;
    }
    
    /**
     * Gets the serialized array for relations.
     *
     * @return string
     */
    public function getRelationsEntries()
    {
        return $this->relationsEntries;
    }

    /**
     * Sets the serialized array for relations.
     *
     * @param string $relationsEntries the relations Entries
     *
     * @return self
     */
    public function setRelationsEntries($relationsEntries)
    {
        $this->relationsEntries = $relationsEntries;

        return $this;
    }

    /**
     * Gets the status.
     *
     * @return string
     */
    public function getImportStatus()
    {
        return $this->importStatus;
    }

    /**
     * Sets the status.
     *
     * @param string $importStatus the import status
     *
     * @return self
     */
    public function setImportStatus($importStatus)
    {
        $this->importStatus = $importStatus;

        return $this;
    }

    /**
     * Gets the finished.
     *
     * @return int
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * Sets the finished.
     *
     * @param int $finished the finished
     *
     * @return self
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Gets the timestamp created.
     *
     * @return int
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Sets the timestamp created.
     *
     * @param int $tstamp the tstamp
     *
     * @return self
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;

        return $this;
    }
}