<?php
/**
 * Service: Field
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Field {

    static public function getFields($gid) {
        $log_field_model = new Log_Field_Model();
        $rows = $log_field_model->getFields($gid);
        if (empty($rows)) {
            return [];
        }
        $fields = [];
        foreach ($rows as $row) {
            $fields[$row['field_key']] = $row['field_value'];
        }
        return $fields;
    }

    static public function updateField($gid, $field_keys, $field_values) {
        $log_field_model = new Log_Field_Model();
        $log_field_model->deleteField($gid);

        if (empty($field_keys) || empty($field_values)) {
            return;
        }

        foreach ($field_keys as $key => $field_name) {
            $field_name = addslashes(trim($field_name));
            $field_value = addslashes(trim(isset($field_values[$key]) ? $field_values[$key] : ''));
            if (empty($field_name) || empty($field_value)) {
                continue;
            }
            $log_field_model->addField($gid, $field_name, $field_value);
        }
    }
}
