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
 * @package block_pseudolearner
 * @author Rene Roepke
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

?>

<div class="pl_pad_content">
    <div class="grid">
        <div class="col_s_100 bp_align_left-middle">
            <div class="pl_align_center">
                <img class="pl_responsive_img"
                     src="pix/id_card2.gif"
                     title="<?php echo get_string('status_id_pic', 'block_pseudolearner');?>"
                >
                <img class="pl_responsive_img_small"
                     src="pix/<?php echo $this->_['link']; ?>.gif"
                     title="<?php echo get_string('status_'.$this->_['link'], 'block_pseudolearner');?>"
                >
                <img class="pl_responsive_img"
                     src="pix/course2.gif"
                     title="<?php echo get_string('status_course_pic', 'block_pseudolearner');?>"
                >
            </div>
        </div>
    </div>
</div>