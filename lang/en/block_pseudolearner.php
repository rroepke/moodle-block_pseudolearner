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
 * Language file
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['blockstring'] = 'Block string';
$string['config_header'] = 'Pseudonymity Provider';
$string['config_description'] = 'Before configuring the Pseudonymity Provider, this Moodle instance needs to be registered at the Pseudonymity Provider. When registering this Moodle instance the following Return URL should be used: <p style="margin-left:1em;"><b>{$a->url}</b></p>Now the respective settings given by the Pseudonymity Provider need to be configured in what follows.';
$string['config_label_url'] = 'URL';
$string['config_description_url'] = 'URL to redirect to, if users want to register a pseudonym';
$string['config_label_servicename'] = 'Service Name';
$string['config_description_servicename'] = 'Service name registered at the Pseudonymity Provider';
$string['config_label_securitytoken'] = 'Secret Key';
$string['config_description_securitytoken'] = 'Token is for secure communications between Moodle and the Pseudonymity Provider';
$string['config_label_cipher'] = 'Cipher Suite';
$string['config_description_cipher'] = 'Cipher that is used to encrypt/decrypt data';
$string['config_label_hash'] = 'Hash Function';
$string['config_description_hash'] = 'Hash function that is used to compute Message Authentication Codes of the data';
$string['pseudolearner:addinstance'] = 'Add the PseudoLearner block';
$string['pseudolearner:myaddinstance'] = 'Add the PseudoLearner block to my moodle';
$string['pluginname'] = 'PseudoLearner';
$string['language'] = 'en';
$string['page_title_view'] = 'Overview';
$string['page_title_pseudonym'] = 'Pseudonym';
$string['page_title_courses'] = 'Courses';
$string['page_title_settings'] = 'Settings';
$string['page_sub_header_options'] = 'Options';
$string['page_sub_header_courselist'] = 'Other Courses';

$string['content_notconfigured_notifyadmin'] = 'The plugin is not properly configured. Please notify administrator';
$string['content_pseudonym'] = 'Pseudonym';
$string['content_anonymous_tracking'] = 'Pseudonymous Tracking';
$string['content_registered'] = 'REGISTERED';
$string['content_notregistered'] = 'NOT REGISTERED';
$string['content_activated'] = 'ACTIVATED';
$string['content_notactivated'] = 'NOT ACTIVATED';

$string['pseudonym_your_name'] = 'Your name';
$string['pseudonym_registered'] = 'Registered';
$string['pseudonym_registration_success'] = 'You have successfully registered your pseudonym!';
$string['pseudonym_registration_danger'] = 'No pseudonym was registered.';

$string['userlist_you'] = "(This is you)";

$string['button_caption_register_pseudonym'] = 'Register pseudonym';
$string['button_caption_delete_pseudonym'] = 'Delete pseudonym';
$string['button_caption_view_pseudonym'] = 'View pseudonym';
$string['button_caption_view_courses'] = 'View courses';
$string['button_caption_view_settings'] = 'View settings';
$string['button_caption_give_consent'] = 'Give consent';
$string['button_caption_withdraw_all_consent'] = 'Withdraw total consent';
$string['button_caption_give_all_consent'] = 'Give total consent';
$string['button_caption_withdraw_consent'] = 'Withdraw consent';
$string['button_description_register_pseudonym'] = 'Click here to register a pseudonym which can be used for tracking your learning data.';
$string['button_description_delete_pseudonym'] = 'Click here to delete your currently registered pseudonym. This way, all courses stop tracking learning data with this pseudonym.';
$string['button_description_view_pseudonym'] = 'Click here to see more details about your registered pseudonym in Moodle.';
$string['button_description_view_courses'] = 'Click here to see an overview about all courses and their current tracking status.';
$string['button_description_view_settings'] = 'Click here to see settings of the plugin in this course.';
$string['button_description_withdraw_consent'] = 'Click here to withdraw your consent for tracking learning data with your pseudonym in this course.';
$string['button_description_give_consent'] = 'Click here to give your consent for tracking learning data with your pseudonym in this course.';
$string['button_description_withdraw_all_consent'] = 'Click here to withdraw your consent for tracking learning data with your pseudonym in all courses.';
$string['button_description_give_all_consent'] = 'Click here to give your consent for tracking learning data with your pseudonym in all courses.';
$string['button_description_withdraw_all_users_consent'] = 'Click here to withdraw the consent of all users for tracking learning data with their pseudonyms.';

$string['status_link_red'] = 'Pseudonymous tracking not activated';
$string['status_link_green'] = 'Pseudonymous tracking activated';
$string['status_link_grey'] = 'No pseudonym registered';
$string['status_id_pic'] = 'Pseudonymous identity';
$string['status_course_pic'] = 'Current course';