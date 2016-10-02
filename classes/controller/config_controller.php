<?php
/**
 * Created by PhpStorm.
 * User: Rene
 * Date: 30.09.2016
 * Time: 15:12
 */
defined('MOODLE_INTERNAL') || die();

class block_pseudolearner_config_controller {

    private $courseid = null;
    private $context = null;

    public function __construct($courseid, $context) {
        $this->courseid = $courseid;
        $this->context = $context;
    }

    public function get_instance(){
        global $DB;

        return $DB->get_record("pseudolearner",array("courseid"=>$this->courseid));
    }

    public function render() {
        echo "config controller render";
    }
}