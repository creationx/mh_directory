<?php
namespace mhdev\MhDirectory\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
 
class CityObject extends AbstractEntity {

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\mhdev\MhDirectory\Domain\Model\District>
     */
    protected $relationDistrict;

    /**
     * Title for internal use
     *
     * @var string
     */
    protected $name;
    
    /**
     * map_lng
     *
     * @var string
     */
    protected $mapLng;
    
    /**
     * map_lat
     *
     * @var string
     */
    protected $mapLat;
    
    /**
     * image
     *
     * @var string
     */
    protected $image;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * count_clicks
     *
     * @var int
     */
    protected $countClicks;

    /**
     * count_views
     *
     * @var int
     */
    protected $countViews;


    public function __construct() {
        $this->initializeObjectStorages();
    }
 
    /**
     * initialize object storages
     */
    public function initializeObjectStorages() {
        $this->relationDistrict = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * Gets the relation
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\mhdev\MhDirectory\Domain\Model\District>
     */
    public function getRelationDistrict()
    {
        $this->relationDistrict->rewind();
        if($this->relationDistrict->valid()) {
            return $this->relationDistrict->current();
        }
        return $this->relationDistrict;
    }    


    /**
     * Gets the Title for internal use.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the Title for internal use.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the map_lng.
     *
     * @return string
     */
    public function getMapLng()
    {
        return $this->mapLng;
    }

    /**
     * Sets the map_lng.
     *
     * @param string $map_lng the map_lng
     *
     * @return self
     */
    public function setMapLng($map_lng)
    {
        $this->mapLng = $map_lng;

        return $this;
    }

    /**
     * Gets the map_lat.
     *
     * @return string
     */
    public function getMapLat()
    {
        return $this->mapLat;
    }

    /**
     * Sets the map_lat.
     *
     * @param string $map_lat the map_lat
     *
     * @return self
     */
    public function setMapLat($map_lat)
    {
        $this->mapLat = $map_lat;

        return $this;
    }

    /**
     * Gets the image.
     *
     * @return array
     */
    public function getImage()
    {
        return $this->image;

        if(empty($this->image))
            return false;

        $aImageArray = explode(',', $this->image);
        return $aImageArray;
    }

    /**
     * Sets the image.
     *
     * @param string $image the image
     *
     * @return self
     */
    public function setImage(blob $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Gets the description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description.
     *
     * @param string $description the description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets the count_clicks.
     *
     * @return int
     */
    public function getCountClicks()
    {
        return $this->countClicks;
    }

    /**
     * Sets the count_clicks.
     *
     * @param int $count_clicks the count_clicks
     *
     * @return self
     */
    public function setCountClicks($count_clicks)
    {
        $this->countClicks = $count_clicks;

        return $this;
    }

    /**
     * Gets the count_views.
     *
     * @return int
     */
    public function getCountViews()
    {
        return $this->countViews;
    }

    /**
     * Sets the count_views.
     *
     * @param int $count_views the count_views
     *
     * @return self
     */
    public function setCountViews($count_views)
    {
        $this->countViews = $count_views;

        return $this;
    }

    /**
     * Sets the value of relationDistrict.
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\mhdev\MhDirectory\Domain\Model\District> $relationDistrict the relation district
     *
     * @return self
     */
    public function setRelationDistrict(District $relationDistrict)
    {
        $this->relationDistrict = $relationDistrict;

        return $this;
    }
}