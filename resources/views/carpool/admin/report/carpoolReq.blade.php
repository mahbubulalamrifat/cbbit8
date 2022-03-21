<table>
    <thead>
        <tr>
            <td colspan="7" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> Carppool Car Requisition Report
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Driver Name</td>
            <td style="font-weight:bold; background-color: khaki">Driver Contact</td>
            <td style="font-weight:bold; background-color: khaki">Car</td>
            <td style="font-weight:bold; background-color: khaki">Requisition Start</td>
            <td style="font-weight:bold; background-color: khaki">Requisition End</td>
            <td style="font-weight:bold; background-color: khaki">Status</td>
    </thead>
    <tbody>
        @foreach($data as $data)
        <tr>

            <td>{{ $data->driver->name }}</td>

            @if($data->driver)
            <td>{{ $data->driver->contact }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->to)
            <td>{{ $data->to }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->temp)
            <td>{{ $data->temp }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->temp_location)
            <td>{{ $data->temp_location }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->temp_by)
            <td>{{ $data->temp_by }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            <td>{{date("F j, Y, g:i a", strtotime($data->created_at))}}</td>

        </tr>
        @endforeach
    </tbody>
</table>
