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
 * Class block_pseudolearner_pseudonym_view_controller
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/template_builder.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/view_controller/basic_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');

class block_pseudolearner_pseudonym_view_controller extends block_pseudolearner_basic_controller {

    /** @var array Template names */
    protected $templatenames = array('status', 'options');
    /** @var string Title of page */
    protected $title = 'pseudonym';

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
            $button = array('caption' => get_string('button_caption_delete_pseudonym', 'block_pseudolearner'),
                'value' => 1,
                'name' => 'delete',
                'description' => get_string('button_description_delete_pseudonym', 'block_pseudolearner')
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
        global $USER;

        $template = new block_pseudolearner_template_builder();
        $template->set_template('pseudonym');

        $template->assign('user_fullname', fullname($USER));

        $timestamp = $this->usercontroller->get_registered_time();

        if ('en' == get_string('language', 'block_pseudolearner')) {
            $format = 'F j, Y, g:i a';
            $trans = array();
            $timestamp = strtr(date($format, $timestamp), $trans);
        } else if ('de' == get_string('language', 'block_pseudolearner')) {
            $format = 'd.m.y, H:m';
            $trans = array(
                'Monday' => 'Montag',
                'Tuesday' => 'Dienstag',
                'Wednesday' => 'Mittwoch',
                'Thursday' => 'Donnerstag',
                'Friday' => 'Freitag',
                'Saturday' => 'Samstag',
                'Sunday' => 'Sonntag',
                'Mon' => 'Mo',
                'Tue' => 'Di',
                'Wed' => 'Mi',
                'Thu' => 'Do',
                'Fri' => 'Fr',
                'Sat' => 'Sa',
                'Sun' => 'So',
                'January' => 'Januar',
                'February' => 'Februar',
                'March' => 'März',
                'May' => 'Mai',
                'June' => 'Juni',
                'July' => 'Juli',
                'October' => 'Oktober',
                'December' => 'Dezember'
            );
            $timestamp = strtr(date($format, $timestamp), $trans) . ' Uhr';
        }

        $template->assign('date_registered', $timestamp);

        return $template->load_template();
    }
}
