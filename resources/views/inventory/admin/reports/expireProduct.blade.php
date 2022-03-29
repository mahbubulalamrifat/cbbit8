<table>
    <thead>
        <tr>
            <td colspan="6" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> Inventory Waranty Expire Product List
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: #3F51B5;color:white;">Product Name/Model</td>
            <td style="font-weight:bold; background-color: #3F51B5;color:white;">Category</td>
            <td style="font-weight:bold; background-color: #3F51B5;color:white;">Subcategory</td>
            <td style="font-weight:bold; background-color: #3F51B5;color:white;">Serial</td>
            <td style="font-weight:bold; background-color: #3F51B5;color:white;">Purchase Date</td>
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

            @if($product->subcategory)
            <td>{{ $product->subcategory->name }}</td>
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

        </tr>
        @endforeach
    </tbody>
</table>