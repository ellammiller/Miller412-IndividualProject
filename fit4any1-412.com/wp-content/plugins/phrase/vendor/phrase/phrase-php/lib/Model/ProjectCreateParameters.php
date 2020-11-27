<?php
/**
 * ProjectCreateParameters
 *
 * PHP version 5
 *
 * @category Class
 * @package  Phrase
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Phrase API Reference
 *
 * The version of the OpenAPI document: 2.0.0
 * Contact: support@phrase.com
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 4.3.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Phrase\Model;

use \ArrayAccess;
use \Phrase\ObjectSerializer;

/**
 * ProjectCreateParameters Class Doc Comment
 *
 * @category Class
 * @package  Phrase
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class ProjectCreateParameters implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'project_create_parameters';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'name' => 'string',
        'main_format' => 'string',
        'shares_translation_memory' => 'bool',
        'project_image' => '\SplFileObject',
        'remove_project_image' => 'bool',
        'account_id' => 'string',
        'source_project_id' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPIFormats = [
        'name' => null,
        'main_format' => null,
        'shares_translation_memory' => null,
        'project_image' => 'binary',
        'remove_project_image' => null,
        'account_id' => null,
        'source_project_id' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'name' => 'name',
        'main_format' => 'main_format',
        'shares_translation_memory' => 'shares_translation_memory',
        'project_image' => 'project_image',
        'remove_project_image' => 'remove_project_image',
        'account_id' => 'account_id',
        'source_project_id' => 'source_project_id'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'name' => 'setName',
        'main_format' => 'setMainFormat',
        'shares_translation_memory' => 'setSharesTranslationMemory',
        'project_image' => 'setProjectImage',
        'remove_project_image' => 'setRemoveProjectImage',
        'account_id' => 'setAccountId',
        'source_project_id' => 'setSourceProjectId'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'name' => 'getName',
        'main_format' => 'getMainFormat',
        'shares_translation_memory' => 'getSharesTranslationMemory',
        'project_image' => 'getProjectImage',
        'remove_project_image' => 'getRemoveProjectImage',
        'account_id' => 'getAccountId',
        'source_project_id' => 'getSourceProjectId'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['main_format'] = isset($data['main_format']) ? $data['main_format'] : null;
        $this->container['shares_translation_memory'] = isset($data['shares_translation_memory']) ? $data['shares_translation_memory'] : null;
        $this->container['project_image'] = isset($data['project_image']) ? $data['project_image'] : null;
        $this->container['remove_project_image'] = isset($data['remove_project_image']) ? $data['remove_project_image'] : null;
        $this->container['account_id'] = isset($data['account_id']) ? $data['account_id'] : null;
        $this->container['source_project_id'] = isset($data['source_project_id']) ? $data['source_project_id'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string|null $name Name of the project
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets main_format
     *
     * @return string|null
     */
    public function getMainFormat()
    {
        return $this->container['main_format'];
    }

    /**
     * Sets main_format
     *
     * @param string|null $main_format Main file format specified by its API Extension name. Used for locale downloads if no format is specified. For API Extension names of available file formats see <a href=\"https://help.phrase.com/help/supported-platforms-and-formats\">Format Guide</a> or our <a href=\"#formats\">Formats API Endpoint</a>.
     *
     * @return $this
     */
    public function setMainFormat($main_format)
    {
        $this->container['main_format'] = $main_format;

        return $this;
    }

    /**
     * Gets shares_translation_memory
     *
     * @return bool|null
     */
    public function getSharesTranslationMemory()
    {
        return $this->container['shares_translation_memory'];
    }

    /**
     * Sets shares_translation_memory
     *
     * @param bool|null $shares_translation_memory Indicates whether the project should share the account's translation memory
     *
     * @return $this
     */
    public function setSharesTranslationMemory($shares_translation_memory)
    {
        $this->container['shares_translation_memory'] = $shares_translation_memory;

        return $this;
    }

    /**
     * Gets project_image
     *
     * @return \SplFileObject|null
     */
    public function getProjectImage()
    {
        return $this->container['project_image'];
    }

    /**
     * Sets project_image
     *
     * @param \SplFileObject|null $project_image Image to identify the project
     *
     * @return $this
     */
    public function setProjectImage($project_image)
    {
        $this->container['project_image'] = $project_image;

        return $this;
    }

    /**
     * Gets remove_project_image
     *
     * @return bool|null
     */
    public function getRemoveProjectImage()
    {
        return $this->container['remove_project_image'];
    }

    /**
     * Sets remove_project_image
     *
     * @param bool|null $remove_project_image Indicates whether the project image should be deleted.
     *
     * @return $this
     */
    public function setRemoveProjectImage($remove_project_image)
    {
        $this->container['remove_project_image'] = $remove_project_image;

        return $this;
    }

    /**
     * Gets account_id
     *
     * @return string|null
     */
    public function getAccountId()
    {
        return $this->container['account_id'];
    }

    /**
     * Sets account_id
     *
     * @param string|null $account_id Account ID to specify the actual account the project should be created in. Required if the requesting user is a member of multiple accounts.
     *
     * @return $this
     */
    public function setAccountId($account_id)
    {
        $this->container['account_id'] = $account_id;

        return $this;
    }

    /**
     * Gets source_project_id
     *
     * @return string|null
     */
    public function getSourceProjectId()
    {
        return $this->container['source_project_id'];
    }

    /**
     * Sets source_project_id
     *
     * @param string|null $source_project_id When a source project ID is given, a clone of that project will be created, including all locales, keys and translations as well as the main project settings if they are not defined otherwise through the params.
     *
     * @return $this
     */
    public function setSourceProjectId($source_project_id)
    {
        $this->container['source_project_id'] = $source_project_id;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


