<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Attendance;

use App\Models\Summary;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class SummaryController extends Controller
{
    public function index(Request $request)
    {
        $data = [];//dd($data);
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            
            $now = Carbon::now()->firstOfMonth();
            $this_month = Carbon::now()->firstOfMonth();//dd($this_month);
            
            if($request->firstOfMonth) {
                $now = new Carbon($request->firstOfMonth);
            }
            
            if(isset($_GET['this_month'])){
                $this_month = new Carbon($request->this_month);
            }
           
            if(isset($_GET['add_last_month'])) {
                $firstOfMonth = Carbon::parse($now->copy()-> subMonth(1));
            }
            elseif(isset($_GET['add_next_month'])) {
                $firstOfMonth = Carbon::parse($now->copy()-> addMonth(1));
            }
            else {
                $firstOfMonth = Carbon::now()->firstOfMonth();
             }
            
            
            $b = $firstOfMonth->copy();
            $endOfMonth = $firstOfMonth->copy()->endOfMonth();
            
            $attendances = DB::table('attendances')->where('user_id',$user->id)     // attendancesテーブルから、useridの確認->日付の初日から末日を取得->その中の勤務時間が入っているものを取得
                ->whereBetween('date',[$b,$endOfMonth])->where('working', '<>' ,0)
                ->get();
            
            $day_count = $attendances->count('working');  // 各月の勤務日数
            $total_working = $attendances->sum('working'); // 各月の総出勤時間
            
            
            $date = [];
            for ($i = 0; true; $i++) {
                $A = $firstOfMonth->copy()->addDays($i);
                if ($A > $endOfMonth) {
                    break;
                }
            
                $date[] = $A;
            
                
            // dd($date);
                $data = [
                    'user' => $user,
                    'attendances' => $attendances,
                    'date' => $date,
                    'firstOfMonth' => $firstOfMonth,
                    'this_month' => $this_month,
                    'day_count' => $day_count,
                    'total_working' => $total_working,
                ]; 
            }
        }
            //dd($attendances);
        // attendancesビューでそれらを表示
        return view('attendances.attendances_summary', $data);
    }
}
