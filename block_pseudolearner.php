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
 * pseudolearner block caps.
 *
 * @package    block_pseudolearner
 * @copyright  Daniel Neis <danielneis@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/controller/content_controller.php');

class block_pseudolearner extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_pseudolearner');
    }

    function instance_delete() {
        global $DB;
        $courseid = $this->page->course->id;
        $DB->delete_records('pseudolearner',array('courseid'=>$courseid));
        return true;
    }

    function instance_create() {
        global $DB;
        $courseid = $this->page->course->id;
        $record = new stdClass();
        $record->courseid = $courseid;
        $DB->insert_record('pseudolearner',$record);
        return true;
    }

    function get_content() {
        global $CFG, $OUTPUT, $USER;

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

        // user/index.php expect course context, so get one if page has module context.
        $currentcontext = $this->page->context->get_course_context(false);

        if (! empty($this->config->text)) {
            $this->content->text = $this->config->text;
        }

        $this->content = new stdClass();
        $this->content->text = "Not configured yet";
        if (empty($currentcontext)) {
            return $this->content;
        }

        $courseid = $this->page->course->id;

        if ($courseid == SITEID) {
            $this->content->text .= "site context";
        }

        $controller = new block_pseudolearner_content_controller($courseid, $currentcontext);
        $this->content = $controller->get_content($USER->id);

        return $this->content;
    }

    // my moodle can only have SITEID and it's redundant here, so take it away
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

    function has_config() {return true;}

    public function cron() {
            mtrace( "Hey, my cron script is running" );
             
                 // do something
                  
                      return true;
    }
}
