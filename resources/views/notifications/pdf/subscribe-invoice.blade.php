<html>
<head>
<link media="all" rel="apple-touch-icon" sizes="76x76" type="image/png" href="https://owner.kosan.co.id/img/apple-icon.png">
<link media="all" rel="icon" type="image/png" href="https://owner.kosan.co.id/img/favicon.png">
<link media="all" rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
<link media="all" rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link media="all" rel="stylesheet" type="text/css" href="{{mix('vendor/material-dashboard/css/material-dashboard.min.css')}}">
<link media="all" rel="stylesheet" type="text/css" href="{{mix('css/brand.css')}}">
<style type="text/css" media="all" rel="stylesheet">
	body{background-color: #ffffff;}
	.paper-size-letter{ max-width:816.37px; margin:auto; }
	.paper-size-a4{ max-width:793.7px; margin:auto; }
	.brand {color: rgb(85, 85, 85) !important;}
	
	.invoice-issued{font-size:.9rem; background-color:#eeeeee78;}
	.invoice-issued .title{font-weight:500}
	
	.invoice-info {margin-top:1rem; padding-top:.4rem; padding-bottom:.4rem;}
	.invoice-info>.invoice-info-issuer .title {font-size:.9rem; font-weight:500;}
	.invoice-info>.invoice-info-issuer .name {font-size:.9rem; font-weight:500;}
	.invoice-info>.invoice-info-issuer .address,
	.invoice-info>.invoice-info-issuer .phone {font-size:.9rem;}
	
	.invoice-info>.invoice-info-billed .title {font-size:.9rem; font-weight:500}
	.invoice-info>.invoice-info-billed .name {font-size:.9rem; font-weight:500;}
	.invoice-info>.invoice-info-billed .address,
	.invoice-info>.invoice-info-billed .phone,
	.invoice-info>.invoice-info-billed .idcard {font-size:.9rem;}
	
	.invoice-list.invoice-list-header{background-color: #595959;color:white;padding:.4rem 0;}
	.invoice-list.invoice-list-item:nth-child(even){background-color:#eeeeee78}
	.invoice-list.invoice-list-item:nth-child(odd){background-color:white;}
	.invoice-list.invoice-list-item {font-size:.9rem;  padding-top:.4rem; padding-bottom:.4rem;}
	
	.invoice-summary {font-size:.9rem;}
	.invoice-summary>.row>div:first-child {font-weight:500;}
	.invoice-summary>.row>div {padding-top:.4rem; padding-bottom:.4rem;}
	.invoice-summary>.row:nth-child(odd)>div{background-color:#eeeeee78}
	.invoice-summary>.row:nth-child(even)>div{background-color:white}
	
	.invoice-notes {font-size:.9rem; padding-left:0;}
	.invoice-notes>div:first-child{background-color:#eeeeee78; font-weight:500;}
	.invoice-notes>div{padding-left:15px; padding-top:.4rem; padding-bottom:.4rem; background-color:white;}
	
</style>
</head>
<body>
<div class="content mt-0 paper-size-letter">
	<div class="row align-items-center">
		<div class="col col-sm-8">
			<a href="https://owner.kosan.co.id" class="navbar-brand brand" style="font-size:1.8rem; text-decoration:none">
				Kos<span class="unique cursor-pointer">a</span>n
				<div class="ripple-container"></div>
			</a>
		</div>
		<div class="col col-sm-4">
			<div class="text-info" style="font-weight:bold; font-size:1.5rem">PROFORMA INVOICE</div>
		</div>
	</div>
	<div class="row mt-3 border-top border-bottom invoice-issued">
		<div class="col">
			<div class="">
				<span class="title">Nomor: </span>
				<span class="value">XX/XXXX/XXX/XXXX</span>
			</div>
		</div>
		<div class="col">
			<div class="">
				<span class="title">Tanggal: </span>
				<span class="value">30/30/2020</span>
			</div>
		</div>
		<div class="col">
			<div class="">
				<span class="title">Jatuh Tempo: </span>
				<span class="value">30/30/2020</span>
			</div>
		</div>
	</div>
	<div class="row invoice-info mt-4">
		<div class="col invoice-info-issuer">
			<div class="title" style="font-size:.9rem">Diterbitkan atas nama: </div>
			<div class="name">Penginapan Mawar II</div>
			<div class="address">Jl. Mawar II No. 16/75, Lowokwaru, Malang</div>
			<div class="phone">0811 3209 855</div>
		</div>
		<div class="col invoice-info-billed">
			<div class="title">Ditujukan kepada: </div>
			<div>
				<span class="name">Akhmad Musa Hadi</span> / 
				<span class="idcard">123456789012356</span>
			</div>
			<div class="address">Perum. Wisma Kedung Asem Indah Blok AA Nomor 8</div>
			<div class="phone">0811 3209 855</div>
		</div>
	</div>
	<div class="row invoice-list invoice-list-header mt-4">
		<div class="col col-sm-8">Item</div>
		<div class="col col-sm-2 text-right">Harga<span style="visibility:hidden">,-</span></div>
		<div class="col col-sm-2 text-right">Jumlah<span style="visibility:hidden">,-</span></div>
	</div>
	<div class="row invoice-list invoice-list-item border-bottom">
		<div class="col col-sm-8">Sewa Kost Kamar A1 (1 bulan) Tgl 01/02/2020 s/d 31/02/2020 </div>
		<div class="col col-sm-2 text-right">700,000,-</div>
		<div class="col col-sm-2 text-right">700,000,-</div>
	</div>
	<div class="row invoice-list invoice-list-item border-bottom stripe">
		<div class="col col-sm-8">Sewa Kost Kamar A1 (1 bulan) Tgl 01/02/2020 s/d 31/02/2020 </div>
		<div class="col col-sm-2 text-right">700,000,-</div>
		<div class="col col-sm-2 text-right">700,000,-</div>
	</div>
	<div class="row invoice-list invoice-list-item border-bottom">
		<div class="col col-sm-8">Sewa Kost Kamar A1 (1 bulan) Tgl 01/02/2020 s/d 31/02/2020 </div>
		<div class="col col-sm-2 text-right">700,000,-</div>
		<div class="col col-sm-2 text-right">700,000,-</div>
	</div>
	
	<div class="row mt-3">
		<div class="col invoice-notes">
			<div class="border-top border-bottom">
				Keterangan:
			</div>
			<div>
				Via Transfer
			</div>
		</div>
		<div class="col col-sm-4 invoice-summary">
			<div class="row border-top border-bottom">
				<div class="col col-sm-6 text-right">Sub Total<span style="visibility:hidden">,-</span></div>
				<div class="col col-sm-6 text-right">700,000,-</div>
			</div>
			<div class="row border-bottom">
				<div class="col col-sm-6 text-right">Diskon<span style="visibility:hidden">,-</span></div>
				<div class="col col-sm-6 text-right">700,000,-</div>
			</div>
			<div class="row border-bottom">
				<div class="col col-sm-6 text-right">Pajak<span style="visibility:hidden">,-</span></div>
				<div class="col col-sm-6 text-right">700,000,-</div>
			</div>
			<div class="row border-bottom">
				<div class="col col-sm-6 text-right">Grand Total<span style="visibility:hidden">,-</span></div>
				<div class="col col-sm-6 text-right">700,000,-</div>
			</div>
		</div>
	</div>
</div>
</script>
</body>
</html>