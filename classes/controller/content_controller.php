<?php
/**
 * Created by PhpStorm.
 * User: Rene
 * Date: 30.09.2016
 * Time: 15:12
 */
defined('MOODLE_INTERNAL') || die();

class block_pseudolearner_content_controller {

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

    public function get_content(){
        $content = new stdClass();
        if (has_capability('moodle/block:edit',$this->context)) {
            if (!$instance = $this->get_instance()){
                $content->text = "can edit settings & has no instance";
            } else {
                $content->text = "can edit settings & has instance";
                $content->footer = "<a href=\"".$this->get_link("config_view")."\"><button>CONFIGURE ME</button></a>";
            }
        } else {
            if ($instance = $this->get_instance()){
                $content->text = "Not configured yet. Come back later when the teacher of this course finished the configuration of this block.";
            } else {
                $content->text = "cannot edit settings & has instance";
                $content->footer = "<a href=\"".$this->get_link("view")."\"><button>MANAGE</button></a>";
            }
        }

        return $content;
    }

    public function get_link($page) {
        $url = new moodle_url("/blocks/pseudolearner/".$page.".php",
            array("id"=>$this->courseid));
        return $url->out();
    }
}