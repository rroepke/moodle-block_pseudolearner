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
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/view_controller/basic_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');

class block_pseudolearner_view_controller extends block_pseudolearner_basic_controller {

    /** @var array Template names */
    protected $templatenames = array('status', 'options');
    /** @var string Title of page */
    protected $title = 'Overview';

    /**
     * Returns all option buttons.
     *
     * @return array
     */
    public function get_option_buttons() {
        $buttons = array();

        $registered = $this->usercontroller->is_registered();

        $consentaction = $this->usercontroller->get_consent() ? 'withdraw' : 'give';

        if ($registered) {
            // Pseudonym registered.
            $button = array('caption' => $consentaction . ' consent', // TODO fix caption and description.
                'value' => $consentaction,
                'name' => 'consent',
                'description' => get_string('description_withdraw', 'block_pseudolearner')
            );
            $buttons[] = $button;

            $button = array('caption' => 'View pseudonym',
                'value' => 1,
                'name' => 'pseudonym',
                'description' => 'Click here to see more details about your registered pseudonym in Moodle.'
            );
            $buttons[] = $button;

            $button = array('caption' => 'View courses',
                'value' => 1,
                'name' => 'courses',
                'description' => 'Click here to see an overview about all courses and their current tracking status.'
            );
            $buttons[] = $button;

        } else {

            // No pseudonym registered.
            $button = array('caption' => 'Register pseudonym',
                'value' => 1,
                'name' => 'register',
                'description' => 'Click here to register a pseudonym which can be used for tracking your learning data.'
            );
            $buttons[] = $button;

        }

        return $buttons;
    }

    /**
     * Render 'status' template.
     *
     * @return string
     */
    public function render_status() {

        $firsttemplate = new block_pseudolearner_template_builder();
        $firsttemplate->set_template('status');
        $firsttemplate->assign('content', 'view');

        return $firsttemplate->load_template();
    }
}
