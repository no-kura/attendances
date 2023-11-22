@extends('layouts.app')

@section('content')
    <style>
    .txt{
        display: inline-block;
        width: 100%;
        padding: 0.2em;
        line-height: 0.5;
        border: 1px solid #999;
        box-sizing: border-box;
        background: #f2f2f2;
        margin: 0em 0;
        }
    
    </style>

    <div class="mx-auto w-full rounded text-left">
        <h1>{{ $firstOfMonth->isoformat('YYYY'.'年'.'M'.'月')}}勤怠表入力</h1>
         ID: ( {{ $user->id }} ) 
         氏名 :  {{ $user->name }}さん
    </div>
    
        出勤日数 : {{ $day_count }} 日<br>
        総勤務時間 : {{ $total_working }} 時間<br>
        
    <form method="GET" action="{{ route('attendances.index') }}" class="">
        @csrf 
            <button type="submit" name="add_last_month" class="btn btn-sm btn-error btn-outline"> 前月</button>
            <button type="submit" name="this_month" class="btn btn-sm btn-error btn-outline"> 当月</button>
            <button type="submit" name="add_next_month" class="btn btn-sm btn-error btn-outline"> 次月</button>
            
            <input type="hidden" name="firstOfMonth" value={{$firstOfMonth}}>
            <input type="hidden" name="this_month" value={{$this_month}}>
    </form>
    
    <form method="POST" action="{{ route('attendances.store') }}" class="">
        @csrf 
            <div>
                <table class="text-sm w-full">
                    <thead>
                        <tr>
                        {{--    <th align="left" width="70">
                            ID : {{ $user->id }} 
                            </th>
                            
                            <th align="left" width="200">
                            氏名 :  {{ $user->name }}さん
                            </th>--}}
                            
                            <th align="right" width="300">
                            <button type="submit" class="btn btn-wide btn-primary btn-outline">登録</button>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
    
    
    @if (isset($attendances))
        <div>
            <table class="table table-zebra w-full my-4">
                <thead>
                    <tr align="center">
                       <th align="center" width="200">
                        日 / 曜日
                        </th>
                        
                        <th align="center" width="150">
                        出勤時間
                        </th>
                        
                        <th align="center" width="150">
                        退勤時間
                        </th>
                        
                        <th align="center" width="150">
                        勤務時間
                        </th>
                        
                        <th align="center" width="">
                        備考（Memo）
                        </th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    @foreach ($date as $key=>$d)
                    
                    <tr align="center">
                        {{--年月日と曜日の自動表示--}}
                         
                        @php
                            $ondate = $attendances-> where('date',$d);
                            if($ondate->isNotEmpty()) {
                                $onpunchin = mb_substr($ondate[$key]->punchin, 11 ,5);
                                $onpunchout = mb_substr($ondate[$key]->punchout, 11 ,5);
                                $onworking = $ondate[$key]->working; 
                                $onmemo = $ondate[$key]->memo;
                            }
                            $dw = $d->isoformat('YYYY/MM/DD(ddd)');
                            
                        @endphp
                        
                        
                        @if(strpos($dw,'土'))      
                            <td align="center" width="200"><font color="blue">{{ $dw }}
                            </font></td>
                        @elseif(strpos($dw,'日'))
                            <td align="center" width="200"><font color="red">{{ $dw }}
                            </font></td>
                        @else
                            <td align="center" width="200">{{ $dw }}
                            </td>
                        @endif
                         
                        
                    
                        @if($ondate->isNotEmpty())
                        {{--出勤時間--}}
                            <td align="center" width="150"><input type="time" name="punchin{{$key}}" min="00:00" max="24:00" value={{ $onpunchin }} >
                            {{--{{$ondate[$key]->punchin}} --}}
                            </td>
                            
                         {{--退勤時間--}}   
                            <td align="center" width="150"><input type="time" name="punchout{{$key}}" min="00:00" max="24:00" value={{ $onpunchout }}>
                            </td>
                            
                        {{--勤務時間--}}    
                            <td align="center" width="150"><input type="text" name="working{{$key}}" value={{ $onworking }}時間>
                            </td>
                            
                        {{--備考（MEMO）--}}    
                            <td align="left"><input type="text" class="txt" name="memo{{$key}}" size="30" value={{ $onmemo }}>
                            </td>
                        
                        @else
                        {{--出勤時間--}}
                            <td align="center" width="150"><input type="time" name="punchin{{$key}}" min="00:00" max="24:00" value="">
                            </td>
                            
                         {{--退勤時間--}}   
                            <td align="center" width="150"><input type="time" name="punchout{{$key}}" min="00:00" max="24:00" value="">
                            </td>
                            
                        {{--勤務時間--}}    
                            <td align="center" width="150"><input type="text" style="text-align: center;" name="working{{$key}}" value="" disabled>
                            </td>
                            
                        {{--備考（MEMO）--}}    
                            <td align="left"><input type="text" class="txt" name="memo{{$key}}" size="30" value="">
                            </td>
                        @endif
                        
                        
                        <input type="hidden" name="date{{$key}}" value={{$d}}>
                        </tr>
                        
                        <input type="hidden" name="key" value={{$key}}>
                        
                        
                    @endforeach
                
                        <input type="hidden" name="user_id" value={{$user->id}}>
                       
                        {{--@foreach ($attendances as $attendance)  
                            
                            <td>{{ $attendances->punchin }}</td>
                            <td>{{ $attendances->punchout }}</td>
                            <td>{{ $attendances->working }}</td>
                            <td>{{ $attendances->memo }}</td>
                        </tr>
                        @endforeach--}}
                </tbody>
            </table>
        </div>
    </form>
    @endif
@endsection
  