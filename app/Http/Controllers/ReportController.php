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
            ->whereBetween(DB::raw('date(channel_reports.created_at)'), [today(-7), today()])
            ->first();

        $last30Days = ChannelReport::select(DB::raw('sum(channel_reports.views) as last30days'))
            ->join('channels as ch', 'ch.channel_hash', '=', 'channel_reports.channel_hash')
            ->where('ch.user_id', $user->id)
            ->whereBetween(DB::raw('date(channel_reports.created_at)'), [today(-30), today()])
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

        if($period == 7) {
            $total = ChannelReport::select(DB::raw('sum(views) as total'))
                ->where('channel_hash', $chash)
                ->whereBetween(DB::raw('date(created_at)'), [today(-7), today()])
                ->first();

            $chart = '';
        } elseif($period == 30) {
            $total = ChannelReport::select(DB::raw('sum(views) as total'))
                ->where('channel_hash', $chash)
                ->whereBetween(DB::raw('date(created_at)'), [today(-30), today()])
                ->first();

            $chart = '';
        } else {
            $total = ChannelReport::select(DB::raw('sum(views) as total'))
                ->where('channel_hash', $chash)
                ->whereBetween(DB::raw('date(created_at)'), [today(-365), today()])
                ->first();

            $chart = '';
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
