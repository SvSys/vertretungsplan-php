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
     * @param $course string Course to search for
     * @param int $classIndex Col-Index of the course-row (normally 0)
     * @return array Array of all vertretungen found
     */
    public function getVertretungenForCourse($course, $classIndex = 0)
    {
        $found = [];
        foreach($this->vertretungen as $vertretung) {
            $key = array_keys($vertretung)[$classIndex];
            if(preg_match('/.*'.$course.'.*/', $vertretung[$key]) === 1) {
                $found[] = $vertretung;
            }
        }

        return $found;
    }

    /**
     * @return array Array of all col-headings (e.g. Klasse, Raum, Lehrer etc.)
     */
    public function getKeys() {
        if(count($this->vertretungen) > 0) {
            return array_keys($this->vertretungen[0]);
        } else {
            return [];
        }
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        $json = array();
        foreach ($this as $key => $value) {
            $json[$key] = $value;
        }
        return $json;
    }
}