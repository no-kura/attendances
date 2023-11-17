@extends('layouts.app')

@section('content')
    <style>
    .txt{
        display: inline-block;
        width: 100%;;
        padding: 0.2em;
        line-height: 0.5;
        border: 1px solid #999;
        box-sizing: border-box;
        background: #f2f2f2;
        margin: 0em 0;
        }
    </style>

    <div class="mx-auto w-full rounded text-left">
        <h1>勤怠表入力</h1>
    </div>
    
    <form method="POST" action="{{ route('attendances.store') }}" class="">
    @csrf 
    <div>
        <table class="text-sm w-full">
            <thead>
                <tr>
                    <th align="left" width="70">
                    ID : {{ $user->id }} 
                    </th>
                    
                    <th align="left" width="200">
                    氏名 :  {{ $user->name }}さん
                    </th>
                    
                    <th align="right" width="300">
                    <button type="submit" class="btn btn-wide btn-primary btn-outline">登録</button>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
   
    @if (isset($attendances))
        
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
                
               
                    <td align="center" width="200">{{ $d->isoformat('YYYY/MM/DD(ddd)') }}
                 {{--
                        @if($datetime )
                            <span class="日" style="color: red">{{ $d }}</span>
                        @elseif($datetime)
                            <span class="土" style="color:blue;">{{ $d }}</span>
                        @else
                            <span class="平日">{{ $d }}</span>
                        @endif
                --}}
                        
                    </td>
                    
                {{--出勤時間--}}
                    <td align="center" width="150"><input type="time" name="punchin{{$key}}" min="00:00" max="24:00"></td>
                    
                 {{--退勤時間--}}   
                    <td align="center" width="150"><input type="time" name="punchout{{$key}}" min="00:00" max="24:00"></td>
                    
                {{--勤務時間--}}    
                    <td align="center" width="150"></td>
                    
                {{--備考（MEMO）--}}    
                    <td align="left"><input type="text" class="txt" name="memo{{$key}}" size="30"></td>
                
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
        </form>
        </table>
    </form>
    @endif
@endsection
  