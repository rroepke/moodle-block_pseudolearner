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
 * view
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/view_controller/view_controller.php');
require_once($CFG->dirroot . '/blocks/pseudolearner/classes/util/communication_handler.php');

$ciphertext = required_param('ciphertext', PARAM_TEXT);
$code = required_param('code', PARAM_TEXT);
$mac = required_param('mac', PARAM_TEXT);

$url = get_config('pseudolearner', 'url');
$key = get_config('pseudolearner', 'securitytoken');
$cipher = get_config('pseudolearner', 'cipher');
if (empty($cipher)) {
    $cipher = 'AES-256-CBC';
}
if (empty($hash)) {
    $hash = 'sha256';
}
$hash = get_config('pseudolearner', 'hash');

$userid = $USER->id;

$comhandler = new block_pseudolearner_communication_handler($key, $cipher, $hash, $userid);
$params = $comhandler->decrypt_data($ciphertext);
$comhandler->validate_response_params($params, $code);
$comhandler->verify_hmac($mac, $params);

$code = $params->code;

if ($code == $comhandler::CODE_SUCCESS) {

    $currenttimestamp = time();
    if (!property_exists($params, 'timestamp') || $currenttimestamp - 60 * 10 > $params->timestamp) {
        var_dump("cipher invalid");
    }

    $pseudonym = $params->pseudonym;

    $usercontroller = new block_pseudolearner_user_controller($userid);

    var_dump($pseudonym);
    
    $usercontroller->register_pseudonym($pseudonym);

    $courseid = $comhandler->get_courseid_of_last_request();

    $url = new moodle_url('pseudonym_view.php', array('id' => $courseid, 'show' => 'pseudonym', 'code'=>'success'));
    redirect($url);

} else if ($code == $comhandler::CODE_FAIL) {

    $courseid = $comhandler->get_courseid_of_last_request();

    $url = new moodle_url('view.php', array('id' => $courseid, 'show' => 'overview', 'code'=>'danger'));
    redirect($url);

} else {
    throw new moodle_exception('code invalid');
}