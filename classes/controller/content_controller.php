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

class block_pseudolearner_content_controller {

    private $courseid = null;
    private $context = null;

    public function __construct($courseid, $context) {
        $this->courseid = $courseid;
        $this->context = $context;
    }

    public function get_instance() {
        global $DB;

        return $DB->get_record("block_pseudolearner", array("courseid" => $this->courseid));
    }

    public function get_content() {
        $content = new stdClass();
        if (has_capability('moodle/block:edit', $this->context)) {
            if (!$instance = $this->get_instance()) {
                $content->text = "can edit settings & has no instance";
            } else {
                $content->text = "can edit settings & has instance";
                $content->footer = "<a href=\"" . $this->get_link("config_view") . "\"><button>CONFIGURE ME</button></a>";
            }
        } else {
            if (!$instance = $this->get_instance()) {
                $content->text = "Not configured yet.";
            } else {
                $content->text = "cannot edit settings & has instance";
                $content->footer = "<a href=\"" . $this->get_link("view") . "\"><button>MANAGE</button></a>";
            }
        }

        return $content;
    }

    public function get_link($page) {
        $url = new moodle_url("/blocks/pseudolearner/" . $page . ".php",
            array("id" => $this->courseid, 'show' => 'view'));
        return $url->out();
    }
}