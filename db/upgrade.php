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
 * @package block_pseudolearner
 * @author Rene Roepke
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

        // Rename field course on table pseudolearner to courseid.
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

    if ($oldversion < 2016100201) {

        // Define table pseudolearner_users to be created.
        $table = new xmldb_table('pseudolearner_user');

        // Adding fields to table pseudolearner_users.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table pseudolearner_users.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for pseudolearner_users.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table pseudolearner_user_course to be created.
        $table = new xmldb_table('pseudolearner_user_course');

        // Adding fields to table pseudolearner_user_course.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table pseudolearner_user_course.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for pseudolearner_user_course.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Pseudolearner savepoint reached.
        upgrade_block_savepoint(true, 2016100201, 'pseudolearner');
    }

    if ($oldversion < 2016100300) {

        // Define table pseudolearner to be renamed to block_pseudolearner.
        $table = new xmldb_table('pseudolearner');

        // Launch rename table for pseudolearner.
        $dbman->rename_table($table, 'block_pseudolearner');

        // Define table pseudolearner_user to be renamed to block_pseudolearner_user.
        $table = new xmldb_table('pseudolearner_user');

        // Launch rename table for pseudolearner_user.
        $dbman->rename_table($table, 'block_pseudolearner_user');

        // Define table pseudolearner_user_course to be renamed to block_pseudolearner_u_coursee.
        $table = new xmldb_table('pseudolearner_user_course');

        // Launch rename table for pseudolearner_user_course.
        $dbman->rename_table($table, 'block_pseudolearner_u_course');

        // Pseudolearner savepoint reached.
        upgrade_block_savepoint(true, 2016100300, 'pseudolearner');
    }

    if ($oldversion < 2016100301) {

        // Define field consent to be added to block_pseudolearner_u_course.
        $table = new xmldb_table('block_pseudolearner_u_course');
        $field = new xmldb_field('consent', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'courseid');

        // Conditionally launch add field consent.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Pseudolearner savepoint reached.
        upgrade_block_savepoint(true, 2016100301, 'pseudolearner');
    }

    if ($oldversion < 2016100400) {

        // Define field registered to be added to block_pseudolearner_user.
        $table = new xmldb_table('block_pseudolearner_user');
        $field = new xmldb_field('registered', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'userid');

        // Conditionally launch add field registered.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Pseudolearner savepoint reached.
        upgrade_block_savepoint(true, 2016100400, 'pseudolearner');
    }



    return true;
}
