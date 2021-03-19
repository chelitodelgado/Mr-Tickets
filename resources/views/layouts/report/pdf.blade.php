<html>
	<head>
		<meta charset="utf-8">
		<title>Reporte</title>
        <style>
            * {
                box-sizing: content-box;
                color: black;
                margin: 0;
                padding: 0;
                vertical-align: top;
            }

            /* heading */
            h1 {
                font: bold 100% sans-serif;
                letter-spacing: 0.5em;
                text-align: center;
                text-transform: uppercase;
            }

            /* table */

            table {
                font-size: 70%;
                table-layout: fixed;
                width: 100%;
            }
            table {
                border-collapse: separate;
                border-spacing: 2px;
            }
            th,
            td {
                border-width: 1px;
                padding: 0.5em;
                position: relative;
                text-align: left;
            }
            th,
            td {
                border-radius: 0.25em;
                border-style: solid;
            }
            th {
                background: #eee;
                border-color: #bbb;
            }
            td {
                border-color: #ddd;
            }

            /* page */

            html {
                font: 16px/1 "Open Sans", sans-serif;
                overflow: auto;
                margin: 50pt 15pt;
                padding: 0.5in;
                background: #ffff;
            }
            body {
                box-sizing: border-box;
                height: 11in;
                margin: 0 auto;
                overflow: hidden;
                padding: 0.5in;
                width: 8.5in;
                border-radius: 1px;
                box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            }

            /* header */

            header {
                width: 81%;
                height: auto;
                margin: 0 0 3em;
            }
            header:after {
                clear: both;
                content: "";
                display: table;
            }

            header h1 {
                background: #000;
                border-radius: 0.25em;
                color: #fff;
                margin: 0 0 1em;
                padding: 0.5em 0;
            }
            header address {
                float: left;
                font-size: 75%;
                font-style: normal;
                line-height: 1.25;
                margin: 0 1em 1em 0;
            }
            header address p {
                margin: 0 0 0.25em;
            }
            header span,
            header img {
                display: block;
                float: right;
            }
            header span {
                margin: 0 0 1em 1em;
                max-height: 25%;
                max-width: 60%;
                position: relative;
            }
            header img {
                max-height: 100%;
                max-width: 100%;
            }
            header input {
                cursor: pointer;
                -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
                height: 100%;
                left: 0;
                opacity: 0;
                position: absolute;
                top: 0;
                width: 100%;
            }

            /* article */

            article,
            article address,
            table.meta,
            table.inventory {
                width: 83%;
                height: auto;
            }
            article:after {
                clear: both;
                content: "";
                display: table;
            }
            article h1 {
                clip: rect(0 0 0 0);
                position: absolute;
            }

            article address {
                float: left;
                font-size: 125%;
                font-weight: bold;
            }

            /* table meta & balance */

            table.meta,
            table.balance {
                float: right;
                width: 36%;
            }
            table.meta:after,
            table.balance:after {
                clear: both;
                content: "";
                display: table;
            }

            /* table meta */

            table.meta th {
                width: 40%;
            }
            table.meta td {
                width: 60%;
            }

            /* table items */

            table.inventory {
                clear: both;
                width: 100%;
            }
            table.inventory th {
                font-weight: bold;
                text-align: center;
            }

            table.inventory td:nth-child(1) {
                width: 26%;
            }
            table.inventory td:nth-child(2) {
                width: 38%;
            }
            table.inventory td:nth-child(3) {
                text-align: right;
                width: 12%;
            }
            table.inventory td:nth-child(4) {
                text-align: right;
                width: 12%;
            }
            table.inventory td:nth-child(5) {
                text-align: right;
                width: 12%;
            }

            /* table balance */

            table.balance th,
            table.balance td {
                width: 50%;
            }
            table.balance td {
                text-align: right;
            }

            /* aside */
            aside {
                width: 83%;
                height: auto;
            }

            aside h1 {
                border: none;
                border-width: 0 0 1px;
                margin: 0 0 1em;
            }
            aside h1 {
                border-color: #999;
                border-bottom-style: solid;
            }

            @media print {
                * {
                    -webkit-print-color-adjust: exact;
                }
                html {
                    background: none;
                    padding: 0;
                }
                body {
                    box-shadow: none;
                    margin: 0;
                }
                span:empty {
                    display: none;
                }
                .add,
                .cut {
                    display: none;
                }
            }

            @page {
                margin: 0;
            }

        </style>
	</head>
	<body>
		<header>
			<h1>Reporte</h1>
			<address>
				<p>Pedro Picapiedra Gonzales</p>
				<p>Piedratoca</p>
				<p>(111) 111-1111</p>
			</address>
			{{-- <span><img alt="" src="https://github.com/chelitodelgado/lotedeimagenes/blob/main/src/about_us.svg" width="100px"><input type="file" accept="image/*"></span> --}}
		</header>
		<article>
			<address >
				<p>Kharma<br>Solutions</p>
			</address>
			<table class="meta">
				<tr>
					<th><span>Codigo</span></th>
                    @foreach ($data as $item)
					    <td><span>{{$item->code}}</span></td>
                    @endforeach
				</tr>
				<tr>
					<th><span>Fecha actual</span></th>
					<td><span>{{$date}}</span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span>Nombre del reporte</span></th>
						<th><span>Descripcion</span></th>
						<th><span>Proyecto</span></th>
						<th><span>Tipo</span></th>
						<th><span>Fecha</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach ($data as $item)
                        <td><span>{{$item->title}}</span></td>
						<td><span>{{$item->description}}</span></td>
						<td><span>{{$item->project}}</span></td>
						<td><span>{{$item->kind}}</span></td>
						<td><span>{{$item->created_at}}</span></td>
                        @endforeach
					</tr>
				</tbody>
			</table>
			<table class="balance">
                @foreach ($data as $item)
				<tr>
					<th><span>Prioridad</span></th>
					<td><span>{{$item->priority}}</span></td>
				</tr>
				<tr>
					<th><span>Categoria</span></th>
					<td><span>{{$item->category}}</span></td>
				</tr>
				<tr>
					<th><span>Estado</span></th>
					<td><span>{{$item->status}}</span></td>
				</tr>
                @endforeach
			</table>
		</article>
		<aside>
			<h1><span>Notas Adicionales</span></h1>
			<div>
				<p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    Odit sint voluptatem, quos consequatur distinctio ex ipsa
                    praesentium possimus officia quis. Quis exercitationem
                    nesciunt voluptates quidem molestias aliquam error
                    veritatis nam.
                </p>
			</div>
		</aside>
	</body>
</html>
