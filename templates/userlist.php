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

global $USER;
?>

<div class="pl_pad_content">
    <form action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]); ?>" method="post" autocomplete="off">
        <input type="hidden" name="id" value="<?php echo $this->_['id']; ?>"/>
        <input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>"/>
        <input type="hidden" name="show" value="courses"/>
        <?php foreach ($this->_['users'] as $user): ?>
            <div class="grid row_highlight">
                <div class="col_m_75">
                    <img class="pl_responsive_img_tiny"
                         src="pix/<?php echo ($user->consent) ? 'link_green' : 'link_red'; ?>.gif">
                    <b>
                        <a href="<?php echo $user->url; ?>">
                            <?php echo fullname($user->user); ?>
                        </a>
                        <?php echo (($user->userid == $USER->id) ? " " . get_string('userlist_you', 'block_pseudolearner') : ""); ?>
                    </b>

                </div>
            </div>
        <?php endforeach; ?>
    </form>
</div>