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
 * Class block_pseudolearner
 *
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/content_controller.php');

class block_pseudolearner extends block_base {

    /**
     * Init function
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_pseudolearner');
    }

    /**
     * On deletion of instance
     *
     * @return bool
     */
    public function instance_delete() {
        global $DB;
        $courseid = $this->page->course->id;

        $DB->delete_records('block_pseudolearner', array('courseid' => $courseid));
        $DB->delete_records('block_pseudolearner_u_course', array('courseid' => $courseid));
        $DB->delete_records('block_pseudolearner_request', array('courseid' => $courseid));

        return true;
    }

    /**
     * On creation of instance
     *
     * @return bool
     */
    public function instance_create() {
        global $DB;
        $courseid = $this->page->course->id;
        $record = new stdClass();
        $record->courseid = $courseid;
        $DB->insert_record('block_pseudolearner', $record);
        return true;
    }

    /**
     * Returns content object
     *
     * @return stdClass|stdObject|string
     */
    public function get_content() {
        global $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        // User/index.php expect course context, so get one if page has module context.
        $currentcontext = $this->page->context->get_course_context(false);

        $this->content = new stdClass();
        $this->content->text = get_string('content_notconfigured_notifyadmin','block_pseudolearner');

        if (empty($currentcontext) || empty(get_config('pseudolearner','servicename')) || empty(get_config('pseudolearner','url')) || empty(get_config('pseudolearner','securitytoken')) ){
            return $this->content;
        }

        $courseid = $this->page->course->id;

        $controller = new block_pseudolearner_content_controller($courseid, $currentcontext, $this->config);
        $this->content = $controller->get_content($USER->id);

        return $this->content;
    }

    public function applicable_formats() {
        return array('all' => false,
                     'site' => true,
                     'site-index' => true,
                     'course-view' => true,
                     'course-view-social' => false,
                     'mod' => true,
                     'mod-quiz' => false);
    }

    public function instance_allow_multiple() {
          return false;
    }

    public function has_config() {
        return true;
    }
}
