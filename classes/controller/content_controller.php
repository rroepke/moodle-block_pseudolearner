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
 * Class block_pseudolearner_content_controller
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/user_controller.php');

class block_pseudolearner_content_controller {

    /** @var int ID of course */
    private $courseid = null;
    /** @var null context of current page */
    private $context = null;

    /**
     * block_pseudolearner_content_controller constructor.
     * @param $courseid
     * @param $context
     */
    public function __construct($courseid, $context) {
        $this->courseid = $courseid;
        $this->context = $context;
    }

    /**
     * Returns instance
     *
     * @return mixed
     */
    public function get_instance() {
        global $DB;

        return $DB->get_record("block_pseudolearner", array("courseid" => $this->courseid));
    }

    /**
     * Returns block content
     *
     * @param $userid ID of the user
     * @return stdClass
     */
    public function get_content($userid) {
        $content = new stdClass();
        $content->text = "";
        if (has_capability('moodle/block:edit', $this->context)) {
            $content = $this->get_teacher_content($userid, $content);
        } else {
            $content = $this->get_user_content($userid, $content);
        }

        return $content;
    }

    /**
     * Returns link to a page
     *
     * @param $page
     * @return string
     */
    public function get_link($page, $show = 'view') {
        $url = new moodle_url("/blocks/pseudolearner/" . $page . ".php",
            array("id" => $this->courseid, 'show' => $show));
        return $url->out();
    }

    /**
     * Returns content for user
     *
     * @param $content
     * @return mixed
     */
    public function get_user_content($userid, $content) {

        $uc = new block_pseudolearner_user_controller($userid, $this->courseid);

        $pseudonym = $uc->is_registered();
        $consent = $uc->get_consent();

        $text = "";

        // Pseudonym registration info.
        $text .= "<p>";
        $text .= get_string('content_pseudonym', 'block_pseudolearner');
        $text .= "<br>";
        $text .= "<span class=\"label label-";
        $text .= ($pseudonym ? "success" : "default");
        $text .= "\">";
        if ($pseudonym) {
            $text .= get_string('content_registered', 'block_pseudolearner');
        } else {
            $text .= get_string('content_notregistered', 'block_pseudolearner');
        }

        $text .= "</span>";
        $text .= "<br>";
        $text .= "</p>";

        // Pseudonymous tracking info.
        $text .= "<p>";
        $text .= get_string('content_anonymous_tracking', 'block_pseudolearner');
        $text .= "<br>";
        $text .= "<span class=\"label label-";
        $text .= ($consent ? "success" : "default");
        $text .= "\">";
        if ($consent) {
            $text .= get_string('content_activated', 'block_pseudolearner');
        } else {
            $text .= get_string('content_notactivated', 'block_pseudolearner');
        }
        $text .= "</span>";
        $text .= "<br>";
        $text .= "</p>";

        // 'View' .
        $text .= "<p>";
        $text .= "<a href=\"";
        $text .= $this->get_link("view");
        $text .= "\">";
        $text .= "<button class=\"btn btn-default\">";
        $text .= get_string("view");
        $text .= "</button>";
        $text .= "</a>";
        $text .= "</p>";

        $content->text .= $text;

        return $content;
    }

    /**
     * Returns content for teacher
     *
     * @param $userid
     * @param $content
     * @return mixed
     */
    private function get_teacher_content($userid, $content) {

        $content = $this->get_user_content($userid, $content);

        // 'Settings' button.
        $text  = "<p>";
        $text .= "<a href=\"";
        $text .= $this->get_link("settings_view","settings");
        $text .= "\">";
        $text .= "<button class=\"btn btn-default\">";
        $text .= get_string("settings");
        $text .= "</button>";
        $text .= "</a>";
        $text .= "</p>";

        $content->text .= $text;

        return $content;
    }
}