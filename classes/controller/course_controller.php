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
 * Class block_pseudolearner_course_controller
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/instance_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');

class block_pseudolearner_course_controller {

    /** @var string name of user-course table */
    private $usercoursetable = 'block_pseudolearner_u_course';

    /** @var int ID of the course */
    private $courseid = null;

    /** @var context Context of course */
    private $context = null;

    /**
     * block_pseudolearner_course_controller constructor.
     *
     * @param null $courseid
     * @internal param $userid
     */
    public function __construct($courseid, $context) {
        $this->courseid = $courseid;
        $this->context = $context;
    }

    /**
     * Returns status of all users giving consent or not
     *
     * @return array
     */
    public function get_users() {
        global $DB;

        $enrolledusers = get_enrolled_users($this->context);
        $records = $DB->get_records($this->usercoursetable, array('courseid' => $this->courseid));

        foreach ($records as $record) {
            $url = new moodle_url('/user/profile.php', array('id' => $record->userid));
            $record->url = $url->out();
            $record->user = $enrolledusers[$record->userid];
        }

        return $records;
    }

    /**
     * Sets consent for all users
     *
     * @param $consent
     */
    public function set_consent_for_all($consent) {
        $users = $this->get_users();

        // iterate over all users
        foreach ($users as $user) {
            $uc = new block_pseudolearner_user_controller($user->userid, $this->courseid);
            $uc->set_consent($consent);
        }
    }
}