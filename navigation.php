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
 * Handles jumps and redirects due to access and navigation
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') or die ('not allowed');

// Check if pseudonym is not registered and file is not 'view' to redirect to 'view' page.
if (!$usercontroller->is_registered() && $file != 'view' && !has_capability('moodle/block:edit', $context)) {
    $url = new moodle_url('view.php', array('id' => $courseid, 'show' => 'view'));
    redirect($url);
}

// Check if submitted with linkage to 'pseudonym' or 'courses' and redirect respectively.
if (data_submitted() && confirm_sesskey()) {
    $pseudonym = optional_param('pseudonym', false, PARAM_BOOL);
    $courses = optional_param('courses', false, PARAM_BOOL);
    $settings = optional_param('settings', false, PARAM_BOOL);

    if ($pseudonym) {
        $url = new moodle_url('pseudonym_view.php', array('id' => $courseid, 'show' => 'pseudonym'));
        redirect($url);
    }

    if ($courses) {
        $url = new moodle_url('courses_view.php', array('id' => $courseid, 'show' => 'courses'));
        redirect($url);
    }

    if ($settings) {
        $url = new moodle_url('settings_view.php', array('id' => $courseid, 'show' => 'settings'));
        redirect($url);
    }
}
