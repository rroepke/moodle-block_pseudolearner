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
 * Class block_pseudolearner_instance
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class block_pseudolearner_user_controller {

    private $usertable = 'block_pseudolearner_user';
    private $usercoursetable = 'block_pseudolearner_u_course';

    private $userid = null;
    private $courseid = null;

    public function __construct($userid, $courseid = null) {
        $this->userid = $userid;
        $this->courseid = $courseid;

        $this->create_user_record();

        if (!is_null($this->courseid)) {
            $this->create_user_course_record();
        }
    }

    public function create_user_record() {
        global $DB;

        if (!$DB->record_exists($this->usertable,array(
            'userid' => $this->userid))) {
            $record = new stdClass();
            $record->userid = $this->userid;

            $DB->insert_record($this->usertable, $record);
        }
    }

    public function create_user_course_record() {
        global $DB;

        if (!$DB->record_exists($this->usercoursetable,array(
            'userid' => $this->userid,
            'courseid' => $this->courseid))) {
            $record = new stdClass();
            $record->userid = $this->userid;
            $record->courseid = $this->courseid;

            $DB->insert_record($this->usercoursetable, $record);
        }
    }

    public function is_registered() {
        global $DB;

        return $DB->get_field(
            $this->usertable,
            'registered',
            array(
                'userid' => $this->userid,
            )
        );
    }

    public function set_registered($registered) {
        global $DB;

        $record = $DB->get_record(
            $this->usertable,
            array(
                'userid' => $this->userid,
            )
        );

        $record->registered = $registered;

        $DB->update_record(
            $this->usertable,
            $record
        );
    }

    public function delete_pseudonym() {
        // TODO handle pseudonym deletion.

        $this->withdraw_consent_for_all();

        $this->set_registered(false);
    }

    public function register_pseudonym() {
        // TODO handle pseudonym registration.

        $this->set_registered(true);
    }

    public function withdraw_consent_for_all() {
        $userid = $this->userid;
        $courses = enrol_get_all_users_courses($userid);

        foreach (array_keys($courses) as $courseid) {
            $this->set_consent(false, $courseid);
        }

    }

    public function get_consent($courseid = null) {
        global $DB;
        if ($DB->record_exists($this->usercoursetable, array(
            'userid' => $this->userid,
            'courseid' => ((is_null($courseid)) ? $this->courseid : $courseid)
        ))) {
            return $DB->get_field(
                $this->usercoursetable,
                'consent',
                array(
                    'userid' => $this->userid,
                    'courseid' => ((is_null($courseid)) ? $this->courseid : $courseid)
                )
            );
        } else {
            return false;
        }
    }

    public function set_consent($consent, $courseid = null) {
        global $DB;

        if ($DB->record_exists($this->usercoursetable, array(
            'userid' => $this->userid,
            'courseid' => ((is_null($courseid)) ? $this->courseid : $courseid)
        ))) {
            $record = $DB->get_record(
                $this->usercoursetable,
                array(
                    'userid' => $this->userid,
                    'courseid' => ((is_null($courseid)) ? $this->courseid : $courseid)
                )
            );

            $record->consent = $consent;

            $DB->update_record(
                $this->usercoursetable,
                $record
            );
        }
    }
}