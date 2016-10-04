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
 * View
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/view_controller.php');

$courseid = required_param('id', PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}

require_course_login($course);

$userid = $USER->id;
$context = context_course::instance($courseid);

$controller = new block_pseudolearner_view_controller($courseid, $userid, $context);

if (data_submitted() && confirm_sesskey()) {

}

$PAGE->set_url('/blocks/pseudolearner/courses_view.php');
$PAGE->set_title(format_string("courses_view"));
$PAGE->set_heading(format_string("courses_view"));
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

require('tabs.php');

$controller->render();

echo $OUTPUT->footer();