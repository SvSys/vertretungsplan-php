<?php
namespace Vertretungsplan;

require_once __DIR__ . '/../../vendor/autoload.php';

use Vertretungsplan\VMeta;
use Vertretungsplan\Vertretungsplan;

/**
 * Created by PhpStorm.
 * User: jan
 * Date: 28.06.15
 * Time: 20:44
 */
class HttpManager
{
    private $url;

    function __construct($url)
    {
        $this->url = $url;
    }

    function remove_html(&$item1, $key)
    {
        $html = str_get_html($item1);
        $item1 = $html->plaintext;
    }

    /**
     * @return Vertretungsplan Vertretungsplan
     */
    function fetchPlan()
    {
        $html = file_get_html($this->url);

        $infos = $this->getInfos($html);
        $meta = $this->getMeta($html);

        $vertretungen = $this->getVertretungen($html);

        return  new Vertretungsplan($meta, $infos, $vertretungen);
    }

    /**
     * @param simple_html_dom $html
     * @return array Infos
     */
    private function getInfos($html)
    {
        $info = $html->find('.info tr', 1); //TODO Error Handling
        $infos = explode('<br>', $info);
        array_walk($infos, array($this, 'remove_html'));
        return $infos;
    }

    /**
     * @param simple_html_dom $html
     * @return VMeta Meta des Plans
     */
    private function getMeta($html)
    {
        $untis_ver = $html->find('head meta[name=generator]', 0)->content;

        $stand = $html->find('.mon_head', 0); //First Row of mon_head
        $stand = $stand->find('td', count($stand->find('td')) - 1)->plaintext; //Find last td

        $matches = array();
        preg_match('/\d{2}\.\d{2}\.\d{4} \d{2}:\d{2}/', $stand, $matches); //Extract last updated in format: 29.06.2015 12:04
        $date = count($matches) > 0 ? $matches[0] : 'Unbekannt';

        $tagW = $html->find('.mon_title', 0)->plaintext;

        $tmatches = array();

        preg_match('/\d{2}\.\d\.\d{4}/', $tagW, $tmatches); //Extract Date, format: 29.6.2015

        $tag = count($tmatches) > 0 ? $tmatches[0] : 'Unbekannt';

        $smatches = [];

        preg_match("/(\d) \/ (\d)/", $tagW, $smatches); //Extract current and max site(s), format: 1 / 2

        $current = count($smatches) > 1 ? intval($smatches[0]) : 1;
        $max = count($smatches) > 1 ? intval($smatches[1]) : 1;

        return new VMeta($untis_ver, $stand, $tag, $current, $max);
    }

    /**
     * @param $html
     * @return array
     */
    private function getVertretungen($html)
    {
        $vplan = $html->find('.mon_list', 0);

        $eintraege = $vplan->find('tr');

        $headings = $eintraege[0]->find('th');

        $cats = [];

        foreach ($headings as $cat) {
            if (in_array($cat->plaintext, $cats)) //Avoid duplicates
                $cats[] = '(' . $cat->plaintext . ')';
            else
                $cats[] = $cat->plaintext;
        }

        $vertretungen = [];

        for ($i = 1; $i < count($eintraege); $i++) {
            $eintrag = $eintraege[$i];

            $toAdd = [];
            for ($j = 0; $j < count($eintrag->find('td')); $j++) {
                $toAdd[$cats[$j]] = $eintrag->find('td', $j)->plaintext;
            }

            $vertretungen[] = $toAdd;
        }

        return $vertretungen;
    }


}

