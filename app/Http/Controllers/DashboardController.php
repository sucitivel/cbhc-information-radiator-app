<?php
namespace App\Http\Controllers;

use Google\Service\Sheets as gSheets;
use Illuminate\Http\Request;
use App\Library\GoogleApi;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $client = $request->gClient;
        $client->setScopes(gSheets::SPREADSHEETS_READONLY);
        $service = new gSheets($client);

        $spreadsheetId = '1_BQ4VZQcnQpjUVx6MnXAx6Xb77aRezFqtQ0JZfllSto';
        $checklistTab = 'Daily Grow Checklists';
        $harvestAndLoadingTab = 'Loading and Harvest';
        $harvestAndLoadingRange = 'A6:C75';
        $checklistRange = 'A2:C57';

        $checklistData = $service->spreadsheets_values->get($spreadsheetId, $checklistTab . '!' . $checklistRange);
        $harvestAndLoadingData = $service->spreadsheets_values->get($spreadsheetId, $harvestAndLoadingTab . '!' . $harvestAndLoadingRange);
        $checklistData = $checklistData->getValues();
        $harvestAndLoadingData = $harvestAndLoadingData->getValues();

        $roomSchedule = [];
        $dailySchedule = [];

        foreach ($harvestAndLoadingData as $harvest) {
            $room = $harvest[0];
            $loadTime = strtotime($harvest[1]);
            $this->generateCalendar($loadTime, $checklistData, $room, $dailySchedule);
            $this->generateRoomCalendar($loadTime, $checklistData, $room, $roomSchedule);
        }

        return view('dashboard', [
            'events' => $this->generateCalendarEventArray($dailySchedule),
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
                    $schedule[$timeBasis + $time],
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
