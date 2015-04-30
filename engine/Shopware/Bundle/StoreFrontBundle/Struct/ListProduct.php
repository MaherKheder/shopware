<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace Shopware\Bundle\StoreFrontBundle\Struct;

use Shopware\Bundle\StoreFrontBundle\Struct\Product\Esd;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\Manufacturer;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\Price;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\PriceGroup;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\PriceRule;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\Unit;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\VoteAverage;

/**
 * @category  Shopware
 * @package   Shopware\Bundle\StoreFrontBundle\Struct
 * @copyright Copyright (c) shopware AG (http://www.shopware.de)
 */
class ListProduct extends BaseProduct implements \JsonSerializable
{
    /**
     * State for a calculated product price
     */
    const STATE_PRICE_CALCULATED = 'price_calculated';

    /**
     * Contains the product name.
     *
     * @var string
     */
    protected $name;

    /**
     * Stock value of the product.
     * Displays how many unit are left in the stock.
     *
     * @var int
     */
    protected $stock;

    /**
     * Short description of the product.
     * Describes the product in one or two sentences.
     *
     * @var string
     */
    protected $shortDescription;

    /**
     * A long description of the product.
     *
     * @var string
     */
    protected $longDescription;

    /**
     * Defines the date when the product was released / will be
     * released and can be ordered.
     *
     * @var \DateTime
     */
    protected $releaseDate;

    /**
     * Defines the required time in days to deliver the product.
     *
     * @var int
     */
    protected $shippingTime;

    /**
     * Defines if the product has no shipping costs.
     *
     * @var boolean
     */
    protected $shippingFree;

    /**
     * Defines that the product are no longer
     * available if the last item is sold.
     *
     * @var boolean
     */
    protected $closeouts;

    /**
     * Contains a flag if the product has properties.
     * @var boolean
     */
    protected $hasProperties = false;

    /**
     * Defines the date which the product was created in the
     * database.
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Defines a list of keywords for this product.
     *
     * @var array
     */
    protected $keywords;

    /**
     * Defines the meta title of the product.
     * This title is used for the title tag within the header.
     *
     * @var string
     */
    protected $metaTitle;

    /**
     * Defines if the customer can be set an email
     * notification for this product if it is sold out.
     *
     * @var boolean
     */
    protected $allowsNotification;

    /**
     * Additional information text for the product variation.
     *
     * @var string
     */
    protected $additional;

    /**
     * Minimal stock value for the product.
     * @var int
     */
    protected $minStock;

    /**
     * Physical height of the product.
     * Used for area calculation.
     * @var float
     */
    protected $height;

    /**
     * Physical width of the product.
     * Used for area calculation.
     * @var float
     */
    protected $width;

    /**
     * Physical length of the product.
     * Used for area calculation.
     *
     * @var float
     */
    protected $length;

    /**
     * Physical width of the product.
     * Used for area calculation.
     * @var float
     */
    protected $weight;

    /**
     * Ean code of the product.
     * @var string
     */
    protected $ean;

    /**
     * Flag if the product should be displayed
     * with a teaser flag within listings.
     *
     * @var float
     */
    protected $highlight;

    /**
     * @var int
     */
    protected $sales;

    /**
     * @var bool
     */
    protected $hasConfigurator;

    /**
     * @var bool
     */
    protected $hasEsd;

    /**
     * @var bool
     */
    protected $isPriceGroupActive;

    /**
     * @var array
     */
    protected $blockedCustomerGroupIds = [];

    /**
     * @var string
     */
    protected $manufacturerNumber;

    /**
     * @var string
     */
    protected $template;

    /**
     * Contains the absolute cheapest price of each product variation.
     * This price is calculated over the shopware price service
     * getCheapestPrice function.
     *
     * @var Price
     */
    protected $cheapestPrice;

    /**
     * Contains the price rule for the cheapest price.
     *
     * @var PriceRule
     */
    protected $cheapestPriceRule;

    /**
     * Contains the cheapest unit price of each product variation.
     *
     * @var Price
     */
    protected $cheapestUnitPrice;

    /**
     * @var PriceRule[]
     */
    protected $priceRules = [];

    /**
     * Price of the current variant.
     * @var Price[]
     */
    protected $prices = [];

    /**
     * @var Unit
     */
    protected $unit;

    /**
     * @var Tax
     */
    protected $tax;

    /**
     * @var Manufacturer
     */
    protected $manufacturer;

    /**
     * Contains the product cover which displayed
     * as product image in listings or sliders.
     *
     * @var Media
     */
    protected $cover;

    /**
     * @var PriceGroup
     */
    protected $priceGroup;

    /**
     * Contains an offset of product states.
     * States defines which processed the product has already passed through,
     * like the price calculation, translation or other states.
     *
     * @var array
     */
    protected $states = [];

    /**
     * @var Esd
     */
    protected $esd;

    /**
     * @var VoteAverage
     */
    protected $voteAverage;

    /**
     * Flag if the product has an available variant
     * @var boolean
     */
    protected $hasAvailableVariant;

    /**
     * Adds a new product state.
     *
     * @param $state
     */
    public function addState($state)
    {
        $this->states[] = $state;
    }

    /**
     * @return array
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * Checks if the product has a specify state
     * @param $state
     * @return bool
     */
    public function hasState($state)
    {
        return in_array($state, $this->states);
    }

    /**
     * @return boolean
     */
    public function hasProperties()
    {
        return $this->hasProperties;
    }

    /**
     * @return boolean
     */
    public function isShippingFree()
    {
        return $this->shippingFree;
    }

    /**
     * @return boolean
     */
    public function allowsNotification()
    {
        return $this->allowsNotification;
    }

    /**
     * @return boolean
     */
    public function highlight()
    {
        return $this->highlight;
    }

    /**
     * @param boolean $highlight
     */
    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;
    }

    /**
     * @param boolean $allowsNotification
     */
    public function setAllowsNotification($allowsNotification)
    {
        $this->allowsNotification = $allowsNotification;
    }

    /**
     * @param boolean $shippingFree
     */
    public function setShippingFree($shippingFree)
    {
        $this->shippingFree = $shippingFree;
    }

    /**
     * @param Unit $unit
     */
    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param \Shopware\Bundle\StoreFrontBundle\Struct\Tax $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return \Shopware\Bundle\StoreFrontBundle\Struct\Tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param \Shopware\Bundle\StoreFrontBundle\Struct\Product\Price[] $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }

    /**
     * @return \Shopware\Bundle\StoreFrontBundle\Struct\Product\Price[]
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param \Shopware\Bundle\StoreFrontBundle\Struct\Product\Manufacturer $manufacturer
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return \Shopware\Bundle\StoreFrontBundle\Struct\Product\Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param \Shopware\Bundle\StoreFrontBundle\Struct\Media $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return \Shopware\Bundle\StoreFrontBundle\Struct\Media
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param \Shopware\Bundle\StoreFrontBundle\Struct\Product\Price $cheapestPrice
     */
    public function setCheapestPrice($cheapestPrice)
    {
        $this->cheapestPrice = $cheapestPrice;
    }

    /**
     * @return \Shopware\Bundle\StoreFrontBundle\Struct\Product\Price
     */
    public function getCheapestPrice()
    {
        return $this->cheapestPrice;
    }

    /**
     * @return \Shopware\Bundle\StoreFrontBundle\Struct\Product\Price
     */
    public function getVariantPrice()
    {
        return $this->prices[0];
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $additional
     */
    public function setAdditional($additional)
    {
        $this->additional = $additional;
    }

    /**
     * @return string
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * @param boolean $closeouts
     */
    public function setCloseouts($closeouts)
    {
        $this->closeouts = $closeouts;
    }

    /**
     * @return boolean
     */
    public function isCloseouts()
    {
        return $this->closeouts;
    }

    /**
     * @param string $ean
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
    }

    /**
     * @return string
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param array $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param float $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param string $longDescription
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @param int $minStock
     */
    public function setMinStock($minStock)
    {
        $this->minStock = $minStock;
    }

    /**
     * @return int
     */
    public function getMinStock()
    {
        return $this->minStock;
    }

    /**
     * @param \DateTime $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param int $shippingTime
     */
    public function setShippingTime($shippingTime)
    {
        $this->shippingTime = $shippingTime;
    }

    /**
     * @return int
     */
    public function getShippingTime()
    {
        return $this->shippingTime;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return bool
     */
    public function isAvailable()
    {
        if (!$this->isCloseouts()) {
            return true;
        }

        return $this->getStock() >= $this->getUnit()->getMinPurchase();
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param boolean $hasProperties
     */
    public function setHasProperties($hasProperties)
    {
        $this->hasProperties = $hasProperties;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return PriceGroup
     */
    public function getPriceGroup()
    {
        return $this->priceGroup;
    }

    /**
     * @param \Shopware\Bundle\StoreFrontBundle\Struct\Product\PriceGroup $priceGroup
     */
    public function setPriceGroup(PriceGroup $priceGroup)
    {
        $this->priceGroup = $priceGroup;
    }

    /**
     * @return \Shopware\Bundle\StoreFrontBundle\Struct\Product\PriceRule[]
     */
    public function getPriceRules()
    {
        return $this->priceRules;
    }

    /**
     * @param \Shopware\Bundle\StoreFrontBundle\Struct\Product\PriceRule[] $priceRules
     */
    public function setPriceRules($priceRules)
    {
        $this->priceRules = $priceRules;
    }

    /**
     * @return \Shopware\Bundle\StoreFrontBundle\Struct\Product\PriceRule
     */
    public function getCheapestPriceRule()
    {
        return $this->cheapestPriceRule;
    }

    /**
     * @param \Shopware\Bundle\StoreFrontBundle\Struct\Product\PriceRule $cheapestPriceRule
     */
    public function setCheapestPriceRule($cheapestPriceRule)
    {
        $this->cheapestPriceRule = $cheapestPriceRule;
    }

    /**
     * @return string
     */
    public function getManufacturerNumber()
    {
        return $this->manufacturerNumber;
    }

    /**
     * @param string $manufacturerNumber
     */
    public function setManufacturerNumber($manufacturerNumber)
    {
        $this->manufacturerNumber = $manufacturerNumber;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * @return boolean
     */
    public function hasConfigurator()
    {
        return $this->hasConfigurator;
    }

    /**
     * @param boolean $hasConfigurator
     */
    public function setHasConfigurator($hasConfigurator)
    {
        $this->hasConfigurator = $hasConfigurator;
    }

    /**
     * @return int
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @param int $sales
     */
    public function setSales($sales)
    {
        $this->sales = $sales;
    }

    /**
     * @return boolean
     */
    public function hasEsd()
    {
        return $this->hasEsd;
    }

    /**
     * @param boolean $hasEsd
     */
    public function setHasEsd($hasEsd)
    {
        $this->hasEsd = $hasEsd;
    }

    /**
     * @return Esd
     */
    public function getEsd()
    {
        return $this->esd;
    }

    /**
     * @param Esd $esd
     */
    public function setEsd(Esd $esd)
    {
        $this->esd = $esd;
    }

    /**
     * @return boolean
     */
    public function isPriceGroupActive()
    {
        return $this->isPriceGroupActive;
    }

    /**
     * @param boolean $isPriceGroupActive
     */
    public function setIsPriceGroupActive($isPriceGroupActive)
    {
        $this->isPriceGroupActive = $isPriceGroupActive;
    }

    /**
     * @return array
     */
    public function getBlockedCustomerGroupIds()
    {
        return $this->blockedCustomerGroupIds;
    }

    /**
     * @param array $blockedCustomerGroupIds
     */
    public function setBlockedCustomerGroupIds($blockedCustomerGroupIds)
    {
        $this->blockedCustomerGroupIds = $blockedCustomerGroupIds;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return \Shopware\Bundle\StoreFrontBundle\Struct\Product\VoteAverage
     */
    public function getVoteAverage()
    {
        return $this->voteAverage;
    }

    /**
     * @param \Shopware\Bundle\StoreFrontBundle\Struct\Product\VoteAverage $voteAverage
     */
    public function setVoteAverage($voteAverage)
    {
        $this->voteAverage = $voteAverage;
    }

    /**
     * @return boolean
     */
    public function hasAvailableVariant()
    {
        return $this->hasAvailableVariant;
    }

    /**
     * @param boolean $hasAvailableVariant
     */
    public function setHasAvailableVariant($hasAvailableVariant)
    {
        $this->hasAvailableVariant = $hasAvailableVariant;
    }

    /**
     * @return Price
     */
    public function getCheapestUnitPrice()
    {
        return $this->cheapestUnitPrice;
    }

    /**
     * @param Price $cheapestUnitPrice
     */
    public function setCheapestUnitPrice($cheapestUnitPrice)
    {
        $this->cheapestUnitPrice = $cheapestUnitPrice;
    }
}