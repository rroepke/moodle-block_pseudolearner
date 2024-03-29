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
 * Class block_pseudolearner_config_controller
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/instance_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/view_controller/basic_controller.php');

class block_pseudolearner_settings_controller extends block_pseudolearner_basic_controller {

    /** @var array Template names */
    protected $templatenames = array('userlist', 'options');
    /** @var string Title of page */
    protected $title = 'settings';

    /**
     * Returns all option buttons.
     *
     * @return array
     */
    public function get_option_buttons() {
        $buttons = array();

        $button = array('caption' => get_string('button_caption_withdraw_all_consent', 'block_pseudolearner'),
            'value' => 'withdraw',
            'name' => 'consent',
            'description' => get_string('button_description_withdraw_all_users_consent', 'block_pseudolearner')
        );
        $buttons[] = $button;

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

        return $firsttemplate->load_template();
    }

    /**
     * Render 'courses' template.
     *
     * @return string
     */
    public function render_userlist() {
        $overviewoptions = new block_pseudolearner_template_builder();
        $overviewoptions->set_template('userlist');
        $overviewoptions->assign('id', $this->courseid);

        $overviewoptions->assign('users', $this->controller->get_users());

        return $overviewoptions->load_template();
    }

}