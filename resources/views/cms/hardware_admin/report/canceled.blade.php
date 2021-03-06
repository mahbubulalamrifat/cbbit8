<table>
    <thead>
        <tr>
            <td colspan="8" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> All Canceled Complain List
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Complain Number</td>
            <td style="font-weight:bold; background-color: khaki">Process</td>
            <td style="font-weight:bold; background-color: khaki">Category</td>
            <td style="font-weight:bold; background-color: khaki">Subcategory</td>
            <td style="font-weight:bold; background-color: khaki">User</td>
            <td style="font-weight:bold; background-color: khaki">Department</td>
            <td style="font-weight:bold; background-color: khaki">Register</td>
            <td style="font-weight:bold; background-color: khaki">Last Update</td>
        </tr>
    </thead>
    <tbody>
        @foreach($complain as $complain)
        <tr>
            <td>{{ $complain->id }}</td>
            <td>{{ $complain->process }}</td>

            @if($complain->category)
            <td>{{ $complain->category->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->subcategory)
            <td>{{ $complain->subcategory->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->makby)
            <td>{{ $complain->makby->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->makby)
            <td>{{ $complain->makby->department }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            <td>{{date("F j, Y, g:i a", strtotime($complain->created_at))}}</td>
            <td>{{date("F j, Y, g:i a", strtotime($complain->updated_at))}}</td>

        </tr>
        @endforeach
    </tbody>
</table>
