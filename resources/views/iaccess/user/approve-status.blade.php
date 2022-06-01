<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('common.cpbd-icon')
    <title>iAccess Approve</title>
</head>
<body>
    <div style="height:100vh; width:100vw;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%)">
            <h2>{{ $notification['msg'] }}</h2>
            @if($notification['data'])<p>Name: <b>{{ $notification['data']['name'] ?? '' }}</b></p>@endif
            @if($notification['data'])<p>Branch: <b>{{ $notification['data']['branch'] ?? '' }}</b></p>@endif
            @if($notification['data'])<p>Position: <b>{{ $notification['data']['position'] ?? '' }}</b></p>@endif
            @if($notification['data'])<p>Department: <b>{{ $notification['data']['department'] ?? '' }}</b></p>@endif
            
            @if ($notification['status'] == 'success')
                <img src="{{ asset('all-assets/common/img/approved.gif') }}" alt="Success">
            @elseif($notification['status'] == 'warning')
                <img src="{{ asset('all-assets/common/img/warning.gif') }}" alt="Warning">
            @else 
                <img src="{{ asset('all-assets/common/img/rejected.gif') }}" alt="Error">
            @endif
           
        </div>
    </div>


    
</body>
</html>