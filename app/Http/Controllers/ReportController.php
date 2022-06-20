<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChannelReport;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    public function cardReport(Request $request)
    {
        $user = $request->user();
        $todate = Carbon::now();

        $today = ChannelReport::select(DB::raw('sum(channel_reports.views) as today'))
            ->join('channels as ch', 'ch.channel_hash', '=', 'channel_reports.channel_hash')
            ->where('ch.user_id', $user->id)
            ->where(DB::raw('date(channel_reports.created_at)'), $todate->toDateString())
            ->first();

        $last7Days = ChannelReport::select(DB::raw('sum(channel_reports.views) as last7days'))
            ->join('channels as ch', 'ch.channel_hash', '=', 'channel_reports.channel_hash')
            ->where('ch.user_id', $user->id)
            ->whereBetween(DB::raw('date(channel_reports.created_at)'), [$todate->subWeek(), today()])
            ->first();

        $last30Days = ChannelReport::select(DB::raw('sum(channel_reports.views) as last30days'))
            ->join('channels as ch', 'ch.channel_hash', '=', 'channel_reports.channel_hash')
            ->where('ch.user_id', $user->id)
            ->whereBetween(DB::raw('date(channel_reports.created_at)'), [$todate->subMonth(), today()])
            ->first();

        $total = ChannelReport::select(DB::raw('sum(channel_reports.views) as total'))
            ->join('channels as ch', 'ch.channel_hash', '=', 'channel_reports.channel_hash')
            ->where('ch.user_id', $user->id)
            ->first();

        $cardReport = [
            'today' => $today->today == null ? 0 : $today->today,
            'last7Days' => $last7Days->last7days == null ? 0 : $last7Days->last7days,
            'last30Days' => $last30Days->last30days == null ? 0 : $last30Days->last30days,
            'total' => $total->total == null ? 0 : $total->total,
        ];

        return response([
            'data' => $cardReport,
            'status' => 'success',
            'status_code' => 200
        ]);
    }

    public function chartReport(Request $request)
    {
        $chash = request()->query('chash');
        $period = request()->query('period');
        $todate = Carbon::now();
        $dates = [];
        $totals = [];

        if($period == 7) {
            $total = ChannelReport::select(DB::raw('sum(views) as total'))
                ->where('channel_hash', $chash)
                ->whereBetween(DB::raw('date(created_at)'), [$todate->subWeek(), today()])
                ->first();

            // $data = ChannelReport::select(DB::raw('date_format(created_at, "%a, %b %e") as dates, sum(views) as total'))
            //     ->where('channel_hash', $chash)
            //     ->whereBetween(DB::raw('date(created_at)'), [$todate->subWeek(), today()])
            //     ->groupBy(DB::raw('date(created_at)'))
            //     ->orderBy(DB::raw('date(created_at)'))
            //     ->pluck('dates','total')
            //     ->all();
            $data = DB::select(DB::raw("
                WITH RECURSIVE abc AS
                (
                    select CAST((select DATE_SUB(current_date, INTERVAL 7 DAY)) as DATE) as dates
                    union all 
                    select ADDDATE(dates, interval 1 day)
                    from abc 
                    where dates < current_date
                )
                SELECT date_format(x.created_date, '%a, %b %e') dates, sum(x.views) total FROM (
                    select date(created_at) as created_date, sum(views) as views
                    from channel_reports
                    where channel_hash = :chash
                    and date(created_at) between DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) and CURRENT_DATE
                    group by date(created_at)
                    union all
                    select dates, 0 from abc
                ) x
                group by date(x.created_date)
                order by date(x.created_date)
            "), array('chash' => $chash));

            foreach($data as $date) {
                array_push($dates, $date->dates);
            }
            foreach($data as $tot) {
                array_push($totals, $tot->total);
            }
            $chart = [
                'dates' => $dates,
                'total' => $totals
            ];
            // $chart = new ChannelReport;
            // $chart->total = (array_keys($data));
            // $chart->dates = (array_values($data));

        } elseif($period == 30) {
            $total = ChannelReport::select(DB::raw('sum(views) as total'))
                ->where('channel_hash', $chash)
                ->whereBetween(DB::raw('date(created_at)'), [$todate->subMonth(), today()])
                ->first();

            // $data = ChannelReport::select(DB::raw('date_format(created_at, "%b %e") as dates, sum(views) as total'))
            //     ->where('channel_hash', $chash)
            //     ->whereBetween(DB::raw('date(created_at)'), [$todate->subMonth(), today()])
            //     ->groupBy(DB::raw('date(created_at)'))
            //     ->orderBy(DB::raw('date(created_at)'))
            //     ->pluck('dates','total')
            //     ->all();

            // $chart = new ChannelReport;
            // $chart->total = (array_keys($data));
            // $chart->dates = (array_values($data));

            $data = DB::select(DB::raw("
                WITH RECURSIVE abc AS
                (
                    select CAST((select DATE_SUB(current_date, INTERVAL 1 MONTH)) as DATE) as dates
                    union all 
                    select ADDDATE(dates, interval 1 day)
                    from abc 
                    where dates < current_date
                )
                SELECT date_format(x.created_date, '%b %e') dates, sum(x.views) total FROM (
                    select date(created_at) as created_date, sum(views) as views
                    from channel_reports
                    where channel_hash= :chash
                    and date(created_at) between DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH) and CURRENT_DATE
                    group by date(created_at)
                    union all
                    select dates, 0 from abc
                ) x 
                group by date(x.created_date)
            "), array('chash' => $chash));

            foreach($data as $date) {
                array_push($dates, $date->dates);
            }
            foreach($data as $tot) {
                array_push($totals, $tot->total);
            }
            $chart = [
                'dates' => $dates,
                'total' => $totals
            ];

        } else {
            $total = ChannelReport::select(DB::raw('sum(views) as total'))
                ->where('channel_hash', $chash)
                ->whereBetween(DB::raw('date(created_at)'), [$todate->subYear(), today()])
                ->first();

            // $data = ChannelReport::select(DB::raw('date_format(created_at, "%b %y") as dates, sum(views) as total'))
            //     ->where('channel_hash', $chash)
            //     ->whereBetween(DB::raw('date(created_at)'), [$todate->subYear(), today()])
            //     ->groupBy(DB::raw('year(created_at)'))
            //     ->orderBy(DB::raw('year(created_at)'))
            //     ->pluck('dates','total')
            //     ->all();

            // $chart = new ChannelReport;
            // $chart->total = (array_keys($data));
            // $chart->dates = (array_values($data));

            $data = DB::select(DB::raw("
                WITH RECURSIVE abc AS
                (
                    select CAST((select DATE_SUB(current_date, INTERVAL 1 YEAR)) as DATE) as dates
                    union all 
                    select ADDDATE(dates, interval 1 day)
                    from abc 
                    where dates < current_date
                )
                SELECT date_format(x.created_date, '%b %y') dates, sum(x.views) total FROM (
                    select date(created_at) as created_date, sum(views) as views
                    from channel_reports
                    where channel_hash=:chash
                    and date(created_at) between DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR) and CURRENT_DATE
                    group by monthname(created_at)
                    union all
                    select dates, 0 from abc
                ) x 
                group by monthname(x.created_date)
                order by year(x.created_date), 
                FIELD(monthname(x.created_date), 'January','February','March','April','May','June','July','August','September','October','November','December')
            "), array('chash' => $chash));

            foreach($data as $date) {
                array_push($dates, $date->dates);
            }
            foreach($data as $tot) {
                array_push($totals, $tot->total);
            }
            $chart = [
                'dates' => $dates,
                'total' => $totals
            ];
        }

        return response([
            'data' => [
                'total' => $total->total == null ? 0 : $total->total,
                'chart' => $chart
            ],
            'status' => 'success',
            'status_code' => 200
        ]);
    }


}
