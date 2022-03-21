<table>
    <thead>
        <tr>
            <td colspan="8" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> {{$product[0]->category->name}} Stock Record
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">DATE</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">Doc.No</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">LOCATION</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">DEPARTMENT</td>
            <td colspan="2" style="background-color: khaki;font-weight:bold;">BALANCE</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">Unit Price</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">Remark</td>
        </tr>
        <tr>
            <td style="background-color: khaki">Quantity</td>
            <td style="background-color: khaki">Amount</td>
        </tr>
    </thead>
    <tbody>
        @foreach($product as $product)
        <tr>
            <td>{{date("F j, Y", strtotime($product->created_at))}}</td>

            @if($product->category)
            <td>{{ $product->category->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->newold)
            <td>{{ $product->newold->business_unit }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->newold)
            <td>{{ $product->newold->office }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->business_unit)
            <td>{{ $product->business_unit }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->remark)
            <td>{{ $product->remark }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->unit_price)
            <td>{{ $product->unit_price }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->remarks)
            <td>{{ $product->remarks }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

        </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td rowspan="5"></td>
            <td colspan="2">TOTAL USAGE</td>
            <td>Unit Price</td>
            <td>AMOUNT</td>
            <td></td>
        </tr>
        <tr>
            <td>Received</td>
            <td>
                {{$length[0]}}
            </td>
            <td>0.00</td>
            <td>0.00</td>
            <td colspan="9" rowspan="5"></td>
            <td></td>
        </tr>

        <tr>
            <td>Issue</td>
            <td>3</td>
            <td>2,625.00</td>
            <td>7,875.00</td>
            <td></td>
        </tr>

        <tr>
            <td>Damage</td>
            <td>0</td>
            <td>0.00</td>
            <td>0.00</td>
            <td></td>
        </tr>

        <tr>
            <td></td>
            <td>3</td>
            <td>2,625.00</td>
            <td>7,875.00</td>
            <td></td>
        </tr>

        <tr>
            <td></td>
            <td>3</td>
            <td>2,625.00</td>
            <td>7,875.00</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="7"></td>
            <td colspan="2">............................</td>
            <td colspan="3"></td>
            <td colspan="2">............................</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="7"></td>
            <td colspan="2">Md. Saiful Alam</td>
            <td colspan="3"></td>
            <td colspan="2">Mr. Surachai Praniratlert</td>
            <td></td>
        </tr>
    </tbody>
</table>
