<div class="table-responsive">
	<table class="table">
		
		<thead class="text-primary">
			<tr>
				<th>No. Tagihan</th>
				<th>Tanggal Tagihan</th>
				<th>Jatuh Tempo</th>
				<th>Total</th>
				<th class="text-right">&nbsp;</th>
			</tr>
		</thead>
		
		<tbody>
			@foreach($invoices as $inv)
			<tr>
				<td>{{$inv->id}}</td>
				<td>{{$inv->issue_date}}</td>
				<td>{{$inv->due_date}}</td>
				<td>{{$inv->due_date}}</td>
				<td class="text-right">
					<a href="@htmlID(1)" data-toggle="modal">
						<i class="material-icons ml-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sewakan">
							payment
						</i>
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>