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
 * Class block_pseudolearner_user_controller
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/instance_controller.php');

class block_pseudolearner_user_controller {

    /** @var string name of user table */
    private $usertable = 'block_pseudolearner_user';
    /** @var string name of user-course table */
    private $usercoursetable = 'block_pseudolearner_u_course';

    /** @var int ID of the user */
    private $userid = null;
    /** @var int ID of the course */
    private $courseid = null;

    /**
     * block_pseudolearner_user_controller constructor.
     *
     * @param $userid
     * @param null $courseid
     */
    public function __construct($userid, $courseid = null) {
        $this->userid = $userid;
        $this->courseid = $courseid;

        $this->create_user_record($userid);

        if (!is_null($this->courseid)) {
            $this->create_user_course_record($courseid);
        }
    }

    /**
     * Creates a user record
     * @param $userid
     */
    public function create_user_record($userid) {
        global $DB;

        if (!$DB->record_exists($this->usertable, array(
            'userid' => $userid))) {
            $record = new stdClass();
            $record->userid = $userid;

            $DB->insert_record($this->usertable, $record);
        }
    }

    /**
     * Creates a user-course record
     */
    public function create_user_course_record($courseid) {
        global $DB;

        if (!$DB->record_exists($this->usercoursetable, array(
            'userid' => $this->userid,
            'courseid' => $courseid))) {
            $record = new stdClass();
            $record->userid = $this->userid;
            $record->courseid = $courseid;

            $DB->insert_record($this->usercoursetable, $record);
        }
    }

    /**
     * Returns whether a pseudonym is registered or not
     *
     * @return mixed
     */
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

    /**
     * Sets registered setting for user
     *
     * @param $registered
     */
    public function set_registered($registered) {
        global $DB;

        $record = $DB->get_record(
            $this->usertable,
            array(
                'userid' => $this->userid,
            )
        );

        $record->registered = $registered;
        $record->timestamp = time();

        $DB->update_record(
            $this->usertable,
            $record
        );
    }

    /**
     * Deletes pseudonym
     */
    public function delete_pseudonym() {
        $this->set_pseudonym(null);

        $this->set_consent_for_all(false);

        $this->set_registered(false);
    }

    /**
     * Registers pseudonym
     *
     * @param $pseudonym
     */
    public function register_pseudonym($pseudonym) {
        $this->set_pseudonym($pseudonym);

        $this->set_registered(true);
    }

    /**
     * Returns consent for course
     *
     * @param null $courseid
     * @return bool|mixed
     */
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

    /**
     * Sets pseudonym
     *
     * @param $pseudonym
     */
    public function set_pseudonym($pseudonym) {
        global $DB;

        if ($DB->record_exists($this->usertable, array(
            'userid' => $this->userid))) {

            $record = $DB->get_record(
                $this->usertable,
                array('userid' => $this->userid)
            );

            $record->pseudonym = $pseudonym;

            $DB->update_record(
                $this->usertable,
                $record
            );
        } else {
            $this->create_user_record($this->userid);
            $this->set_pseudonym($pseudonym);
        }
    }

    /**
     * Sets consent for course
     *
     * @param $consent
     * @param null $courseid
     */
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
        } else {
            $this->create_user_course_record($courseid);
            $this->set_consent($consent, $courseid);
        }
    }

    /**
     * Sets consent for all
     *
     * @param $consent
     */
    public function set_consent_for_all($consent) {
        $courses = $this->get_courses();

        foreach ($courses as $course) {
            $this->set_consent($consent, $course->id);
        }
    }

    /**
     * Returns array of all courses
     *
     * @return array
     */
    public function get_courses() {
        $userid = $this->userid;
        $allcourses = enrol_get_all_users_courses($userid);

        $courses = array();

        foreach ($allcourses as $course) {
            $instancecontroller = new block_pseudolearner_instance_controller($course->id);
            if ($instancecontroller->is_activated()) {
                $url = new moodle_url('/course/view.php', array('id' => $course->id));
                $course->url = $url->out();
                $course->consent = $this->get_consent($course->id);
                $consentaction = $this->get_consent($course->id) ? 'withdraw' : 'give';
                $button = array('caption' => get_string('button_caption_' . $consentaction . '_consent', 'block_pseudolearner'),
                    'value' => $consentaction,
                    'name' => 'consent_'. $course->id
                );
                $course->button = $button;
                $courses[] = $course;
            }
        }

        sort($courses);

        return $courses;
    }

    /**
     * Returns time of registration
     *
     * @return int
     */
    public function get_registered_time() {
        global $DB;

        return $DB->get_field(
            $this->usertable,
            'timestamp',
            array(
                'userid' => $this->userid,
            )
        );
    }

    /**
     * Returns pseudonym of user
     *
     * @return mixed
     */
    public function get_pseudonym() {
        global $DB;

        return $DB->get_field(
            $this->usertable,
            'pseudonym',
            array(
                'userid' => $this->userid,
            )
        );
    }
}