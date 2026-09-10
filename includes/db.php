<?php
/**
 * PDO/SQLite connection. The database file is created and migrated
 * automatically on first request so there is nothing to configure on
 * a fresh install beyond making `data/` writable by the web server.
 */

function get_db(): PDO
{
    static $db = null;
    if ($db !== null) {
        return $db;
    }

    if (!is_dir(DATA_PATH)) {
        mkdir(DATA_PATH, 0775, true);
    }

    $isNew = !file_exists(DB_PATH);

    $db = new PDO('sqlite:' . DB_PATH);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->exec('PRAGMA foreign_keys = ON');

    $schema = file_get_contents(BASE_PATH . '/database/schema.sql');
    $db->exec($schema);

    if ($isNew) {
        require BASE_PATH . '/database/seed.php';
        seed_database($db);
    }

    require_once BASE_PATH . '/database/migrations.php';
    run_migrations($db);

    return $db;
}
