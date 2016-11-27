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
 * Communication handler
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/external/CommunicationHandler.php');

class block_pseudolearner_communication_handler extends CommunicationHandler {

    /** @var int ID of course */
    private $courseid;

    /**
     * block_pseudolearner_communication_handler constructor.
     * @param string $key
     * @param string $chiffre
     * @param string $hash
     * @param int $userid
     * @param int $courseid
     */
    public function __construct($key, $chiffre, $hash, $userid = null, $courseid = null) {
        parent::__construct($key, $chiffre, $hash);
        $this->userid = $userid;
        $this->courseid = $courseid;
    }

    /**
     * Overriding exception method
     *
     * @param Exception $e
     * @throws moodle_exception
     */
    protected function throw_exception($e) {
        throw new moodle_exception($e->getMessage());
    }

    /**
     * Builds request
     *
     * @param string $url
     * @param string $service
     * @param null $timestamp
     * @return string
     */
    public function build_request($url, $service, $timestamp = null) {
        if (is_null($timestamp)) {
            $timestamp = time();
        }

        $result = parent::build_request($url, $service, $timestamp);

        $this->delete_requests();

        $this->log_request($timestamp);

        return $result;
    }

    /**
     * Deletes all requests of the user
     */
    private function delete_requests() {
        global $DB;

        $DB->delete_records('block_pseudolearner_request', array('userid' => $this->userid));
    }

    /**
     * Logs request for pseudonyms
     *
     * @param $timestamp
     */
    private function log_request($timestamp) {
        global $DB;

        $record = new stdClass();

        $record->userid = $this->userid;
        $record->courseid = $this->courseid;
        $record->timestamp = $timestamp;

        $DB->insert_record('block_pseudolearner_request', $record);
    }

    /**
     * Returns courseid of the latest request
     *
     * @return mixed
     */
    public function get_courseid_of_last_request() {
        global $DB;

        $courseid = $DB->get_field('block_pseudolearner_request', 'courseid', array(
            'userid' => $this->userid
        ));

        $this->delete_requests();

        return $courseid;
    }
}