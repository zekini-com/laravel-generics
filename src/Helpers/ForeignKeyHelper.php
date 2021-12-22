<?php

declare(strict_types=1);

namespace Zekini\Generics\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ForeignKeyHelper
{
    public static function fixPrimaryKey(string $table_name): void
    {
        set_time_limit(0);

        DB::statement('ALTER TABLE ' . $table_name . ' CHANGE COLUMN id id INT UNSIGNED NOT NULL AUTO_INCREMENT ;');
    }

    public static function dropForeignKeys(string $table_name): void
    {
        set_time_limit(0);

        $foreignKeysArray = self::getForeignKeysArray($table_name);

        foreach ($foreignKeysArray as $value) {
            $statement = 'ALTER TABLE ' . $value['table_name'] . ' DROP FOREIGN KEY ' . $value['constraint_name'] . ';';
            logger(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $statement);

            DB::statement($statement);
        }
    }

    public static function createForeignKeys(string $table_name, string $field_name): void
    {
        set_time_limit(0);

        $tablesArray = self::getTableByFieldArray($field_name);

        foreach ($tablesArray as $value) {
            logger(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $value['table_name']);

            if (in_array($value['table_name'], config('foreign-key.ignore_tables'), true)) {
                logger(__CLASS__ . ' ' . __FUNCTION__ . ': Ignoring ' . $value['table_name']);
                continue;
            }

            $index_name = 'fk_' . $value['table_name'] . '_' . $table_name;

            if (! Schema::hasTable($value['table_name'])) {
                continue;
            }

            $statement = 'ALTER TABLE ' . $value['table_name'] . ' DROP INDEX ' . $index_name . '_idx;';

            try {
                DB::statement($statement);
            } catch (\Throwable $th) {
                logger(__CLASS__ . ' ' . __FUNCTION__ . ': Statement failed: ' . $statement);
            }

            self::deleteOrphanedData($table_name, $value['table_name'], $field_name);

            $statement = 'ALTER TABLE ' . $value['table_name'] . ' ADD INDEX ' . $index_name . '_idx (' . $field_name . ' ASC);';

            try {
                DB::statement($statement);
            } catch (\Throwable $th) {
                logger(__CLASS__ . ' ' . __FUNCTION__ . ': Statement failed: ' . $statement);
                continue;
            }

            if ($value['is_nullable'] !== 'NO' || $value['data_type'] !== 'int' || $value['column_type'] !== 'int unsigned') {
                $statement = 'ALTER TABLE ' . $value['table_name'] . ' CHANGE COLUMN ' . $field_name . ' ' . $field_name . ' INT UNSIGNED NOT NULL;';
                logger(__CLASS__ . ' ' . __FUNCTION__ . ': Fk is wrong. Recreating: ' . $statement);
                DB::statement($statement);
            }

            self::setForeignKey($table_name, $value['table_name'], $field_name, $index_name);
        }
    }

    public static function setForeignKey(string $pk_table, string $fk_table, string $field_name, string $index_name = null): void
    {
        set_time_limit(0);

        $index_name = $index_name ?? 'fk_' . $fk_table . '_' . $pk_table;

        $statement = 'ALTER TABLE ' . $fk_table . ' ADD CONSTRAINT ' . $index_name . ' FOREIGN KEY (' . $field_name . ') REFERENCES ' . $pk_table . '  (id) ON DELETE CASCADE ON UPDATE CASCADE;';

        logger(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $statement);

        try {
            DB::statement($statement);
        } catch (\Throwable $th) {
            Log::error($statement);
        }
    }

    private static function getForeignKeysArray($table_name): array
    {
        $return = [];

        $result = DB::select(
            '
            SELECT 
                TABLE_NAME as "table_name",
                CONSTRAINT_NAME as "constraint_name"
            FROM 
                information_schema.key_column_usage 
            WHERE 
                # CONSTRAINT_SCHEMA = TABLE_SCHEMA = "' . config('database.connections.mysql.database') . '" AND 
                referenced_table_name IS NOT NULL
                AND referenced_column_name = "id"
                AND referenced_table_name = :table_name
                ;',
            [
                'table_name' => $table_name,
            ]
        );

        foreach ($result as $value) {
            $return[] = json_decode(json_encode($value), true);
        }

        return $return;
    }

    private static function getTableByFieldArray(string $field_name): array
    {
        $return = [];

        $result = DB::select(
            '
            SELECT 
                TABLE_NAME as "table_name",
                IS_NULLABLE as "is_nullable",
                DATA_TYPE as "data_type",
                COLUMN_TYPE as "column_type"
            FROM 
                information_schema.columns 
            WHERE 
                # TABLE_SCHEMA = "' . config('database.connections.mysql.database') . '" AND 
                COLUMN_NAME = :field_name
                ;',
            [
                'field_name' => $field_name,
            ]
        );

        foreach ($result as $value) {
            $return[] = json_decode(json_encode($value), true);
        }

        return $return;
    }

    private static function deleteOrphanedData(string $pk_table, string $fk_table, string $field_name): void
    {
        set_time_limit(0);

        $statement = 'DELETE FROM ' . $fk_table . ' WHERE ' . $field_name . ' NOT IN (SELECT id FROM ' . $pk_table . ');';

        logger(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $statement);

        DB::statement($statement);
    }
}
