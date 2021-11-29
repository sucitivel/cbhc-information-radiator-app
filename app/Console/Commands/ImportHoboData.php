<?php

namespace App\Console\Commands;

use App\Interfaces\RoomConstants;
use Illuminate\Console\Command;
use App\Models\HoboData;

class ImportHoboData extends Command implements RoomConstants
{
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
        $this->sftpDir = config('database.connections.hobo.data_dir');
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
            if ($dumpFile === '.' || $dumpFile === '..') {
                continue;
            }
            $this->info('Importing ' . $this->sftpDir . '/' . $dumpFile);
            $this->handleCsv($this->sftpDir . '/' . $dumpFile);
        }
        return Command::SUCCESS;
    }

    public function handleCsv($dumpFile)
    {
        $csv = fopen($dumpFile, 'r');

        $header = fgetcsv($csv); // don't need

        while($row = fgetcsv(($csv))) {
            $insertArray = [];
            foreach(self::ROOMS as $roomReading) {
                $insertArray = array_merge($insertArray, [
                    'room_id'              => $roomReading['room_id'],
                    'time'                 => date('Y-m-d H:i:s', strtotime($row[1])),
                ]);
                try {
                    if ($row[$roomReading['csv_col']]) {
                        (new HoboData())->updateOrCreate(
                            $insertArray,
                            [
                                $roomReading['db_col'] => $row[$roomReading['csv_col']],
                            ]
                        );
                    }
                } catch (\Exception $e) {
                    $this->error($e);
                }

            }
        }

        //unlink($dumpFile);
    }
}
