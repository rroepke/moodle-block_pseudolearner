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
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/config_controller.php');

$id = required_param('id', PARAM_INT);

$courseid = $id;

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}

require_course_login($course);

$userid = $USER->id;
$context = context_course::instance($courseid);

if (!has_capability('moodle/block:edit', $context, $userid)) {
    $url = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($url);
}

$controller = new block_pseudolearner_config_controller($courseid, $context);

if (data_submitted() && confirm_sesskey()) {
    $save = optional_param('save', false, PARAM_BOOL);

    if ($save) {
        $controller->save();
    }

    $url = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($url);
}

$PAGE->set_url('/blocks/pseudolearner/config_view.php');
$PAGE->set_title(format_string("test"));
$PAGE->set_heading(format_string("test123"));
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

echo $controller->render();

echo $OUTPUT->footer();