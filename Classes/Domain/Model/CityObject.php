<?php
namespace mhdev\MhDirectory\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
 
class CityObject extends AbstractEntity {

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\mhdev\MhDirectory\Domain\Model\District>
     */
    protected $relation_district;

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
    protected $map_lng;
    
    /**
     * map_lat
     *
     * @var string
     */
    protected $map_lat;
    
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
    protected $count_clicks;

    /**
     * count_views
     *
     * @var int
     */
    protected $count_views;


    public function __construct() {
        $this->initalizeObjectStorages();
    }
 
    /**
     * initialize object storages
     */
    public function initializeObjectStorages() {
        $this->relation_district = new ObjectStorage();
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
    public function getMap_lng()
    {
        return $this->map_lng;
    }

    /**
     * Sets the map_lng.
     *
     * @param string $map_lng the map_lng
     *
     * @return self
     */
    public function setMap_lng($map_lng)
    {
        $this->map_lng = $map_lng;

        return $this;
    }

    /**
     * Gets the map_lat.
     *
     * @return string
     */
    public function getMap_lat()
    {
        return $this->map_lat;
    }

    /**
     * Sets the map_lat.
     *
     * @param string $map_lat the map_lat
     *
     * @return self
     */
    public function setMap_lat($map_lat)
    {
        $this->map_lat = $map_lat;

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
    public function getCount_clicks()
    {
        return $this->count_clicks;
    }

    /**
     * Sets the count_clicks.
     *
     * @param int $count_clicks the count_clicks
     *
     * @return self
     */
    public function setCount_clicks($count_clicks)
    {
        $this->count_clicks = $count_clicks;

        return $this;
    }

    /**
     * Gets the count_views.
     *
     * @return int
     */
    public function getCount_views()
    {
        return $this->count_views;
    }

    /**
     * Sets the count_views.
     *
     * @param int $count_views the count_views
     *
     * @return self
     */
    public function setCount_views($count_views)
    {
        $this->count_views = $count_views;

        return $this;
    }
}