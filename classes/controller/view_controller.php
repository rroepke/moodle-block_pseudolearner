<?php
/**
 * Created by PhpStorm.
 * User: Rene
 * Date: 30.09.2016
 * Time: 15:12
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/pseudolearner/classes/template_builder.php');

class block_pseudolearner_view_controller {

    private $courseid = null;
    private $context = null;
    private $view = null;

    public function __construct($courseid, $context) {
        $this->courseid = $courseid;
        $this->context = $context;
        $this->view = new blocks_pseudolearner_template_builder();
    }

    public function get_instance(){
        global $DB;

        return $DB->get_record("pseudolearner",array("courseid"=>$this->courseid));
    }

    public function render() {
        $this->view->set_template('wrapper_view');
        $this->starttime = 123;

        $this->endtime = 456;

        $buttoncaption = "START";

        $buttondisabled = "";

        $buttonvalue = 1;

        $analysisstatustemplate = new blocks_pseudolearner_template_builder();
        $analysisstatustemplate->set_template('analysis_status');
        $analysisstatustemplate->assign('button',
            array(
                'type' => 'submit',
                'name' => 'questionnaire_switcher',
                'value' => $buttonvalue,
                'state' => $buttondisabled,
                'text' => $buttoncaption
            )
        );
        $analysisstatustemplate->assign('info_teacher', "blub1");
        $analysisstatustemplate->assign('analysis_time_start', $this->starttime);
        $analysisstatustemplate->assign('analysis_time_end', $this->endtime);
        $analysisstatustemplate->assign('analysis_status_info', "blub2");

        $template = $analysisstatustemplate->load_template();

        $this->view->assign('analysis_status_template', $template);

//        echo '<form action="' . htmlspecialchars($_SERVER ["PHP_SELF"]) . '" method="post" autocomplete="off">';
//
//        echo '<input type="hidden" name="id" value="' . $this->courseid . '"/>';
//        echo '<input type="hidden" name="sesskey" value="' . sesskey() . '" />';
//
//        echo "view controller render";
//
//        echo "<br>";
//
//        echo "<button type=\"submit\" name=\"save\" value=\"1\">".get_string("submit")."</button>";
//        echo "<button type=\"submit\" name=\"save\" value=\"0\">".get_string("cancel")."</button>";
//
//        echo '</form>';

        echo $this->view->load_template();
    }
}