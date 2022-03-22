<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Request Download</title>
    <link rel="stylesheet" href="{{ asset('all-assets\common\bootstrap-4.0\css\bootstrap.min.css') }}" />

    <style scoped>
        fieldset .scheduler-border {
            border: solid 1px #DDD !important;
            padding: 0 10px 10px 10px;
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid" style="border: 3px solid black">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3>Official Email Request</h3>
                <h4>C.P Bangladesh Co., Ltd.</h4>
            </div>
            <div>
                Date: <span>{{ date("F j, Y, g:i a", strtotime($newData->date)) }}</span>
            </div>
        </div>



        <div class="my-5">
            <div class="h5 text-center d-block py-2 bg-dark text-white">User Information</div>
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <td>Name: <span>{{$newData->name}}</span></td>
                        <td>Branch: <span>{{$newData->branch}}</span></td>
                    </tr>
                    <tr>
                        <td>Position: <span>{{$newData->position}}</span></td>
                        <td>Department: <span>{{$newData->department}}</span></td>
                    </tr>
                    <tr>
                        <td>CP Mobile: <span>{{$newData->office_mobile}}</span></td>
                        <td>Personal Mobile: <span>{{$newData->personal_mobile}}</span></td>
                    </tr>
                    <tr>
                        <td>Personal Email: <span>{{$newData->personal_email}}</span></td>
                        <td>BU Head Email: 
                            <span>
                                @if($newData->bu_head_email)
                                    {{ $newData->bu_head_email }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        <div class="mb-5">
            <div class="h5 text-center d-block py-2 bg-dark text-white">Request For</div>
            <div class="my-2 font-weight-bold">{{ $newData->request_for }}</div>
            <hr>
            <div>Request Email ID: 
                <span>
                    @if($newData->requested_email)
                        {{ $newData->requested_email }}
                    @else
                        N/A
                    @endif
                </span>
            </div>
        </div>

        <div class="my-4">
            <div class="h5 text-center d-block py-2 bg-dark text-white">Purpose</div>
            <textarea rows="7" class="form-control">
                {{$newData->purpose}}
            </textarea>
        </div>

        <div>
            <div class="d-flex justify-content-between my-5">
                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">User</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>{{$newData->name}}</span>
                    </div>
                    <div class="my-2">
                        Signature: <span>{{$newData->name}}</span>
                    </div>
                    <div class="d-flex">
                        <div>Date <span>{{ date("F j, Y", strtotime($newData->date)) }}</span></div>
                        <div>Time <span>{{ date("g:i a", strtotime($newData->date)) }}</span></div>
                    </div>
                </div>

                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Agreed By Manager</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>
                            @if($newData->manager_name)
                                {{ $newData->manager_name }}
                            @else
                                N/A
                            @endif
                            </span>
                    </div>
                    <div class="my-2">
                        Signature: <span>
                            @if($newData->manager_name)
                                {{ $newData->manager_name }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="d-flex">
                        <div>Date <span>29-08-2021</span></div>
                        <div>Time <span>09:21 AM</span></div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Approved By BU Head</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>
                            @if($newData->bu_name)
                                {{ $newData->bu_name }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="my-2">
                        Signature: <span>
                            @if($newData->bu_name)
                                {{ $newData->bu_name }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="d-flex">
                        <div>Date <span>29-08-2021</span></div>
                        <div>Time <span>09:21 AM</span></div>
                    </div>
                </div>

                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Received By CPB-IT</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>
                            @if($newData->it_name)
                                {{ $newData->it_name }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="my-2">
                        Signature: <span>
                            @if($newData->it_name)
                                {{ $newData->it_name }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="d-flex">
                        <div>Date <span>29-08-2021</span></div>
                        <div>Time <span>09:21 AM</span></div>
                    </div>
                </div>
            </div>
        </div>
        
        <small class="mt-5">CPB-IT-CR-3-REV.10</small>

    </div>
</body>
</html>