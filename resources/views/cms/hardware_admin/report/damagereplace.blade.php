<table>
    <thead>
        <tr>
            <td colspan="20" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> All Hardware Partial Damage Product Complain List
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Complain Number</td>
            <td style="font-weight:bold; background-color: khaki">Category</td>
            <td style="font-weight:bold; background-color: khaki">Subcategory</td>
            <td style="font-weight:bold; background-color: khaki">Damaged Reason</td>
            <td style="font-weight:bold; background-color: khaki">Complain By</td>
            <td style="font-weight:bold; background-color: khaki">Department</td>
            <td style="font-weight:bold; background-color: khaki">Damaged By</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Name</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Contact</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Position</td>
            <td style="font-weight:bold; background-color: khaki">Product Name</td>
            <td style="font-weight:bold; background-color: khaki">Product Serial</td>
            <td style="font-weight:bold; background-color: khaki">Purchase Date</td>
            <td style="font-weight:bold; background-color: khaki">PO Number</td>
            <td style="font-weight:bold; background-color: khaki">Request Payment Number</td>
            <td style="font-weight:bold; background-color: khaki">Bill Submit Date</td>
            <td style="font-weight:bold; background-color: khaki">Invoice Number</td>
            <td style="font-weight:bold; background-color: khaki">Warranty</td>
            <td style="font-weight:bold; background-color: khaki">Register</td>
            <td style="font-weight:bold; background-color: khaki">Last Update</td>
        </tr>
    </thead>
    <tbody>
        @foreach($complain as $data)
        <tr>
            <td>{{ $data->id }}</td>

            @if($data->complain->category)
            <td>{{ $data->complain->category->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->complain->subcategory)
            <td>{{ $data->complain->subcategory->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->damaged_reason)
            <td>{{ $data->damaged_reason }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->complain->makby)
            <td>{{ $data->complain->makby->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->makby)
            <td>{{ $data->makby->department }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->makby)
            <td>{{ $data->makby->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->rec_name)
            <td>{{ $data->rec_name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->rec_contact)
            <td>{{ $data->rec_contact }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->rec_position)
            <td>{{ $data->rec_position }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            {{-- @if($data->product->length) --}}
            <td>
                @foreach($product as $data->product)
                {{ $product->name }}
                @endforeach
            </td>
            {{-- @else
            <td style="color:red">N/A</td>
            @endif --}}

            {{-- @if($data->product)
            <td>{{ $data->product->serial }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->product)
            <td>{{ $data->product->purchase }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->product)
            <td>{{ $data->product->po_number }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->product)
            <td>{{ $data->product->req_payment_num }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->product)
            <td>{{ $data->product->bill_submit }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->product)
            <td>{{ $data->product->invoice_num }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            

            @if($data->product)
            <td>{{ warranty_check($data->product->warranty ) }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif --}}

            <td>{{date("F j, Y, g:i a", strtotime($data->created_at))}}</td>
            <td>{{date("F j, Y, g:i a", strtotime($data->updated_at))}}</td>

        </tr>
        @endforeach
    </tbody>
</table>



{{-- warranty_check function --}}
@php

function warranty_check($date){
    $currentdate    = date('Y-m-d');
    $ts3            = strtotime($currentdate);
    $ts4            = strtotime($date);
    $seconds        = abs($ts3 - $ts4); # difference will always be positive
    $days           = round( $seconds/(60*60*24) );
    $month          = round( $seconds/(60*60*24*30) );
    $years          = round( $seconds/(60*60*24*30*12) );

    if( $ts3 >= $ts4 ){
        return "Expired";
    }elseif( $days < 30 )
    {   return $days ." Days"; }
    elseif( $month < 12 )
    {   return $month ." Month"; }
    else{
        return $years." Year"; }
            
}
           
@endphp
