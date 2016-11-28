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

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/util/template_builder.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/view_controller/basic_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');

class block_pseudolearner_view_controller extends block_pseudolearner_basic_controller {

    /** @var array Template names */
    protected $templatenames = array('status', 'options');
    /** @var string Title of page */
    protected $title = 'view';

    /**
     * Returns all option buttons.
     *
     * @return array
     */
    public function get_option_buttons() {
        $buttons = array();

        $registered = $this->controller->is_registered();

        $consentaction = $this->controller->get_consent() ? 'withdraw' : 'give';

        if ($registered) {
            // Pseudonym registered.
            $button = array('caption' => get_string('button_caption_' . $consentaction . '_consent', 'block_pseudolearner'),
                'value' => $consentaction,
                'name' => 'consent',
                'description' => get_string('button_description_' . $consentaction . '_consent', 'block_pseudolearner')
            );
            $buttons[] = $button;

            $button = array('caption' => get_string('button_caption_view_pseudonym', 'block_pseudolearner'),
                'value' => 1,
                'name' => 'pseudonym',
                'description' => get_string('button_description_view_pseudonym', 'block_pseudolearner')
            );
            $buttons[] = $button;

            $button = array('caption' => get_string('button_caption_view_courses', 'block_pseudolearner'),
                'value' => 1,
                'name' => 'courses',
                'description' => get_string('button_description_view_courses', 'block_pseudolearner')
            );
            $buttons[] = $button;

        } else {

            // No pseudonym registered.
            $button = array('caption' => get_string('button_caption_register_pseudonym', 'block_pseudolearner'),
                'value' => 1,
                'name' => 'register',
                'description' => get_string('button_description_register_pseudonym', 'block_pseudolearner')
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

        if (!$this->controller->is_registered()) {
            $link = 'link_grey';
        } else if ($this->controller->get_consent()) {
            $link = 'link_green';
        } else {
            $link = 'link_red';
        }

        $firsttemplate->assign('link', $link);
        $firsttemplate->assign('content', "View");

        return $firsttemplate->load_template();
    }
}
