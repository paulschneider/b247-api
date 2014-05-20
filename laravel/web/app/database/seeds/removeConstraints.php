<?php

class removeConstraints extends seeder
{
    public function run()
    {
        ##################################################################################### Channel category

        DB::table('channel_category')->delete();

        $statement = "ALTER TABLE channel_category AUTO_INCREMENT = 1;";

        DB::unprepared($statement);

        ##################################################################################### Channel and sub-channel

        DB::table('channel')->whereNotNull('parent_channel')->delete();
        DB::table('channel')->delete();

        $statement = "ALTER TABLE channel AUTO_INCREMENT = 1;";

        DB::unprepared($statement);

        ##################################################################################### Channel Categories

        DB::table('channel_category')->delete();

        $statement = "ALTER TABLE channel_category AUTO_INCREMENT = 1;";

        DB::unprepared($statement);

        ##################################################################################### Categories

        DB::table('category')->delete();

        $statement = "ALTER TABLE category AUTO_INCREMENT = 1;";

        DB::unprepared($statement);

        ##################################################################################### Users

        DB::table('user')->delete();

        $statement = "ALTER TABLE user AUTO_INCREMENT = 1;";

        DB::unprepared($statement);
    }
}
