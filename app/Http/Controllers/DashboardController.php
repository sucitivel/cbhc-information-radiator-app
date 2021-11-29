<?php
namespace App\Http\Controllers;

use App\Interfaces\RoomConstants;
use Google\Service\Sheets as gSheets;
use Illuminate\Http\Request;
use App\Library\GoogleApi;

class DashboardController extends Controller implements RoomConstants
{
    private $filterMap = [
        3 => [
            'Room 2',
            'Room 3',
        ],
        4 => [
            'Room 7',
            'Room 8',
        ],
        5 => [
            'Room 5',
            'Room 6',
        ],
    ];

    public function index(Request $request)
    {
        $client = $request->gClient;
        $client->setScopes(gSheets::SPREADSHEETS_READONLY);
        $service = new gSheets($client);

        $spreadsheetId = '1_BQ4VZQcnQpjUVx6MnXAx6Xb77aRezFqtQ0JZfllSto';
        $checklistTab = 'Daily Grow Checklists';
        $harvestAndLoadingTab = 'Loading and Harvest';
        $harvestAndLoadingRange = 'E6:G75';
        $checklistRange = 'A2:C57';

        $checklistData = $service->spreadsheets_values->get($spreadsheetId, $checklistTab . '!' . $checklistRange);
        $harvestAndLoadingData = $service->spreadsheets_values->get($spreadsheetId, $harvestAndLoadingTab . '!' . $harvestAndLoadingRange);
        $checklistData = $checklistData->getValues();
        $harvestAndLoadingData = $harvestAndLoadingData->getValues();

        $roomSchedule = [];
        $dailySchedule = [];

        foreach ($harvestAndLoadingData as $harvest) {
            $room = $harvest[0];

            if ($request->input('room')) {
                if (!in_array($room, $this->filterMap[$request->input('room')])) {
                    continue;
                }
            }

            $loadTime = strtotime($harvest[1]);
            $this->generateCalendar($loadTime, $checklistData, $room, $dailySchedule);
            $this->generateRoomCalendar($loadTime, $checklistData, $room, $roomSchedule);
        }

        $rooms = collect(self::ROOMS)->mapWithKeys(function($room) {
            return [$room['room_label'] => $room['room_id']];
        })->unique();

        return view('dashboard', [
            'events' => $this->generateCalendarEventArray($dailySchedule),
            'rooms' => $rooms,
            'selectedRoom' => $request->input('room'),
        ]);
    }

    public function generateCalendar($timeBasis, $checklist, $roomLabel, &$schedule)
    {
        foreach ($checklist as $item) {
            if ($item[1] == '') {
                continue;
            }
            $time = ((int)$item[0] - 1) * 86400;
            $tasks = preg_split('/\, /', $item[1]);
            $tasks = preg_filter('/^/', $roomLabel . ' ', $tasks);

            if (isset($schedule[$timeBasis + $time])) {
                $schedule[$timeBasis + $time]['tasks'] = array_merge(
                    $schedule[$timeBasis + $time]['tasks'],
                    $tasks
                );
            } else {
                $schedule[$timeBasis + $time] = ['tasks' => $tasks];
            }
        }
    }

    public function generateRoomCalendar($timeBasis, $checklist, $roomLabel, &$schedule)
    {
        foreach ($checklist as $item) {
            $time = ((int)$item[0] - 1) * 86400;
            if ($item[1] !== '') {
                $tasks = preg_split('/\, /', $item[1]);

                $schedule[$roomLabel][$timeBasis + $time] = [
                    'tasks'   => $tasks,
                    'feeding' => $item[2],
                ];
            } else {
                $schedule[$roomLabel][$timeBasis + $time] = [
                    'tasks'   => [],
                    'feeding' => $item[2],
                ];
            }
        }
    }

    private function generateCalendarEventArray($schedule)
    {
        $arrangedByDate = [];

        foreach ($schedule as $time => $dayEvents) {
            foreach ($dayEvents['tasks'] as $event) {
                $arrangedByDate[] = (object) [
                    'title' => $event,
                    'start' => date('Y-m-d', $time),
                ];
            }
        }

        return $arrangedByDate;
    }
}
