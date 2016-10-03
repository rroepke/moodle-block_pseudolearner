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

class block_pseudolearner_instance {

    private $courseid;

    public function __construct($courseid) {
        $this->courseid = $courseid;
    }

    public function is_configured() {
        global $DB;

        return $DB->get_field('pseudolearner','configured', array('courseid' => $this->courseid));
    }

    public function set_configured($configured) {
        global $DB;

        $record = $DB->get_record('pseudolearner', array('courseid' => $this->courseid));

        $record->configured = $configured;

        $DB->update_record('pseudolearner', $record);
    }
}