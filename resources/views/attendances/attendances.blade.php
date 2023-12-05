@extends('layouts.app')

@section('content')

@if(Auth::user())

    <div class="Header2" padding="20px" width="100%">{{--Header2　固定start--}}
        
        <h1 class="h1">{{ $firstOfMonth->isoformat('YYYY'.'年'.'M'.'月')}}勤怠表入力</h1>
        
            ID: ( {{ $user->id }} )
            氏名 :  {{ $user->name }}さん
        
        <table class="table1">   
            <tr class="table1">
                <td>出勤日数 : {{ $day_count }} 日</td>
                <td>総勤務時間 : {{ $total_working }} 時間</td>
            </tr>
        </table>
    
        <table class="table2" width="100%">
            <tr class="table2">  
                <td align="left">
                    <form method="GET" action="{{ route('attendances.index') }}">
                    @csrf 
                        <button type="submit" name="add_last_month" class="btn btn-sm btn-error btn-outline"> 前月</button>
                        <button type="submit" name="this_month" class="btn btn-sm btn-error btn-outline"> 当月</button>
                        <button type="submit" name="add_next_month" class="btn btn-sm btn-error btn-outline"> 次月</button>
                        
                        <input type="hidden" name="firstOfMonth" value={{$firstOfMonth}}>
                        <input type="hidden" name="this_month" value={{$this_month}}>
                        
                    </form></td>
                <td  align="right">
                    <form method="POST" action="{{ route('attendances.store') }}">
                    @csrf 
                        <button type="submit" class="btn btn-wide btn-primary btn-outline">登録</button></td>
            </tr>
        </table>
        
    </div>{{--header2　固定end--}}
    
    @if (isset($attendances))
    <table class="st-tbl1" width="100%">
        <thead>
            <tr>
                <th width="10%">年月日 / 曜日</th>
                
                <th width="10%">出勤時間</th>
                
                <th width="10%">退勤時間</th>
                
                <th width="10%">勤務時間</th>
                
                <th width="60%">備考（Memo）</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($date as $key=>$d){{--年月日と曜日の自動表示--}}
                @php
                    $ondate = $attendances-> where('date',$d);
                    if($ondate->isNotEmpty()) {
                        
                        if($ondate[$key]->working==0) {
                        $onpunchin = null;
                        $onpunchout = null;
                        $onworking = null; 
                        $onmemo = null;
                        }
                        else{
                        $onpunchin = mb_substr($ondate[$key]->punchin, 11 ,5);
                        $onpunchout = mb_substr($ondate[$key]->punchout, 11 ,5);
                        $onworking = $ondate[$key]->working; 
                        $onmemo = $ondate[$key]->memo;
                        }
                    }
                    else {
                        $onpunchin = null;
                        $onpunchout = null;
                        $onworking = null; 
                        $onmemo = null;
                    }
                    
                    $dw = $d->isoformat('YYYY/MM/DD(ddd)');
                @endphp
                
                @if(strpos($dw,'土'))
                    <tr bgcolor="#87cefa">
                @elseif(strpos($dw,'日'))
                    <tr bgcolor="#FF4500">
                @else
                    <tr>
                @endif
            
                    <td width="10%">{{ $dw }}
                    </td>
                        
                @if($ondate->isNotEmpty())
                {{--出勤時間--}}
                    <td width="10%"><input type="time" name="punchin{{$key}}" min="00:00" max="24:00" value={{ $onpunchin }} ></td>
                    
                 {{--退勤時間--}}   
                    <td width="10%"><input type="time" name="punchout{{$key}}" min="00:00" max="24:00" value={{ $onpunchout }}></td>
                    
                {{--勤務時間--}}
                    @if($onworking == null)
                    <td width="10%"><input type="text" class="text-center" style="text-align center;width:80px;" name="working{{$key}}" value={{ $onworking }}></td>
                    @else
                    <td width="10%"><input type="text" class="text-center" style="text-align center;width:80px;" name="working{{$key}}" value={{ $onworking }}時間></td>
                    @endif
                    
                {{--備考（MEMO）--}}    
                    <td width="60%"><input type="text" class="txt" name="memo{{$key}}" size="30" value={{ $onmemo }}></td>
                    
                @else
                {{--出勤時間--}}
                    <td width="10%"><input type="time" name="punchin{{$key}}" min="00:00" max="24:00" value=""></td>
                    
                 {{--退勤時間--}}   
                    <td width="10%"><input type="time" name="punchout{{$key}}" min="00:00" max="24:00" value=""></td>
                    
                {{--勤務時間--}}    
                    <td width="10%"><input type="text" class="text-center" style="text-align center;width:80px;" name="working{{$key}}" value="" disabled></td>
                    
                {{--備考（MEMO）--}}    
                    <td width="60%"><input type="text" class="txt" name="memo{{$key}}" size="30" value=""></td>
                @endif
                
                    <input type="hidden" name="date{{$key}}" value={{$d}}>
                    </tr>
                
                    <input type="hidden" name="key" value={{$key}}>
                    
            @endforeach
                <input type="hidden" name="user_id" value={{$user->id}}>
        </tbody>
    </table>
    
    </form>
    @endif
@endif
@endsection
  