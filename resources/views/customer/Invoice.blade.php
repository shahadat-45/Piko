<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
        <style>
            *
            {
                border: 0;
                box-sizing: content-box;
                color: inherit;
                font-family: inherit;
                font-size: inherit;
                font-style: inherit;
                font-weight: inherit;
                line-height: inherit;
                list-style: none;
                margin: 0;
                padding: 0;
                text-decoration: none;
                vertical-align: top;
            }    
            /* heading */
    
            h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }
    
            /* table */
    
            table { font-size: 75%; table-layout: fixed; width: 100%; }
            table { border-collapse: separate; border-spacing: 2px; }
            th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
            th, td { border-radius: 0.25em; border-style: solid; }
            th { background: #EEE; border-color: #BBB; }
            td { border-color: #DDD; }
    
            /* page */
    
            html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
            html { background: #999; cursor: default; }
    
            body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: auto; }
            body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }
    
            /* header */
    
            header { margin: 0 0 3em; display: block}
            header:after { clear: both; content: ""; display: table; }
    
            header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
            header .address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
            header .address p { margin: 0 0 0.25em; }
            header span, header img { display: block; float: right; }
            header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
            header img { max-height: 100%; max-width: 100%; }
            header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }
    
            /* article */
            
            .article{display: block; margin-top: 480px;}
            .article, .article .address, table.meta, table.inventory { margin: 0 0 3em; }
            .article:after { clear: both; content: ""; display: table; }
            .article h1 { clip: rect(0 0 0 0); position: absolute; }
    
            .article .address { float: left; font-size: 125%; font-weight: bold; }
    
            /* table meta & balance */
    
            table.meta, table.balance { float: right; width: 36%; }
            table.meta:after, table.balance:after { clear: both; content: ""; display: table; }
    
            /* table meta */
    
            table.meta th { width: 40%; }
            table.meta td { width: 60%; }
    
            /* table items */
    
            table.inventory { clear: both; width: 100%; }
            table.inventory th { font-weight: bold; text-align: center; }
    
            table.inventory td:nth-child(1) { width: 26%; }
            table.inventory td:nth-child(2) { width: 38%; }
            table.inventory td:nth-child(3) { text-align: right; width: 12%; }
            table.inventory td:nth-child(4) { text-align: right; width: 12%; }
            table.inventory td:nth-child(5) { text-align: right; width: 12%; }
    
            /* table balance */
    
            table.balance th, table.balance td { width: 50%; }
            table.balance td { text-align: right; }
    
            /* aside */
    
            .additional h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
            .additional h1 { border-color: #999; border-bottom-style: solid; padding-bottom: 5px;}
    
            /* javascript */
    
            .add, .cut
            {
                border-width: 1px;
                display: block;
                font-size: .8rem;
                padding: 0.25em 0.5em;	
                float: left;
                text-align: center;
                width: 0.6em;
            }
    
            .add, .cut
            {
                background: #9AF;
                box-shadow: 0 1px 2px rgba(0,0,0,0.2);
                background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
                background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
                border-radius: 0.5em;
                border-color: #0076A3;
                color: #FFF;
                cursor: pointer;
                font-weight: bold;
                text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
            }
    
            .add { margin: -2.5em 0 0; }
    
            .add:hover { background: #00ADEE; }
    
            .cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
            .cut { -webkit-transition: opacity 100ms ease-in; }
    
            tr:hover .cut { opacity: 1; }
    
            @media print {
                * { -webkit-print-color-adjust: exact; }
                html { background: none; padding: 0; }
                body { box-shadow: none; margin: 0; }
                span:empty { display: none; }
                .add, .cut { display: none; }
            }
    
            @page { margin: 0; }
            @media all and (max-width: 599px){
                body {
                    padding: 0.2in;
                }
                header {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                header h1 {
                    letter-spacing: 0.4em;
                    padding: 0.5em 10px;
                }
                header span {
                    margin: 0 auto 1em;
                }
                header span {
                    max-width: 28%;
                }
                /*Header End*/
                .article {
                    display: flex;
                    flex-direction: column;
                }
                table {
                    table-layout: auto;
                }
                table.meta {
                    width: fit-content;
                }
                table.meta th {
                    width: max-content;
                }
                table.meta td {
                    width: max-content;
                }
                table.inventory {
                    margin: 0 0 1em;
                }
                .scroll_bar{
                    overflow-x: auto;
                    margin-bottom: 50px;
                }
                table.balance {
                    width: 100%;
                    margin-top: 20px;
                }
            }
            @media all and (min-width: 600px) and (max-width:799px){
                body {
                    height: 10in;
                }
                header span {
                    max-width: 30%;
                }
                table.meta, table.balance {
                    width: 50%;
                }
                .additional div p{
                    line-height: 24px;
                }
            }
            @media all and (min-width: 800px) and (max-width:1024px){
                header span {
                    max-width: 26%;
                }
            }
            @media all and (min-width: 1025px) and (max-width: 1399px){
                header span {
                    max-width: 20%;
                }
            }
            @media all and (min-width: 1400px){
                header span {
                    max-width: 20%;
                }
            }
        </style>
	</head>
	<body>
        @php
            $country_id = App\Models\Billing::where('order_id' , $order_id)->first()->bill_country;
            $city_id = App\Models\Billing::where('order_id' , $order_id)->first()->bill_city;
            $order_info = App\Models\Orders::where('order_id' , $order_id)->first();
            $orderProduct = App\Models\OrderedProduct::where('order_id' , $order_id)->get();
        @endphp
		<header>
			<h1>Invoice</h1>
			<div class="address">
				<p>The Mart</p>
				<p>4517 Washington Ave. Manchter, <br> Kentucky 495</p>
				<p>(208) 555-0112 <br>
                (704) 555-0127</p>
			</div>
			<span><img alt="" src="https://i.postimg.cc/GhRP5ZK1/Logos.png" width="100px"></span>
		</header>
		<div class="article">
			{{-- <h1 style="margin-bottom: 20px">Recipient</h1> --}}
			<div class="address">
				<p>{{ App\Models\Billing::where('order_id' , $order_id)->first()->bill_company ?? '' }} <br> {{ App\Models\Billing::where('order_id' , $order_id)->first()->bill_fname }}</p>
			</div>
			<table class="meta">
				<tr>
					<th><span>Invoice #</span></th>
					<td><span>{{ $order_id }}</span></td>
				</tr>
				<tr>
					<th><span>Date</span></th>
					<td>{{ $order_info->created_at->format('d-M-Y') }}</td>
				</tr>
				<tr>
					<th><span>Amount Due</span></th>
					<td><span>${{ $order_info->total }}</span></td>
				</tr>
			</table>
            <div class="scroll_bar">
			<table class="inventory">
				<thead>
					<tr>
						<th><span>Item</span></th>
						<th><span>Rate</span></th>
						<th><span>Quantity</span></th>
						<th><span>Price</span></th>
					</tr>
				</thead>
				<tbody>
                    @php
                        $sub_total = 0;
                    @endphp
                    @foreach ($orderProduct  as $index => $product)
                       <tr>
						<td><span>{{ $product->rel_to_product->product_name }}</span></td>
						<td><span data-prefix>$</span><span>{{ $product->price }}</span></td>
						<td><span>{{ $product->quantity }}</span></td>
						<td><span data-prefix>$</span><span>{{ $product->price * $product->quantity }}</span></td>
					</tr>
                    @php
                        $sub_total += (int) $product->price * (int) $product->quantity 
                    @endphp
                    @endforeach					
				</tbody>
			</table>
            </div>
			<a class="add">+</a>
			<table class="balance">
                <tr>
                    <th><span>Discount</span></th>
                    <td><span data-prefix>- $</span><span>{{ $order_info->discount ?? 0 }}</span></td>
                </tr>
				<tr>
					<th><span>Total</span></th>
					<td><span data-prefix>$</span><span>{{ $sub_total - $order_info->discount ?? 0 }}</span></td>
				</tr>
                <tr>
                    <th><span>Amount Paid</span></th>
                    <td><span data-prefix>$</span><span>{{ $sub_total }}</span></td>
                </tr>
			</table>
		</div>
		<div class="additional">
			<h1><span>Additional Notes</span></h1>
			<div>
				<p>A finance charge of 1.5% will be made on unpaid balances after 30 days.</p>
			</div>
		</div>
	</body>
</html>