<!-- Begin: modal -->
<div id="mdl-sm-pic" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header align-items-stretch bg-light">
				<h6 class="modal-title font-weight-bold">Person In Charge (PIC)</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times</span>
				</button>
			</div>
			<div class="modal-body">
				<form name="frm-pic" method="post" action="">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Nama PIC:</label>
						<input type="text" name="name" class="form-control" placeholder="Nama">
					</div>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Email PIC:</label>
						<input type="text" name="email" class="form-control" placeholder="Email">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					<i class="fas fa-times"></i>
					<span class="ml-1">Batal</span>
				</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal"
					onclick="sendPicInvitation('#mdl-sm-pic', '{{$location->id}}')">
					<i class="fas fa-share"></i>
					<span class="ml-1">Kirim</span>
				</button>
			</div>
		</div>
	</div>
</div>
<!-- End: modal -->