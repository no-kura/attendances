<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserFollowController; // 追記

use App\Models\Attendance;
use App\Models\Summary;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


class AttendancesController extends Controller
{
    public function index(Request $request)
    {
        $data = [];//dd($data);
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
        
            $now = Carbon::now()->firstOfMonth();
            $this_month = Carbon::now()->firstOfMonth();
            
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
            
            
            $FMonth = $firstOfMonth->copy();
            $endOfMonth = $firstOfMonth->copy()->endOfMonth();
            
            $attendances = DB::table('attendances')->where('user_id',$user->id)
                ->whereBetween('date',[$FMonth,$endOfMonth])//->where('working', '<>' ,0)
                ->get();
           
            $day_count = $attendances->count('working');  // 各月の勤務日数
            $total_working = $attendances->sum('working'); // 各月の総出勤時間
            
            $date = [];
            for ($i = 0; true; $i++) {
                $dt = $firstOfMonth->copy()->addDays($i);
                if ($dt > $endOfMonth) {
                    break;
                }
                $date[] = $dt;
            }
            
    }//dd($date);
    
    $data = [
            'user' => $user,
            'attendances' => $attendances,
            'date' => $date,
            'firstOfMonth' => $firstOfMonth,
            'this_month' => $this_month,
            'day_count' => $day_count,
            'total_working' => $total_working,
            ]; 
        // attendancesビューでそれらを表示
        return view('attendances.attendances', $data);
    }
    
    
    public function store(Request $request)
    {//dd($request->all());
        // バリデーション
        $request->validate([
            'memo' => 'max:30',
        ]);
        
        //dd($request->all());
        $data = $request->all();
        
        for($i=0; $i<=$request->key; $i++){
               
            $start = Carbon::parse($request->input('date'.$i).' '.$request->input('punchin'.$i));
            $end = $request->input('date'.$i).' '.$request->input('punchout'.$i);
            $end = Carbon::parse($end);//dd($start,$end);
            
            
            $diffInMinutes = $start->diffInMinutes($end);
            $hours = floor($diffInMinutes / 60);
            $minutes = $diffInMinutes % 60;
            //dd($minutes);
            
            
            if($minutes < 10 ) {
                $min=$hours + 0;
            }
            elseif($minutes < 25) {
                $min=$hours + 0.25;
            }  
            elseif($minutes < 40) {
                $min=$hours + 0.5;
            }
            elseif($minutes < 55) {
                $min=$hours + 0.75;
            }
            else{
                $min=$hours + 1;
            }
            //dd($min);
        
            $attendance=Attendance::where('user_id',$request->user_id)-> where('date',$request-> input('date'.$i))->first();
            if(!$attendance){
                $attendance = new Attendance;
            }
           
            $attendance-> user_id = $request->user_id;
            $attendance-> date = $request-> input('date'.$i);
            $attendance-> punchin = $request-> input('date'.$i).' '.$request-> input('punchin'.$i);
            $attendance-> punchout = $request-> input('date'.$i).' '.$request-> input('punchout'.$i);
            $attendance-> working = $min;
            $attendance-> memo = $request-> input('memo'.$i);
            $attendance-> save();
            

            /*Attendance::updateOrCreate(
                ['user_id'=>$request->user_id , 'date'=>$request->input('date'.$i)], 
                ['punchin'=>$request->input('date'.$i).' '.$request-> input('punchin'.$i),
                'punchout'=>$request->input('date'.$i).' '.$request-> input('punchout'.$i),
                'working'=>$min,
                'memo'=>$request->input('memo'.$i)]
            );
            */
        }
    
        $user = \Auth::user();
            $attendances = DB::table('attendances')->where('user_id',$user->id)
                ->whereBetween('date',[$request-> input('date0'),$request-> input('date'.$i-1)])->where('working', '<>' ,0)
                ->get();
          
            $day_count = $attendances->count('working');  // 各月の勤務日数
            $total_working = $attendances->sum('working'); // 各月の総出勤時間
          
            //$a = $attendances[0]->date;
            $a = $attendances->first()->date;  
            $b = mb_substr($a, 0 ,7);
            $replace = str_replace('-', '', $b);
         //dd($attendances->first());  
            $summary = Summary::where('user_id',$attendances->first()->user_id )->where('summary_date',$replace)->first();
            
            if(!$summary){
                $summary = new Summary;
            }
            
            $summary -> user_id = $attendances[0]->user_id;
            $summary -> summary_date = $replace;
            $summary -> working_days = $day_count;
            $summary -> working_times = $total_working;
            
            $summary -> save();
        
        // 前のURLへリダイレクトさせる
    return redirect ()->route('attendances.index',$data);
        //return back();
    }
    
    
    public function show(Request $request,$id)
    {
        $data = [];//dd($data);
        //if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
        $user = User::find($id);
        
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
                ->whereBetween('date',[$b,$endOfMonth])//->where('working', '<>' ,0)
                ->get();
            
            $day_count = $attendances->count('working');  // 各月の勤務日数
            $total_working = $attendances->sum('working'); // 各月の総出勤時間
            
            
            $date = [];
            for ($i = 0; true; $i++) {
                $A = $firstOfMonth->copy()->addDays($i);
                if ($A > $endOfMonth) {
                    break;
                }
            //dd($A);
                $date[] = $A;
            
            
                $data = [
                    'user' => $user,
                    'attendances' => $attendances,
                    'date' => $date,
                    'firstOfMonth' => $firstOfMonth,
                    'this_month' => $this_month,
                    'day_count' => $day_count,
                    'total_working' => $total_working,
                ]; 
             //dd($date);
            }
        
    
        // attendancesビューでそれらを表示
        return view('attendances.at_show', $data);
    
    }
    
}


