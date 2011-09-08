<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andi
 * Date: 27.03.11
 * Time: 21:48
 * To change this template use File | Settings | File Templates.
 */
 
class eaGB_Model_Smiley extends eaGB_Model
{
    protected $table = 'eagb_smileys';
    protected function getTable()
    {
        return $this->table;
    }

    protected function validate(array $data)
    {
        $data['url'] = isset($data['url']) ? 'http://' . ltrim($data['url'], 'http://') : '';
        if (isset($data['smiley']) and $data['smiley'] != '' and filter_var($data['url'], FILTER_VALIDATE_URL) !== false) {
            return true;
        }
        return false;
    }

    public function addSmileys(array $entries)
    {
        $smileys = $this->findAll();
        foreach ($entries as &$entry) {
            foreach ($smileys as &$smiley) {
                $entry['body'] = str_replace($smiley['smiley'], '<img src="' . eaBaseUrl() . $smiley['url'] . '" alt="' . $smiley['smiley'] . '" />', $entry['body']);
            }
        }
        return $entries;
    }
}
