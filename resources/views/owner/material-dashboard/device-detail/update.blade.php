<div id="sys-update" class="col-12 col-lg-4">
	<div class="card card-stats">
		<div class="card-header card-header-success card-header-icon">
			<div class="card-icon">
				<i class="material-icons">system_update_alt</i>
			</div>
			<h3 class="card-title pt-3">
				<span class="text-truncate d-block">Update Firmware</span>
			</h3>
		</div>
		<div id="sys-update-unavailable" 
			class="card-body text-center d-flex flex-column justify-content-center align-items-center" 
			style="min-height:295px">
			<div class="rounded-circle border d-flex flex-column justify-content-center" style="width: 150px;height: 150px;">
				<i class="material-icons" style="font-size: 4rem;line-height: 3.5rem;">cloud_done</i>
				<div style="font-size: 1rem;">Versi Terkini</div>
			</div>
		</div>
		<div id="sys-update-available" class="card-body text-left">
			<div class="row">
			
				<div class="col-12">
					<div class="row h-100">
						<div id="sys-update-download-info" class="col col-sm-12 d-none">
							<div class="row m-0">
								<div class="col col-12 col-sm-5 p-0 col-md-4 col-lg-12 text-center d-flex flex-column align-items-center justify-content-center">
									<div id="sys-update-download-info-progressbar" 
										class="progress d-block" 
										data-percentage="20">
										<span class="progress-left">
											<span class="progress-bar"></span>
										</span>
										<span class="progress-right">
											<span class="progress-bar"></span>
										</span>
										<div id="sys-update-download-info-label" class="progress-value">100%</div>
									</div>
								</div>
								<div class="col col-12 col-sm-7 col-md-8 col-lg-12 p-0 d-flex flex-column justify-content-center">
									<div class="row m-0 pb-2 mb-2 border-bottom">
										<div class="col col-sm-4 pl-0">Versi</div>
										<div id="sys-update-server-hash" class="col col-sm-8 text-truncate text-right pr-0 d-none d-md-block d-lg-none"></div>
										<div id="sys-update-server-hash-tooltips" 
											class="col col-sm-8 text-truncate text-right pr-0 d-md-none d-lg-block"
											data-toggle="tooltip" 
											title=""></div>
									</div>
									<div class="row m-0 pb-2 mb-2 border-bottom">
										<div class="col col-sm-5 pl-0">Progress</div>
										<div id="sys-update-download-info-progress" class="col col-sm-7 text-right pr-0"></div>
									</div>
									<div class="row m-0">
										<div class="col col-sm-5 pl-0">Remaining</div>
										<div id="sys-update-download-info-remaining" class="col col-sm-7 text-right pr-0"></div>
									</div>
								</div>
							</div>
						</div>
				
					</div>
				</div>
				
				
			</div>				
		</div>
		<div class="card-footer">
			<div class="stats">
				<i class="material-icons">access_time</i>&nbsp;<span id="sys-update-timestamp"></span>
			</div>
		</div>
	</div>
</div>