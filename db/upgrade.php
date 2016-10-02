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
 * Upgrade function for database changes
 *
 * @package mod_groupformation
 * @author Eduard Gallwas, Johannes Konert, Rene Roepke, Nora Wester, Ahmed Zukic
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die ();
/**
 * Execute groupformation upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_block_pseudolearner_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2016093000) {

        // Rename field course on table pseudolearner to NEWNAMEGOESHERE.
        $table = new xmldb_table('pseudolearner');
        $field = new xmldb_field('course', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, 'id');

        // Launch rename field course.
        $dbman->rename_field($table, $field, 'courseid');

        // Pseudolearner savepoint reached.
        upgrade_block_savepoint(true, 2016093000, 'pseudolearner');
    }

    if ($oldversion < 2016100200) {

        // Define field configured to be added to pseudolearner.
        $table = new xmldb_table('pseudolearner');
        $field = new xmldb_field('configured', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'courseid');

        // Conditionally launch add field configured.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Pseudolearner savepoint reached.
        upgrade_block_savepoint(true, 2016100200, 'pseudolearner');
    }


    return true;
}
