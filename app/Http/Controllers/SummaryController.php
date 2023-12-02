<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;  
use App\Models\Attendance;
use App\Models\Summary;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


class SummaryController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            
            
            $start = Carbon::now()->firstOfMonth()->subMonths(11);
            $start_date = str_replace('-', '', $start->format("Y-m"));//dd($start_date);
            
            $end = Carbon::now()->firstOfMonth();//dd($end);
            $end_date = str_replace('-', '', $end->format("Y-m"));//dd($end_date);
            
            // $userid = User::findOrFail($id);
            // $followings = $userid->followings();dd($followings);
            
            // $user_follow = DB::table('user_follow')->where('user_id',$user->id)
            //     ->whereBetween('follow_id',[$b,$endOfMonth])->get();
            // dd($user_follow);
            
            $summarys = DB::table('summarys')->where('user_id',$user->id)
                ->whereBetween('summary_date',[$start_date,$end_date])->get();//dd($summarys);
            
            
            $summary_date = [];
            for ($i = 0; $i<12; $i++) {
                $summary_date[] = $start->copy()->addMonths($i);
                
            }
            
            $month = [];
            $thisMonth = Carbon::today()->firstOfMonth()->subMonths(11);//dd($thisMonth);
            
            for($i=0; $i<=11; $i++) {
                $a = $thisMonth->copy()->format("Ym");
                $thisMonth->addMonths();
            
                $month[] = $a;
               
               
                $user = \Auth::user();
            
                // $users = $user->followings()->join('summarys as summ', 'summ.user_id', '=', 'users.id')
                //         ->select('users.name',
                //         DB::raw("case when summ.summary_date = $month[0] then summ.working_days else 0 and as days1"),
                //         DB::raw("case when summ.summary_date = $month[0] then summ.working_times else 0 and as times1"))
                //         ->get();
                   //dd($month[0]);
                     
            }  //dd($month);
            $i=0;
            $users = DB::table('user_follow as uf')->where('uf.user_id',$user->id)
                        ->join('users','uf.follow_id','=','users.id')
                        ->leftjoin('summarys as summ', 'summ.user_id', '=', 'users.id')
                        ->select('users.name','users.id',
                          
                            DB::raw("sum(case when summ.summary_date = $month[0] then summ.working_days else 0 end) as days0"),
                            DB::raw("sum(case when summ.summary_date = $month[0] then summ.working_times else 0 end) as times0"),
                            DB::raw("sum(case when summ.summary_date = $month[1] then summ.working_days else 0 end) as days1"),
                            DB::raw("sum(case when summ.summary_date = $month[1] then summ.working_times else 0 end) as times1"),
                            DB::raw("sum(case when summ.summary_date = $month[2] then summ.working_days else 0 end) as days2"),
                            DB::raw("sum(case when summ.summary_date = $month[2] then summ.working_times else 0 end) as times2"),
                            DB::raw("sum(case when summ.summary_date = $month[3] then summ.working_days else 0 end) as days3"),
                            DB::raw("sum(case when summ.summary_date = $month[3] then summ.working_times else 0 end) as times3"),
                            DB::raw("sum(case when summ.summary_date = $month[4] then summ.working_days else 0 end) as days4"),
                            DB::raw("sum(case when summ.summary_date = $month[4] then summ.working_times else 0 end) as times4"),
                            DB::raw("sum(case when summ.summary_date = $month[5] then summ.working_days else 0 end) as days5"),
                            DB::raw("sum(case when summ.summary_date = $month[5] then summ.working_times else 0 end) as times5"),
                            DB::raw("sum(case when summ.summary_date = $month[6] then summ.working_days else 0 end) as days6"),
                            DB::raw("sum(case when summ.summary_date = $month[6] then summ.working_times else 0 end) as times6"),
                            DB::raw("sum(case when summ.summary_date = $month[7] then summ.working_days else 0 end) as days7"),
                            DB::raw("sum(case when summ.summary_date = $month[7] then summ.working_times else 0 end) as times7"),
                            DB::raw("sum(case when summ.summary_date = $month[8] then summ.working_days else 0 end) as days8"),
                            DB::raw("sum(case when summ.summary_date = $month[8] then summ.working_times else 0 end) as times8"),
                            DB::raw("sum(case when summ.summary_date = $month[9] then summ.working_days else 0 end) as days9"),
                            DB::raw("sum(case when summ.summary_date = $month[9] then summ.working_times else 0 end) as times9"),
                            DB::raw("sum(case when summ.summary_date = $month[10] then summ.working_days else 0 end) as days10"),
                            DB::raw("sum(case when summ.summary_date = $month[10] then summ.working_times else 0 end) as times10"),
                            DB::raw("sum(case when summ.summary_date = $month[11] then summ.working_days else 0 end) as days11"),
                            DB::raw("sum(case when summ.summary_date = $month[11] then summ.working_times else 0 end) as times11"))
                            ->groupBy('users.id','users.name')
                            ->get(); //dd($users);
                            
                $data = [
                        'user' => $user,
                        'users' => $users,
                        'summarys' => $summarys,
                        'summary_date' => $summary_date,
                        'end' => $end,
                        'start' => $start,
                        'month' => $month,
                        ]; 
            }
        // attendancesビューでそれらを表示
        return view('attendances.summarys', $data);
        
    }
}
