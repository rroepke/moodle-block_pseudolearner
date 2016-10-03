<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Class block_pseudolearner_view_controller
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/template_builder.php');

class block_pseudolearner_view_controller {

    private $courseid = null;
    private $context = null;
    private $view = null;

    public function __construct($courseid, $context) {
        $this->courseid = $courseid;
        $this->context = $context;
        $this->view = new block_pseudolearner_template_builder();
    }

    public function get_instance() {
        global $DB;

        return $DB->get_record('pseudolearner', array('courseid' => $this->courseid));
    }

    public function render() {
        $this->view->set_template('wrapper_view');
        $this->starttime = 123;

        $this->endtime = 456;

        $buttoncaption = "START";

        $buttondisabled = "";

        $buttonvalue = 1;

        $firsttemplate = new block_pseudolearner_template_builder();
        $firsttemplate->set_template('analysis_status');
        $firsttemplate->assign('button',
            array(
                'type' => 'submit',
                'name' => 'questionnaire_switcher',
                'value' => $buttonvalue,
                'state' => $buttondisabled,
                'text' => $buttoncaption
            )
        );
        $firsttemplate->assign('info_teacher', "blub1");
        $firsttemplate->assign('analysis_time_start', $this->starttime);
        $firsttemplate->assign('analysis_time_end', $this->endtime);
        $firsttemplate->assign('analysis_status_info', "blub2");

        $template = $firsttemplate->load_template();

        $this->view->assign('analysis_status_template', $template);

        echo $this->view->load_template();
    }
}