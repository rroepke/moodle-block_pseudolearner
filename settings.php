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
 * pseudolearner block settings
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$a = new stdClass();

$url = new moodle_url('/blocks/pseudolearner/register_pseudonym.php');
$a->url = $url->out();

$settings->add(new admin_setting_heading('sampleheader',
                                         get_string('config_header', 'block_pseudolearner'),
                                         get_string('config_description', 'block_pseudolearner', $a)));

$settings->add(new admin_setting_configtext('pseudolearner/servicename',
    get_string('config_label_servicename', 'block_pseudolearner'),
    get_string('config_description_servicename', 'block_pseudolearner'),
    null));

$settings->add(new admin_setting_configtext('pseudolearner/url',
                                                get_string('config_label_url', 'block_pseudolearner'),
                                                get_string('config_description_url', 'block_pseudolearner'),
                                                null));

$settings->add(new admin_setting_configtext('pseudolearner/securitytoken',
    get_string('config_label_securitytoken', 'block_pseudolearner'),
    get_string('config_description_securitytoken', 'block_pseudolearner'),
    null));

$settings->add(new admin_setting_configtext('pseudolearner/cipher',
    get_string('config_label_cipher', 'block_pseudolearner'),
    get_string('config_description_cipher', 'block_pseudolearner'),
    'AES-256-CBC'));

$settings->add(new admin_setting_configtext('pseudolearner/hash',
    get_string('config_label_hash', 'block_pseudolearner'),
    get_string('config_description_hash', 'block_pseudolearner'),
    'sha256'));