<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HoboDataPoint;

class ImportHoboData extends Command
{
    const ROOMS = [
        1 => [
            'room_id' => 2,
            'csv_col' => 1,
            'db_col'  => 'celcius'
        ],
        2 => [
            'room_id' => 2,
            'csv_col' => 2,
            'db_col'  => 'rh'
        ],
        3 => [
            'room_id' => 3,
            'csv_col' => 3,
            'db_col'  => 'celcius'
        ],
        4 => [
            'room_id' => 3,
            'csv_col' => 4,
            'db_col'  => 'rh'
        ],
        5 => [
            'room_id' => 4,
            'csv_col' => 5,
            'db_col'  => 'celcius'
        ],
        6 => [
            'room_id' => 4,
            'csv_col' => 6,
            'db_col'  => 'rh'
        ],
        7 => [
            'room_id' => 5,
            'csv_col' => 7,
            'db_col'  => 'celcius'
        ],
        8 => [
            'room_id' => 5,
            'csv_col' => 8,
            'db_col'  => 'rh'
        ],
    ];

    protected $sftpDir;

    protected $signature = 'import:hobos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports hobos. The data things.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sftpDir = env('HOBO_DATA_DIR');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $hoboFtpFiles = opendir($this->sftpDir);

        while (false !== ($dumpFile = readdir($hoboFtpFiles))) {
            $this->handleCsv($dumpFile);
        }
        return Command::SUCCESS;
    }

    public function handleCsv($dumpFile)
    {
        $csv = fopen($dumpFile, 'r');

        $header = fgetcsv($csv); // don't need

        while($row = fgetcsv(($csv))) {
            $insertArray = [];
            foreach(self::ROOMS as $csvColumn => $roomReading) {
                $insertArray[self::ROOMS[$csvColumn]['db_col']] = $row[self::ROOMS[$csvColumn]['csv_col']];
            }
            (new HoboDataPoint())->create($insertArray);
        }

        unlink($dumpFile);
    }
}
