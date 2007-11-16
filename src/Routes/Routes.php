<?php
/**
 * Routes package.
 *
 * PHP version 5.
 *
 * @version   @VERSION@
 * @category  Backend
 * @package   Routes
 * @author    @VICTOR@
 * @copyright @COPYRIGHT@
 * @license   @LICENSE@
 * @link      @PACKAGES_URL@/@PACKAGE_NAME@
 */

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

require_once 'PEAR.php';
require_once 'Routes/Item.php';

/**
 * Routing map class.
 *
 * See RoR Routes.
 *
 * @version  @VERSION@
 * @category Backend
 * @package  Routes
 * @author   @VICTOR@
 * @license  @LICENSE@
 * @link     @PACKAGES_URL@/@PACKAGE_NAME@
 */
class Backend_Routes
{
    /**
     * Routing map elements.
     * @var array
     */
    private $items = array();

    /**
     * Factory method to create routing map item.
     *
     * @return object Instance of Backend_RoutesItem or subclass.
     */
    public function create()
    {
        return new Backend_Routes_Item();
    }

    /**
     * Creates (optionnaly), adds and returns new item.
     *
     * @param object $item New item (must be subclass of Backend_RoutesItem). If null, item is created by calling ::create().
     *
     * @return object Created/passed item.
     */
    function add($item = null)
    {
        if (is_object($item)) {
            $this->items[] = &$item;
        } else if (is_array($item)) {
            $this->items = array_merge($this->items, $item);
        } else if (!$item) {
            $item = &$this->create();

            $this->items[] = &$item;
        }

        return $item;
    }
   
    /**
     * Finds element in routing map.
     *
     * @param string $url      URL.
     * @param array  &$matches Url parts matching regular expression.
     * @param array  $args     Array of condition values.
     *
     * @return Element object or false if element not found.
     */
    function find($url, &$matches = null, $args = array())
    {       
        foreach ($this->items as $item) {
            if ($item->match($url, $matches, $args)) return $item;

        }
        return false;
    }
}
?>