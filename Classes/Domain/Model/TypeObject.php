<?php
namespace mhdev\MhDirectory\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
 
class TypeObject extends AbstractEntity {

    /**
     * Title for internal use
     *
     * @var string
     */
    protected $name;
    
    /**
     * price
     *
     * @var string
     */
    protected $price;
    
    /**
     * options
     *
     * @var string
     */
    protected $options;
    
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
     * sorting
     *
     * @var int
     */
    protected $sorting;



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
     * Gets the price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the price.
     *
     * @param string $price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Gets the options.
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the options.
     *
     * @param string options
     *
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = $options;

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
     * Set the sorting.
     *
     * @param int $sorting
     *
     * @return self
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;

        return $this;
    }

    /**
     * Gets the sorting.
     *
     * @return int
     */
    public function getSorting()
    {
        return $this->sorting;
    }


}