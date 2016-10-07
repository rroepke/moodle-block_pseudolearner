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
 * Class block_pseudolearner_pseudonym_controller
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class block_pseudolearner_pseudonym_controller {

    /**
     * Returns whether a pseudonym is registered or not
     *
     * @return mixed
     */
    public function is_registered($userid) {
        $usercontroller = new block_pseudolearner_user_controller($userid);

        return $usercontroller->is_registered();
    }

    /**
     * Returns consent for course
     *
     * @param null $courseid
     * @return bool|mixed
     */
    public function get_consent($userid, $courseid) {
        $usercontroller = new block_pseudolearner_user_controller($userid, $courseid);

        return $usercontroller->get_consent($userid, $courseid);
    }

    /**
     * Returns pseudonym if consent is given in the course
     *
     * @param $userid
     * @param $courseid
     * @return mixed|null
     */
    public function get_pseudonym($userid, $courseid) {
        $usercontroller = new block_pseudolearner_user_controller($userid, $courseid);

        if ($usercontroller->get_consent($userid, $courseid)) {
            return $usercontroller->get_pseudonym();
        } else {
            return null;
        }
    }

}