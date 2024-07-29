<?php
/**
 * Service: Media
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Field {

    static public function updateField($gid, $field_keys, $field_values) {

        $log_field_model = new Log_Field_Model();
        $log_field_model->deleteField($gid);

        if (empty($field_keys) || empty($field_values)) {
            return;
        }

        foreach ($field_keys as $key => $field_name) {
            if (empty($field_name) || empty($field_values[$key])) {
                continue;
            }
            $log_field_model->addField($gid, $field_name, $field_values[$key]);
        }

    }

}
