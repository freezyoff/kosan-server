<div id="sys-update" class="col-md-12 d-none">
	<div class="card bg-info">
		<div class="card-body">
			<h4 class="card-title font-weight-bold">Frimware Update</h4>	
			<div class="row">
			
				<div class="col col-sm-12 col-md-8 col-lg-8">
					<div class="row">
					
						<div class="col col-sm-12 col-md-12 col-lg-12">
							<div class="row border-bottom m-0 pb-2 mb-2">
								<div class="col col-sm-12 p-0"><h5 class="m-0">Perangkat</h5></div>
							</div>
							<div class="row border-bottom m-0 pb-2 mb-2">
								<div class="col col-sm-4 pl-0">Versi</div>
								<div id="sys-update-device-hash" class="col col-sm-8 text-truncate text-right pr-0 d-none d-md-block"></div>
								<div id="sys-update-device-hash-tooltips" 
									class="col col-sm-8 text-truncate text-right pr-0 d-md-none"
									data-toggle="tooltip" 
									title=""></div>
							</div>
							<div class="row m-0 pb-2 mb-2">
								<div class="col col-sm-4 pl-0">Size</div>
								<div id="sys-update-device-size" class="col col-sm-8 text-truncate text-right pr-0"></div>
							</div>
						</div>
						<div class="col col-sm-12 col-md-12 col-lg-12 mt-1">
							<div class="row border-bottom m-0 pb-2 mb-2">
								<div class="col col-sm-12 p-0"><h5 class="m-0">Terkini</h5></div>
							</div>
							<div class="row border-bottom m-0 pb-2 mb-2">
								<div class="col col-sm-4 pl-0">Versi</div>
								<div id="sys-update-server-hash" class="col col-sm-8 text-truncate text-right pr-0 d-none d-md-block"></div>
								<div id="sys-update-server-hash-tooltips" 
									class="col col-sm-8 text-truncate text-right pr-0 d-md-none"
									data-toggle="tooltip" 
									title=""></div>
							</div>
							<div class="row m-0">
								<div class="col col-sm-4 pl-0">Size</div>
								<div id="sys-update-server-size" class="col col-sm-8 text-truncate text-right pr-0"></div>
							</div>
						</div>
					
					</div>
				</div>
				
				
				<div class="col-sm-12 col-md-4 col-lg-4">
					<div class="row h-100">
					
						<div id="sys-update-download-btn" class="col col-sm-12 mt-sm-3 mt-md-0">
							<div class="row m-0 pb-2 mb-2 align-items-stretch h-100">
								<div class="col col-sm-12 p-0 text-center d-flex flex-column align-items-center justify-content-center">
									<button class="btn btn-round btn-fab btn-secondary" style="width:150px;height:150px">
										<i class="material-icons text-warning" style="font-size:56px;line-height:150px">cloud_download</i>
									</button>
									<div class="mt-1" style="font-size:24px">Download</div>								
								</div>
							</div>
						</div>
						<div id="sys-update-download-info" class="col col-sm-12 mt-3 mt-md-0 pt-3 pt-md-0 d-none">
							<div class="row m-0">
								<div class="col col-12 col-sm-6 col-md-12 p-0 text-center d-flex flex-column align-items-center justify-content-center">
									<div id="sys-update-download-info-progressbar" class="progress d-block" data-percentage="20">
										<span class="progress-left">
											<span class="progress-bar"></span>
										</span>
										<span class="progress-right">
											<span class="progress-bar"></span>
										</span>
										<div id="sys-update-download-info-label" class="progress-value">100%</div>
									</div>
								</div>
								<div class="col col-12 col-sm-6 col-md-12 p-0 d-flex flex-column justify-content-center mt-md-1">
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
			<div class="stats text-white">
				<i class="material-icons">access_time</i>&nbsp;<span id="sys-update-timestamp"></span>
			</div>
		</div>
	</div>
</div>