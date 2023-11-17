<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Attendance;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


class AttendancesController extends Controller
{
      public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            
            $firstOfMonth = Carbon::now()->firstOfMonth();
            $b = $firstOfMonth->copy();//->isoformat('YYYY/MM/DD(ddd)');
            $endOfMonth = $firstOfMonth->copy()->endOfMonth();//->isoformat('YYYY/MM/DD(ddd)');
            
            $attendances = DB::table('attendances')->where('user_id',$user->id)
                ->whereBetween('date',[$b,$endOfMonth])->get();
            
            $date = [];
            for ($i = 0; true; $i++) {
                $A = $firstOfMonth->copy()->addDays($i);//->isoformat('YYYY/MM/DD(ddd)');
                if ($A > $endOfMonth) {
                    break;
                }
                
                
                $date[] = $A;
                
                // echo $date->format('m/d'). PHP_EOL
                
            // dd($date);
            
            $data = [
                'user' => $user,
                'attendances' => $attendances,
                'date' => $date,
            ];
                
            }
        }
            
        // attendancesビューでそれらを表示
        return view('attendances.attendances', $data);
    }
    
    
     public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'memo' => 'max:30',
        ]);
        //dd($request->all());
        for($i=0;$request->key; $i++){
        
        
        $start = Carbon::parse($request->input('date'.$i).' '.$request->input('punchin'.$i));
        $end = $request->input('date'.$i).' '.$request->input('punchout'.$i);
        $end = Carbon::parse($end);//dd($start,$end);
        
        
        $diffInMinutes = $start->diffInMinutes($end);
        $hours = floor($diffInMinutes / 60);
        $minutes = $diffInMinutes % 60;
        //dd($minutes);
        
        
        if($minutes < 10 ){
            $min=$hours + 0;
        }
        elseif($minutes < 25){
            $min=$hours + 0.25;
        }  
        elseif($minutes < 40){
            $min=$hours + 0.5;
        }
        elseif($minutes < 55){
            $min=$hours + 0.75;
        }
        else{
            $min=$hours + 1;
        }
        //dd($min);
        
        
        Attendance::updateOrCreate(
            
            ['user_id'=>$request->user_id , 'date'=>input('date'.$i)],
            ['punchin'=>$request->input('date'.$i).' '.$request-> input('punchin'.$i),
            'punchout'=>$request->input('date'.$i).' '.$request-> input('punchout'.$i),
            'memo'=>$request->input('memo'.$i)]
        )
        
        
    }
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        // $request->user()->attendances()->create([
        //     'punchin' => $request->punthin,
        //     'punchout' => $request->puntiout,
        //     'memo' => $request->memo,
            
        // ]);
        
        
        // 前のURLへリダイレクトさせる
        return back();
   }
}

