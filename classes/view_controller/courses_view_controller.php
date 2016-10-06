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
 * Class block_pseudolearner_courses_view_controller
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/template_builder.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/view_controller/basic_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');

class block_pseudolearner_courses_view_controller extends block_pseudolearner_basic_controller {

    /** @var array Template names */
    protected $templatenames = array('courselist','options');
    /** @var string Title of page */
    protected $title = 'courses';

    /**
     * Returns all option buttons.
     *
     * @return array
     */
    public function get_option_buttons() {
        $buttons = array();

        $registered = $this->usercontroller->is_registered();

        if ($registered) {

            // Pseudonym registered.
            $button = array('caption' => get_string('button_caption_give_all_consent', 'block_pseudolearner'),
                'value' => 'give',
                'name' => 'consent',
                'description' => get_string('button_description_give_all_consent', 'block_pseudolearner')
            );
            $buttons[] = $button;

            $button = array('caption' => get_string('button_caption_withdraw_all_consent', 'block_pseudolearner'),
                'value' => 'withdraw',
                'name' => 'consent',
                'description' => get_string('button_description_withdraw_all_consent', 'block_pseudolearner')
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

        if ($this->usercontroller->get_consent()) {
            $link = 'link_green';
        } else {
            $link = 'link_red';
        }

        $firsttemplate->assign('link', $link);

        return $firsttemplate->load_template();
    }

    /**
     * Render 'courses' template.
     *
     * @return string
     */
    public function render_courselist() {
        $overviewoptions = new block_pseudolearner_template_builder();
        $overviewoptions->set_template('courselist');
        $overviewoptions->assign('id', $this->courseid);

        if ($this->usercontroller->get_consent()) {
            $link = 'link_green';
        } else {
            $link = 'link_red';
        }

        $overviewoptions->assign('link', $link);
        $overviewoptions->assign('courses', $this->usercontroller->get_courses());

        return $overviewoptions->load_template();
    }
}