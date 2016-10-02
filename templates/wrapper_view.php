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

<link href="styles.css" rel="stylesheet">
<div class="pl_settings_pad">
    <div class="pl_pad_header">
        <?php echo "Overview"; ?>
    </div>
    <div class="pl_pad_content">
        <?php echo $this->_['analysis_status_template']; ?>
    </div>

    <div class="pl_pad_header_small">
        <?php echo "Current status"; ?>
    </div>
    <div class="pl_pad_content">
        <?php // echo $this->_['analysis_statistics_template']; ?>
    </div>
</div>