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
?>
<div class="grid">
    <form action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]); ?>" method="post" autocomplete="off">
        <input type="hidden" name="id" value="<?php echo $this->_['id']; ?>"/>
        <input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>" />
        <input type="hidden" name="show" value="view" />
        <?php foreach($this->_['buttons'] as $button): ?>
            <div class="grid bottom_stripe">
                <div class="col_m_33 bp_align_left-middle">
                    <button
                        type="submit"
                        name="<?php echo $button['name']; ?>"
                        value="<?php echo $button['value']; ?>"
                        class="pl_button pl_button_pill pl_button_large"
                    >
                        <?php echo $button['caption']; ?>
                    </button>
                </div>
                <div class="col_m_66">
                    <?php echo $button['description']; ?>
                </div>
            </div>

        <?php endforeach; ?>
    </form>
</div>
