<?php

namespace Demo\Database;

use SQLite3;

/**
 * Simple Wrapper to init and close the sqlite DB connection
 */
class DB
{
    protected static SQLite3|null $db;

    /**
     * Open database connection, and create table if not exists
     *
     */
    public static function init(): void
    {
        try {
            $db = new SQLite3(ROOT.'/data/db.sqlite');
            $db->enableExceptions(true);

            $table_exists = function () use ($db) {
                $result = $db->query(
                    "SELECT count(*) as table_exists FROM sqlite_master WHERE type='table' AND name='existing_pins';"
                );
                $result = $result->fetchArray();
                return $result['table_exists'] === 1;
            };
        
            if ($table_exists() === false) {
                $db->exec('CREATE TABLE existing_pins (pin INTEGER UNIQUE)');
            }
        
            self::$db = $db;
        } catch (\Throwable $th) {
            $db->close();
            throw $th;
        }
    }

    /**
     * Get the connection
     *
     * @return SQLite3
     */
    public static function get(): SQLite3|null
    {
        return self::$db;
    }
    
    /**
     * Close the sqlite connection
     *
     * @return void
     */
    public static function close(): void
    {
        try {
            self::$db->close();
            self::$db = null;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
