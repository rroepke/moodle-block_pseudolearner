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
 * External pseudolearner API
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir."/externallib.php");
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');

/**
 * Pseudolearner functions
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_pseudolearner_external extends external_api {

    /**
     * Returns description of method parameters for get_pseudonym
     * @return external_function_parameters
     */
    public static function get_pseudonym_parameters() {
        return new external_function_parameters(
            array(
                'userid' => new external_value(PARAM_INT, 'ID of the user'),
                'courseid' => new external_value(PARAM_INT, 'ID of the course')
            )
        );
    }

    /**
     * Returns the pseudonym or null.
     * @param $userid
     * @param $courseid
     * @return null|string
     */
    public static function get_pseudonym($userid, $courseid) {

        // Parameters validation.
        $params = self::validate_parameters(self::get_pseudonym_parameters(),
            array('userid' => $userid, 'courseid' => $courseid));

        $uc = new block_pseudolearner_user_controller($params['userid']);

        if ($uc->is_registered() && $uc->get_consent($params['courseid'])) {
            return $uc->get_pseudonym();
        }

        return null;
    }

    /**
     * Returns description of method result value for get_pseudonym
     * @return external_description
     */
    public static function get_pseudonym_returns() {
        return new external_value(PARAM_TEXT, 'Returns the pseudonym or null.');
    }

    /**
     * Returns description of method parameters for has_consent
     * @return external_function_parameters
     */
    public static function has_consent_parameters() {
        return new external_function_parameters(
            array(
                'userid' => new external_value(PARAM_INT, 'ID of the user'),
                'courseid' => new external_value(PARAM_INT, 'ID of the course')
            )
        );
    }

    /**
     * Returns whether user has given consent for the requested course or not.
     * @param $userid
     * @param $courseid
     * @return boolean
     */
    public static function has_consent($userid, $courseid) {

        // Parameters validation.
        $params = self::validate_parameters(self::get_pseudonym_parameters(),
            array('userid' => $userid, 'courseid' => $courseid));

        $uc = new block_pseudolearner_user_controller($params['userid']);

        return $uc->is_registered() && $uc->get_consent($params['courseid']);
    }

    /**
     * Returns description of method result value for has_consent
     * @return external_description
     */
    public static function has_consent_returns() {
        return new external_value(PARAM_BOOL, 'Returns whether user has given consent for the requested course or not.');
    }

    /**
     * Returns description of method parameters for is_registered
     * @return external_function_parameters
     */
    public static function is_registered_parameters() {
        return new external_function_parameters(
            array(
                'userid' => new external_value(PARAM_INT, 'ID of the user')
            )
        );
    }

    /**
     * Returns whether pseudonym is registered for requested user or not.
     * @param $userid
     * @return boolean
     */
    public static function is_registered($userid) {

        // Parameters validation.
        $params = self::validate_parameters(self::is_registered_parameters(),
            array('userid' => $userid));

        $uc = new block_pseudolearner_user_controller($userid);

        return $uc->is_registered();
    }

    /**
     * Returns description of method result value for is_registered
     * @return external_description
     */
    public static function is_registered_returns() {
        return new external_value(PARAM_BOOL, 'Returns whether pseudonym is registered for requested user or not.');
    }
}
