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

class block_pseudolearner_instance_controller {

    /** @var string name of table */
    private $tablename = 'block_pseudolearner';

    /** @var int ID of the course */
    private $courseid;

    /**
     * block_pseudolearner_instance_controller constructor.
     *
     * @param $courseid
     */
    public function __construct($courseid) {
        $this->courseid = $courseid;
    }

    /**
     * Returns whether it is configured or not
     *
     * @return mixed
     */
    public function is_configured() {
        global $DB;

        return $DB->get_field($this->tablename, 'configured', array('courseid' => $this->courseid));
    }

    /**
     * Sets configured property of instance
     *
     * @param $configured
     */
    public function set_configured($configured) {
        global $DB;

        $record = $DB->get_record($this->tablename, array('courseid' => $this->courseid));

        $record->configured = $configured;

        $DB->update_record($this->tablename, $record);
    }

    /**
     * Returns whether the plugin is activated in the course or not
     *
     * @return bool
     */
    public function is_activated() {
        global $DB;

        return $DB->record_exists($this->tablename, array('courseid' => $this->courseid));
    }
}