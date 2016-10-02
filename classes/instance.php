<?php
/**
 * Created by PhpStorm.
 * User: Rene
 * Date: 02.10.2016
 * Time: 14:28
 */
defined('MOODLE_INTERNAL') || die();

class block_pseudolearner_instance {

    private $courseid;

    public function __construct($courseid) {
        $this->courseid = $courseid;
    }

    public function is_configured(){
        global $DB;

        return $DB->get_field('pseudolearner','configured',array('courseid'=>$this->courseid));
    }

    public function set_configured($configured) {
        global $DB;

        $record = $DB->get_record('pseudolearner',array('courseid'=>$this->courseid));

        $record->configured = $configured;

        $DB->update_record('pseudolearner',$record);
    }
}