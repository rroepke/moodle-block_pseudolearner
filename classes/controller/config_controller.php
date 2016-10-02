<?php
/**
 * Created by PhpStorm.
 * User: Rene
 * Date: 30.09.2016
 * Time: 15:12
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