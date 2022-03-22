<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Request Download</title>
    <link rel="stylesheet" href="{{ asset('all-assets\common\bootstrap-4.0\css\bootstrap.min.css') }}" />

</head>
<body>
    <div class="container-fluid" style="border:3px solid black">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3>Internet/Web Access Request</h3>
                <h4>C.P Bangladesh Co., Ltd.</h4>
            </div>
            <div>
                Date: <span>10-12-21</span>
            </div>
        </div>


        <div class="my-5">
            <div class="h5 text-center w-50 py-2 bg-dark text-white">User Information</div>
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <td>Name: <span>Md Abdullah al mamun</span></td>
                        <td>Branch: <span>Food Business</span></td>
                    </tr>
                    <tr>
                        <td>Position: <span>Section manager</span></td>
                        <td>Department: <span>Accounts & Finance</span></td>
                    </tr>
                    <tr>
                        <td>Personal Mobile No: <span>01939903165</span></td>
                        <td>Office Mobile: <span>01918968932</span></td>
                    </tr>
                    <tr>
                        <td>Personal Email: <span>mamunjibon@gmail.com</span></td>
                        <td>Office Email: <span></span></td>
                    </tr>




                    <tr>
                        <td>Name: <span>{{$newData->name}}</span></td>
                        <td>Branch: <span>{{$newData->branch}}</span></td>
                    </tr>
                    <tr>
                        <td>Position: <span>{{$newData->position}}</span></td>
                        <td>Department: <span>{{$newData->department}}</span></td>
                    </tr>
                    <tr>
                        <td>Personal Mobile:
                            <span>
                                @if($newData->personal_mobile)
                                    {{ $newData->personal_mobile }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td>Office Mobile:
                            <span>
                                @if($newData->office_mobile)
                                    {{ $newData->office_mobile }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Personal Email:
                            <span>
                                @if($newData->personal_email)
                                    {{ $newData->personal_email }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td>Office Email: 
                            <span>
                                @if($newData->office_email)
                                    {{ $newData->office_email }}
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
                    @if($newData->internet_id)
                        Yes{{ $newData->internet_id }}
                    @else
                        No
                    @endif
                </span>
            </div>
        </div>

        <hr>


        <div class="my-5">
            <div class="h5 text-center w-50 py-2 bg-dark text-white">Request For</div>
            <div class="my-2">{{$newData->request_for}}</div>
        </div>

        <hr>


        <div class="my-5">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="h5 text-center w-100 py-2 bg-dark text-white">Web Access (URL)</div>
                    {{-- <textarea name="" id="" rows="7" cols="60" class="form-control">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Suscipit hic deserunt quis mollitia incidunt qui. Voluptatum saepe, voluptatem deserunt ullam dignissimos corporis et? Laboriosam exercitationem ratione unde impedit velit illum.
                    </textarea> --}}
                </div>

                <div>
                    <div class="h5 text-center w-100 py-2 bg-dark text-white">Purpose</div>
                    {{-- <textarea name="" id="" rows="7" cols="60" class="form-control">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Suscipit hic deserunt quis mollitia incidunt qui. Voluptatum saepe, voluptatem deserunt ullam dignissimos corporis et? Laboriosam exercitationem ratione unde impedit velit illum.
                    </textarea> --}}
                </div>
            </div>
            <div>
                <textarea cols="60" class="form-control w-100">
                    {{$newData->purpose}}
                </textarea>
            </div>
        </div>

        <div class="mb-5">
            <div class="d-flex justify-content-between my-5">
                <div>
                    <div class="h5 text-center py-2 bg-dark text-white">Requested By User</div>
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
                    <div class="h5 text-center py-2 bg-dark text-white">Agreed By Manager</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>Md Abdullah Al Mamun</span>
                    </div>
                    <div class="my-2">
                        Signature: <span>Mamun</span>
                    </div>
                    <div class="d-flex">
                        <div>Date <span>29-08-2021</span></div>
                        <div>Time <span>09:21 AM</span></div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <div class="h5 text-center py-2 bg-dark text-white">Approved By BU Head</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>Md Abdullah Al Mamun</span>
                    </div>
                    <div class="my-2">
                        Signature: <span>Mamun</span>
                    </div>
                    <div class="d-flex">
                        <div>Date <span>29-08-2021</span></div>
                        <div>Time <span>09:21 AM</span></div>
                    </div>
                </div>

                <div>
                    <div class="h5 text-center py-2 bg-dark text-white">Received By CPB-IT</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>Md Abdullah Al Mamun</span>
                    </div>
                    <div class="my-2">
                        Signature: <span>Mamun</span>
                    </div>
                    <div class="d-flex">
                        <div>Date <span>29-08-2021</span></div>
                        <div>Time <span>09:21 AM</span></div>
                    </div>
                </div>
            </div>
        </div>

        <small>CPB-IT-CR-3-REV.10</small>
        

    </div>
</body>
</html>