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
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/view_controller/settings_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/course_controller.php');

$courseid = required_param('id', PARAM_INT);
$file = basename(__FILE__, '.php');
$show = optional_param('show', $file, PARAM_TEXT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}

// Course login required to enter this page.
require_course_login($course);

$userid = $USER->id;
$context = context_course::instance($courseid);

if (!has_capability('moodle/block:edit', $context, $userid)) {
    $url = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($url);
}

$usercontroller = new block_pseudolearner_user_controller($userid, $courseid);
$coursecontroller = new block_pseudolearner_course_controller($courseid, $context);

$controller = new block_pseudolearner_settings_controller($courseid, $coursecontroller);

// Handle submitted values and perform fitting actions.
if (data_submitted() && confirm_sesskey()) {

    $consent = optional_param('consent', null, PARAM_TEXT);

    if (!is_null($consent)) {
        if ($consent == 'withdraw') {
            $coursecontroller->set_consent_for_all(false);
        }
    }

    $url = new moodle_url('settings_view.php', array('id' => $courseid, 'show' => 'settings'));
    redirect($url);
}

require('navigation.php');

// Set page details.
$PAGE->set_url('/blocks/pseudolearner/settings_view.php');
$PAGE->set_title(format_string(get_string('page_title_settings', 'block_pseudolearner')));
$PAGE->set_heading(format_string(get_string('page_title_settings', 'block_pseudolearner')));
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

require('tabs.php');

echo $controller->render();

echo $OUTPUT->footer();