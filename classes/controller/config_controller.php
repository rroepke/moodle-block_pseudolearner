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
 * Class block_pseudolearner_config_controller
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/instance.php');


class block_pseudolearner_config_controller {

    private $courseid = null;
    private $context = null;

    public function __construct($courseid, $context) {
        $this->courseid = $courseid;
        $this->context = $context;
        $this->instance = new block_pseudolearner_instance($courseid);
    }

    public function render() {

        echo '<form action="' . htmlspecialchars($_SERVER ["PHP_SELF"]) . '" method="post" autocomplete="off">';

        echo '<input type="hidden" name="id" value="' . $this->courseid . '"/>';
        echo '<input type="hidden" name="sesskey" value="' . sesskey() . '" />';

        echo "config controller render";

        echo "<br>";

        echo "<button type=\"submit\" name=\"save\" value=\"1\">".get_string("submit")."</button>";
        echo "<button type=\"submit\" name=\"save\" value=\"0\">".get_string("cancel")."</button>";

         echo '</form>';
    }

    public function save() {
        $this->instance->set_configured(true);
    }
}