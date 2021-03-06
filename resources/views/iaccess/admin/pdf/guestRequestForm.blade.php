<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('all-assets\common\bootstrap-4.0\css\bootstrap.min.css') }}" />

</head>
<body>
    <div class="container-fluid" style="border:3px solid black">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3>Guest User Request</h3>
                <h4>C.P Bangladesh Co., Ltd.</h4>
            </div>
            <div>
                <div style="font-weight: bold;">
                    Req. No:
                    <span>
                        @if($data->number)
                            {{ $data->number }}
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div>
                    Date:  <span>{{ date("F j, Y", strtotime($data->created_at)) }}</span>
                </div>
                
            </div>
        </div>


        <div class="my-5">
            <div class="h5 text-center w-50 py-2 bg-dark text-white">User Information</div>
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <td>Name: <span>{{$data->name}}</span></td>
                        <td>Branch: <span>{{$data->branch}}</span></td>
                    </tr>
                    <tr>
                        <td>Position: <span>{{$data->position}}</span></td>
                        <td>Department: <span>{{$data->department}}</span></td>
                    </tr>
                    <tr>
                        <td>Personal Mobile:
                            <span>
                                @if($data->personal_mobile)
                                    {{ $data->personal_mobile }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td>Office Mobile:
                            <span>
                                @if($data->office_mobile)
                                    {{ $data->office_mobile }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Personal Email:
                            <span>
                                @if($data->personal_email)
                                    {{ $data->personal_email }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td>Office Email: 
                            <span>
                                @if($data->office_email)
                                    {{ $data->office_email }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        <div>
            <div>Do you have any ID <b>like shayful.lam</b> for Smart Soft, Smart Procurement, Win Feed, Win Farm or other?</div>
            <div>
                <span class="font-weight-bold">
                    @if($data->internet_id)
                        {{ $data->internet_id }}
                    @else
                        No
                    @endif
                </span>
            </div>
        </div>

        <div class="my-5">
            <div class="h5 text-center w-50 py-2 bg-dark text-white">Guest User Information</div>
            <table class="table table-borderless">
                <tr>
                    <td>Guest User Company: <span>{{$data->guest_company}}</span></td>
                    <td>Run. No of Guest Users: <span> {{$data->no_of_guest}} </span>User(s)</td>
                </tr>
                <tr>
                    <td colspan="2">Guest User Job: <span>{{$data->guest_job}}</span></td>
                </tr>
                <tr>
                    <td>
                        Guest User Validity (Duration in Days) <span> {{$data->guest_duration}} </span>Days(s)
                        <small>***validiy start after first login</small>
                    </td>
                    <td>Duration Date From: <span>{{$data->start_date}}</span> to <span>{{$data->end_date}}</span></td>
                </tr>
            </table>
        </div>


        <div>
            <div class="d-flex justify-content-between my-5">
                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">User</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>{{$data->name}}</span>
                    </div>
                    <div class="my-2">
                        Signature: <span>{{$data->name}}</span>
                    </div>
                    <div class="d-flex">
                        <div class="mr-5">Date:  <span>{{ date("F j, Y", strtotime($data->created_at)) }}</span></div>
                        <div>Time:  <span>{{ date("g:i a", strtotime($data->created_at)) }}</span></div>
                    </div>
                </div>

                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Approved By Manager</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: 
                        <span>
                            @if (!empty($data->manager))
                                {{ $data->manager->name }}
                            @else
                                <span class="text-error small">N/A</span>
                            @endif
                        </span>
                    </div>
                    <div class="my-2">
                        Signature: 
                        <span>
                            @if (!empty($data->manager))
                                {{ $data->manager->name }}
                            @else
                                <span class="text-error small">N/A</span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex">
                        <div class="mr-5">Date: 
                            <span>
                                @if (!empty($data->manager_approved))
                                    {{ date("F j, Y", strtotime($data->manager_approved)) }}
                                @else
                                    <span class="text-error small">Waiting for Approval</span>
                                @endif
                            </span>
                        </div>
                        <div>Time: 
                            <span>
                                @if (!empty($data->manager_approved))
                                    {{ date("g:i a", strtotime($data->manager_approved)) }}
                                @else
                                    <span class="text-error small">Waiting for Approval</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">

                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Approved By BU Head</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: 
                        <span>
                            @if (!empty($data->buhead))
                                {{ $data->buhead->name }}
                            @else
                                <span class="text-error small">N/A</span>
                            @endif
                        </span>
                    </div>
                    <div class="my-2">
                        Signature: 
                        <span>
                            @if (!empty($data->buhead))
                                {{ $data->buhead->bu_name }}
                            @else
                                <span class="text-error small"> Waiting For Approval </span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex">
                        <div class="mr-5">Date: 
                            <span>
                                @if (!empty($data->bu_approved))
                                    {{ date("F j, Y", strtotime($data->bu_approved)) }}
                                @else
                                    <span class="text-error small"> Waiting For Approval </span>
                                @endif
                            </span>
                        </div>
                        <div>Time: 
                            <span>
                                @if (!empty($data->bu_approved))
                                    {{ date("g:i a", strtotime($data->bu_approved)) }}
                                @else
                                    <span class="text-error small"> Waiting For Approval </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Received By CPB-IT</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: 
                        <span>
                            @if (!empty($data->verify))
                                {{ $data->verify->name }}
                            @else
                                <span class="text-error small"> Waiting For Approval </span>
                            @endif
                        </span>
                    </div>
                    <div class="my-2">
                        Signature: 
                        <span>
                            @if (!empty($data->verify))
                               {{ $data->verify->name }}
                            @else
                                <span class="text-error small"> Waiting For Approval </span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex">
                        <div class="mr-5">Date: 
                            <span>
                                @if (!empty($data->verify_status))
                                    {{ date("F j, Y", strtotime($data->verify_date)) }}
                                @else
                                    <span class="text-error small"> Waiting For Approval </span>
                                @endif
                            </span>
                        </div>
                        <div>Time: 
                            <span>
                                @if (!empty($data->verify_status))
                                    @if($data->verify_status)
                                        {{ date("g:i a", strtotime($data->verify_date)) }}
                                    @endif
                                @else
                                    <span class="text-error small"> Waiting For Approval </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @if (!empty($data->verify_status))
            <div>
            <b>Remarks: </b>
            <div>
                {{ $data->verify_remarks }}
            </div>
        </div>
        @endif

        
        <br>
        <br>
        <p class="small">CPB-IT-CR-3-REV.10</p>
        <p class="small">This is a computer-generated document. No signature is required. Powered By @CPB-IT<span class="float-right">{{ date('Y-m-d H:i A') }}</span></p>


    </div>
</body>
</html>