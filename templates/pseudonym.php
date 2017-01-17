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
        <div class="col_m_100 bp_align_left-middle pl_align_center">
            <div class="pl_align_center pl_v_align_child">
                <img class="pl_responsive_img" src="pix/id_card2.gif">
            </div>
        </div>
        <div class="col_m_100 bp_align_left-middle">
            <div class="pl_align_center">
                <div class="grid row_highlight bp_align_left-middle">
                    <div class="col_m_100">
                        <b>
                            <?php echo get_string('pseudonym_your_name', 'block_pseudolearner') . ': '; ?>
                        </b>
                        <?php echo $this->_['user_fullname']; ?>
                    </div>
                </div>
                <div class="grid row_highlight">
                    <div class="col_m_100 bp_align_left-middle">
                        <b>
                            <?php echo get_string('pseudonym_registered', 'block_pseudolearner') . ': '; ?>
                        </b>
                        <?php echo $this->_['date_registered']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>