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

class block_pseudolearner_user_course_controller {

    private $tablename = 'block_pseudolearner_u_course';

    private $userid;
    private $courseid;

    public function __construct($userid, $courseid) {
        $this->userid = $userid;
        $this->courseid = $courseid;

        $this->create_record();
    }

    public function create_record() {
        global $DB;

        if (!$DB->record_exists($this->tablename,array(
            'userid' => $this->userid,
            'courseid' => $this->courseid))) {
            $record = new stdClass();
            $record->userid = $this->userid;
            $record->courseid = $this->courseid;

            $DB->insert_record($this->tablename, $record);
        }
    }

    public function get_consent() {
        global $DB;

        return $DB->get_field(
            $this->tablename,
            'consent',
            array(
                'userid' => $this->userid,
                'courseid' => $this->courseid
            )
        );
    }

    public function set_consent($consent) {
        global $DB;

        $record = $DB->get_record(
            $this->tablename,
            array(
                'userid' => $this->userid,
                'courseid' => $this->courseid
            )
        );

        $record->consent = $consent;

        $DB->update_record(
            $this->tablename,
            $record
        );
    }
}