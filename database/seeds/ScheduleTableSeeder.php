<?php

use Illuminate\Database\Seeder;
use App\Schedule;

class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedule = new Schedule();
        $schedule->day = "2019-03-07";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "1";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-08";
        $schedule->hour = "08:00:00";
        $schedule->instructor_id = "2";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-09";
        $schedule->hour = "12:00:00";
        $schedule->instructor_id = "3";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-10";
        $schedule->hour = "18:00:00";
        $schedule->instructor_id = "4";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-11";
        $schedule->hour = "16:00:00";
        $schedule->instructor_id = "5";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-12";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "6";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-13";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "7";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-09";
        $schedule->hour = "12:00:00";
        $schedule->instructor_id = "3";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-10";
        $schedule->hour = "18:00:00";
        $schedule->instructor_id = "4";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-11";
        $schedule->hour = "16:00:00";
        $schedule->instructor_id = "5";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-12";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "6";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-13";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "7";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-07";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "8";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-08";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "9";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-08";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "9";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();
    }
}