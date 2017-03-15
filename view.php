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
 * view
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/view_controller/view_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/util/communication_handler.php');

$id = required_param('id', PARAM_INT);

$courseid = $id;
$file = basename(__FILE__, '.php');
$show = optional_param('show', $file, PARAM_TEXT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}

// Course login required to enter this page.
require_course_login($course);

$userid = $USER->id;
$context = context_course::instance($courseid);

$usercontroller = new block_pseudolearner_user_controller($userid, $courseid);
$controller = new block_pseudolearner_view_controller($courseid, $usercontroller);

require('navigation.php');

// Set page details.
$PAGE->set_url(new moodle_url('/blocks/pseudolearner/view.php'));
$PAGE->set_title(format_string(get_string('page_title_view', 'block_pseudolearner')));
$PAGE->set_heading(format_string(get_string('page_title_view', 'block_pseudolearner')));
$PAGE->set_pagelayout('standard');

// Handle submitted values and perform fitting actions.
if (data_submitted() && confirm_sesskey()) {
    $consent = optional_param('consent', null, PARAM_TEXT);

    if (!is_null($consent)) {
        if ($consent == 'withdraw') {
            $usercontroller->set_consent(false);
        } else if ($consent == 'give') {
            $usercontroller->set_consent(true);
        }
    }

    $register = optional_param('register', false, PARAM_BOOL);

    if ($register) {

        $key = get_config('pseudolearner', 'securitytoken');
        $cipher = get_config('pseudolearner', 'cipher');
        $hash = get_config('pseudolearner', 'hash');
        $comhandler = new block_pseudolearner_communication_handler($key, $cipher, $hash, $userid, $courseid);

        $url = get_config('pseudolearner', 'url');
        $service = get_config('pseudolearner', 'servicename');
        $origin = $PAGE->url->out() . "?id=" . $courseid . "&show=view";
        $timestamp = time();

        $requesturl = $comhandler->build_web_request($url, $service);

        redirect($requesturl);
    }

    $url = new moodle_url('view.php', array('id' => $courseid, 'show' => 'view'));

    redirect($url);
}



echo $OUTPUT->header();

require('tabs.php');

$code = optional_param('code', null, PARAM_TEXT);
if (!is_null($code)) {
    echo '<div class="alert alert-'.$code.'">' . get_string('pseudonym_registration_'.$code, 'block_pseudolearner') . '</div>';
}

echo $controller->render();

echo $OUTPUT->footer();