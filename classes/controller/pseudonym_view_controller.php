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
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');

class block_pseudolearner_pseudonym_view_controller {

    private $courseid = null;
    private $userid = null;
    private $context = null;
    private $view = null;
    private $user_controller = null;

    public function __construct($courseid, $userid, $context) {
        $this->courseid = $courseid;
        $this->userid = $userid;
        $this->context = $context;
        $this->view = new block_pseudolearner_template_builder();
        $this->user_controller = new block_pseudolearner_user_controller($userid);
    }

    public function get_instance() {
        global $DB;

        return $DB->get_record('pseudolearner', array('courseid' => $this->courseid));
    }

    public function render() {
        $this->view->set_template('wrapper_view');

        $template = $this->render_status();
        $this->view->assign('analysis_status_template', $template);

        $template = $this->render_options();
        $this->view->assign('overview_options_template', $template);

        echo $this->view->load_template();
    }

    public function render_status() {
        $this->starttime = 123;

        $this->endtime = 456;

        $buttoncaption = "START";

        $buttondisabled = "";

        $buttonvalue = 1;

        $firsttemplate = new block_pseudolearner_template_builder();
        $firsttemplate->set_template('overview_status');
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

        return $firsttemplate->load_template();
    }

    public function render_options() {
        $overviewoptions = new block_pseudolearner_template_builder();
        $overviewoptions->set_template('options');
        $overviewoptions->assign('id',$this->courseid);

        $buttons = array();

        $registered = $this->user_controller->is_registered();

        $consentaction = $this->user_controller->get_consent() ? 'withdraw' : 'give';

        if ($registered) {

            // pseudonym registered
            $button = array('caption' => 'Delete pseudonym', // TODO fix caption and description
                'value' => 1,
                'name' => 'delete',
                'description' => 'Click here to delete your currently registered pseudonym. This way, all courses stop tracking learning data with this pseudonym.'
            );
            $buttons[] = $button;

//            $button = array('caption' => 'View courses',
//                'value' => 1,
//                'name' => 'courses',
//                'description' => 'Click here to see an overview about all courses and their current tracking status.'
//            );
//            $buttons[] = $button;

        } else {

            // no pseudonym registered
            $button = array('caption' => 'Register pseudonym',
                'value' => 1,
                'name' => 'register',
                'description' => 'Click here to register a pseudonym which can be used for tracking your learning data.'
            );
            $buttons[] = $button;

        }

        $url = new moodle_url('view.php', array('id' => $this->courseid, 'show' => 'view'));

        $overviewoptions->assign('buttons', $buttons);
        $overviewoptions->assign('go_back', $url->out());

        return $overviewoptions->load_template();
    }

    public function delete_pseudonym() {
        $this->user_controller->delete_pseudonym();
    }

    public function register_pseudonym() {
        $this->user_controller->register_pseudonym();
    }
}
