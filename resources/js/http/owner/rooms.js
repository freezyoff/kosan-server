require("../../utils/numberOnly.js");

if (!window.APP){
	window.APP = {};
}

APP = {
	prevTableData: "",
	
	showTableData: (tag)=>{
		//update button label
		$("#btn-location").html("<span class='ml-2 mr-2'>" + $(tag).html().trim() + "</span>");
		
		//hide last table list
		APP.hideTableData(APP.prevTableData);
		
		//show new table list
		APP.prevTableData = $(tag).attr('table-data');
		$("#tbody_"+APP.prevTableData).removeClass('d-none');
	},
	
	hideTableData: (id)=>{
		$("#tbody_"+id).addClass('d-none');
	},

	hideAllTableData: ()=>{
		$(".modal-filter-location").each((index, item)=>{
			APP.hideTableData($(item).attr('table-data'));
		});
	}

};

$(document).ready(()=>{
	$('[data-toggle="tooltip"]').tooltip();
	
	//init dropdown location for table data
	APP.hideAllTableData();
	APP.showTableData($(".modal-filter-location")[0]);
});