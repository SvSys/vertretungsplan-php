<?php
namespace Vertretungsplan;
use JsonSerializable;

/**
 * Created by PhpStorm.
 * User: jan
 * Date: 29.06.15
 * Time: 14:29
 */
class Vertretungsplan implements JsonSerializable
{

    /**
     * @var VMeta Meta-Infos (lastUpdated, day, currentpage etc.)
     */
    private $meta;

    /**
     * @var array Informationen / Nachrichten zum Tag
     */
    private $infos;

    /**
     * @var array Vertretungen
     */
    private $vertretungen;

    function __construct($meta, $infos, $vertretungen)
    {
        $this->meta = $meta;
        $this->infos = $infos;
        $this->vertretungen = $vertretungen;
    }

    /**
     * @return VMeta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @return array
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * @return array
     */
    public function getVertretungen()
    {
        return $this->vertretungen;
    }


    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        $json = array();
        foreach ($this as $key => $value) {
            $json[$key] = $value;
        }
        return $json;
    }
}