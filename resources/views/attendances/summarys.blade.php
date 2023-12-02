@extends('layouts.app')

@section('content')

    <div class="Header3" height="150">
   
        <h1 class="h1">{{ $start->isoformat('YYYY'.'年'.'M'.'月').'~'.$end->isoformat('YYYY'.'年'.'M'.'月')}} 勤怠一覧表</h1>
         ID: ( {{ $user->id }} ) 
         氏名 :  {{ $user->name }}さん
    </div>
        @if (isset($summarys))
            <table class="st-tbl2" width="100%">
                <thead>
                    <tr>
                        <th>ユーザー名</th>
                        
                        <th>日数/時間</th>
                        
                        @foreach ($summary_date as $sd)
                        
                        <th><font color="">{{ $sd->format('Y年m月') }}</th>
                        
                        @endforeach
                    </tr>
                </thead>
                    @foreach ($users as $user)
           
                        <tr align="center">
                            
                            <td rowspan="2">
                            <a class="link link-hover text-info" href="{{ route('attendances.show',$user->id) }}">{{ $user->name }}
                            </a></td>
                            
                            <td>出勤日数</td>
                           
                           
                            @for ($i=0; $i<=11; $i++)
                                @php
                                    $days = 'days'.$i;
                                @endphp
                                    <td align="center"> {{ $user->$days }}日</td>
                            
                            @endfor
                        </tr>
                        <tr>
                            <td bgcolor="#DCDCDC">総出勤時間</td>
                
                                @for ($i=0; $i<=11; $i++)
                                    @php
                                        $times = 'times'.$i;
                                    @endphp
                                        <td align="center" bgcolor="#DCDCDC"> {{ $user->$times }}時間</td>
                                @endfor
                                    
                    @endforeach
            </tr>
        </table>
    @endif
@endsection
  