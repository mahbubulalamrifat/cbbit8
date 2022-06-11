<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Http\Controllers\Common\ScheduleCheck;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('command:ApplicationMail')
        ->withoutOverlapping()
        //->everyTenMinutes();
        //->everyFiveMinutes()
        ->onFailure(function () { 

            $msg = "Schedule Checker Error";
            \Log::info($msg); 
            ScheduleCheck::ErrorMsgOnLine($msg);
        })
        ->onSuccess(function () {
            $msg = "Schedule Checker Running";
            \Log::info($msg); 
            ScheduleCheck::ErrorMsgOnLine($msg);
        })
        //->everyMinute();
        ->dailyAt('08:30');

        $schedule->command('command:Pendings')
            ->withoutOverlapping()
            ->dailyAt('09:30')
            //->everyMinute();
            ->onFailure(function () { 
                $msg ="Notification Pending Schedule Error";
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
            

        $schedule->command('command:TodayBookedCar')
            ->withoutOverlapping()
            ->dailyAt('08:00')
            ->onFailure(function () { 
                $msg ="TodayBookedCar Schedule Error";
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
            //->everyTenMinutes();
            //->everyFiveMinutes();
            //->everyMinute();

        $schedule->command('command:TodayBookedRoom')
            ->withoutOverlapping()
            ->dailyAt('08:01')
            ->onFailure(function () { 
                $msg ="TodayBookedRoom schedule Error";
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
            //->everyTenMinutes();
            //->everyFiveMinutes();
            //->everyMinute();

       
        $schedule->command('command:MainIpPing')
            ->withoutOverlapping()
            ->everyTenMinutes()
            ->onFailure(function () { 
                $msg ="MainIpPing schedule Error";
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
            //->everyFiveMinutes();
            //->everyMinute();

        $schedule->command('command:HardwareMail')
            ->withoutOverlapping()
            //->everyTenMinutes();
            ->everyFiveMinutes()
            ->onFailure(function () { 
                $msg ="CMS HardwareMail schedule Error";
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
            //->everyMinute();

        $schedule->command('command:ApplicationMail')
            ->withoutOverlapping()
            //->everyTenMinutes();
            ->everyFiveMinutes() 
            ->onFailure(function () { 
                $msg ="CMS ApplicationMail schedule Error";
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
            //->everyMinute();
    
                    




        //***************************************************//
        //***************************************************//
        //********************Start Food *********************//
        //***************************************************//
        //***************************************************//

        // Power BI Schedule     : ( 10:00 AM, 11:00 AM, 12:00 PM, 02:00 PM, 03:00 PM, 04:00 PM, 05:00 PM, 06:00 PM )
        // Local Server Schedule : ( '9:30',   '10:30',  '11:30',  '13:30',  '14:30',  '15:30',  '16:30',  '17:30'  )
        // Data Table            :  BI_FOOD_FURTHER_SALES
                
        foreach (['9:30',   '10:30',  '11:30',  '13:30',  '14:30',  '15:30',  '16:30',  '17:30'] as $time) {
            $schedule->command('command:BI_FOOD_FURTHER_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                $msg ="BI_FOOD_FURTHER_SALES schedule Error at".$time;
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
        }
        $schedule->command('command:BI_FOOD_FURTHER_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { 
            $msg ="BI_FOOD_FURTHER_SALES_Daily schedule Error";
            \Log::info($msg);
            ScheduleCheck::ErrorMsgOnLine($msg);
        });














        // Power BI Schedule     : ( 08:00 AM, 10:30 AM, 12:00 PM, 02:00 PM, 03:30 PM, 05:00 PM, 07:00 PM, 11:00 PM )
        // Local Server Schedule : ( '7:30',   '10:00',  '11:30',  '13:30',  '15:00',  '16:30',  '18:30',  '22:30'  )
        // Data Table            :  BI_FEED_SALES
        //                          BI_FEED_PURCHASE

        // BI_FEED_SALES
        // '9:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'
        foreach (['7:30',   '10:00',  '11:30',  '13:30',  '15:00',  '16:30',  '18:30',  '22:30'] as $time) {
            $schedule->command('command:BI_FEED_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                $msg ="BI_FEED_SALES schedule Error at".$time;
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
        }
        $schedule->command('command:BI_FEED_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () {  
            $msg ="BI_FEED_SALES_Daily schedule Error";
            \Log::info($msg);
            ScheduleCheck::ErrorMsgOnLine($msg);
        });
      
     

        // BI_FEED_PURCHASE
        foreach (['7:30',   '10:00',  '11:30',  '13:30',  '15:00',  '16:30',  '18:30',  '22:30'] as $time) {
            $schedule->command('command:BI_FEED_PURCHASE')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                $msg ="BI_FEED_PURCHASE schedule Error at".$time;
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
        }
        $schedule->command('command:BI_FEED_PURCHASE_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () {  
            $msg ="BI_FEED_PURCHASE_Daily schedule Error";
            \Log::info($msg);
            ScheduleCheck::ErrorMsgOnLine($msg);
        });










        // Power BI Schedule     : ( 04:00 AM, 09:00 AM, 10:00 AM, 11:00 PM, 12:30 PM, 03:00 PM, 04:00 PM, 05:00 PM )
        // Local Server Schedule : ( '03:30',  '08:30',  '09:30',  '10:30',  '12:00',  '14:30',  '15:30',  '16:30'  )
        // Data Table            :  BI_FARM_POULTRY_SALES

        foreach (['03:30',  '08:30',  '09:30',  '10:30',  '12:00',  '14:30',  '15:30',  '16:30'] as $time) {
            $schedule->command('command:BI_FARM_POULTRY_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                $msg ="BI_FARM_POULTRY_SALES schedule Error at".$time;
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
        }
        $schedule->command('command:BI_FARM_POULTRY_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { 
            $msg ="BI_FARM_POULTRY_SALES_Daily schedule Error";
            \Log::info($msg);
            ScheduleCheck::ErrorMsgOnLine($msg);
        });










        // Power BI Schedule     : ( 01:00 AM, 06:00 AM, 10:00 AM, 02:00 PM, 04:00 PM, 06:00 PM, 08:00 PM, 10:00 PM )
        // Local Server Schedule : ( '00:30', '05:30', '09:30', '13:30', '15:30', '17:30', '19:30', '21:30'  )
        // Data Table            :  BI_FOOD_SLAUGHTER_SALES
        foreach (['00:30', '05:30', '09:30', '13:30', '15:30', '17:30', '19:30', '21:30'] as $time) {
            $schedule->command('command:BI_FOOD_SLAUGHTER_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                $msg ="BI_FOOD_SLAUGHTER_SALES schedule Error at".$time;
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
        }
        $schedule->command('command:BI_FOOD_SLAUGHTER_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () {  
            $msg ="BI_FOOD_SLAUGHTER_SALES_Daily schedule Error";
            \Log::info($msg);
            ScheduleCheck::ErrorMsgOnLine($msg);
        });











        // Power BI Schedule     : ( 10:00 AM, 11:00 AM, 12:00 PM, 02:00 PM, 03:00 PM, 04:00 PM, 05:00 PM, 06:00 PM )
        // Local Server Schedule : ( '9:30',   '10:30',  '11:30',  '13:30',  '14:30',  '15:30',  '16:30',  '17:30'  )
        // Data Table            :  BI_FARM_AQUA_SALES
        //                          BI_FARM_AQUA_PURCHASE
        //                          BI_FARM_POULTRY_PURCHASE
        //                          BI_EXPENSE

        // BI_FARM_AQUA_SALES
        foreach (['9:30',   '10:30',  '11:30',  '13:30',  '14:30',  '15:30',  '16:30',  '17:30'] as $time) {
            $schedule->command('command:BI_FARM_AQUA_SALES')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                $msg ="BI_FARM_AQUA_SALES schedule Error at".$time;
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
        }
        $schedule->command('command:BI_FARM_AQUA_SALES_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () {
            $msg ="BI_FARM_AQUA_SALES_Daily schedule Error";
            \Log::info($msg);
            ScheduleCheck::ErrorMsgOnLine($msg);
        });


         // BI_FARM_POULTRY_PURCHASE
         foreach (['9:30',   '10:30',  '11:30',  '13:30',  '14:30',  '15:30',  '16:30',  '17:30'] as $time) {
            $schedule->command('command:BI_FARM_POULTRY_PURCHASE')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                $msg ="BI_FARM_POULTRY_PURCHASE schedule Error at".$time;
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
        }
        $schedule->command('command:BI_FARM_POULTRY_PURCHASE_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () {
            $msg ="BI_FARM_POULTRY_PURCHASE_Daily schedule Error";
            \Log::info($msg);
            ScheduleCheck::ErrorMsgOnLine($msg);
        });



        // BI_EXPENSE
        foreach (['9:30',   '10:30',  '11:30',  '13:30',  '14:30',  '15:30',  '16:30',  '17:30'] as $time) {
            $schedule->command('command:BI_EXPENSE')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                $msg ="BI_EXPENSE schedule Error at".$time;
                \Log::info($msg);
                ScheduleCheck::ErrorMsgOnLine($msg);
            });
        }
        $schedule->command('command:BI_EXPENSE_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { 
            $msg ="BI_EXPENSE_Daily schedule Error";
            \Log::info($msg);
            ScheduleCheck::ErrorMsgOnLine($msg);
        });










        // Power BI Schedule     : ( 08:30 AM, 10:30 AM, 12:30 PM, 02:30 PM, 04:30 PM, 06:30 PM, 08:30 PM, 10:30 PM )
        // Local Server Schedule : ( '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00' )
        // Data Table            :  BI_FEED_PRODUCTION

        foreach (['08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'] as $time) {
            $schedule->command('command:BI_FEED_PRODUCTION')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FEED_PRODUCTION schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FEED_PRODUCTION_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FEED_PRODUCTION_Daily schedule Error"); });










        // BI_FARM_AQUA_PURCHASE
        foreach (['9:30', '10:30', '11:30', '13:30', '14:30', '15:30', '16:30', '17:30'] as $time) {
            $schedule->command('command:BI_FARM_AQUA_PURCHASE')->dailyAt($time)->withoutOverlapping()->onFailure(function () {
                \Log::info("BI_FARM_AQUA_PURCHASE schedule Error at".$time);
            });
        }
        $schedule->command('command:BI_FARM_AQUA_PURCHASE_Daily')
        ->daily()->withoutOverlapping()->onFailure(function () { \Log::info("BI_FARM_AQUA_PURCHASE_Daily schedule Error"); });





      
        // Power BI Schedule     : ( 12:00 AM )
        // Local Server Schedule : ( '23:30' )
        // Data Table            :  BI_MAP_UNIT_LEVEL 
        $schedule->command('command:MAP_UNIT_LEVEL_Daily')
        //->daily()
        //->everyMinute()
        ->dailyAt('23:30')
        ->onFailure(function () {
                \Log::info("MAP_UNIT_LEVEL_Daily schedule Error");
            });





        










        



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
