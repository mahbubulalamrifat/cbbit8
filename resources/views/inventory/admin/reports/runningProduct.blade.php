<table>
    <thead>
        <tr>
            <td colspan="11" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> Inventory Running Product List
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Product Name/Model</td>
            <td style="font-weight:bold; background-color: khaki">Category</td>
            <td style="font-weight:bold; background-color: khaki">Department</td>
            <td style="font-weight:bold; background-color: khaki">Location</td>
            <td style="font-weight:bold; background-color: khaki">Operaiton</td>
            <td style="font-weight:bold; background-color: khaki">Serial</td>
            <td style="font-weight:bold; background-color: khaki">Purchase Date</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Name</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Contact</td>
            <td style="font-weight:bold; background-color: khaki">Designation</td>
        </tr>
    </thead>
    <tbody>
        @foreach($product as $product)
        <tr>
            <td>{{ $product->name }}</td>

            @if($product->category)
            <td>{{ $product->category->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->department)
            <td>{{ $product->department }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->location)
            <td>{{ $product->location }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->operation)
            <td>{{ $product->operation->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->serial)
            <td>{{ $product->serial }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->purchase)
            <td>{{ $product->purchase }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->rec_name)
            <td>{{ $product->rec_name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->rec_contact)
            <td>{{ $product->rec_contact }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->rec_position)
            <td>{{ $product->rec_position }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif


        </tr>
        @endforeach
    </tbody>
</table>
