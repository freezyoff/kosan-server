window.addressRegion = function(options){
	
}

if (window._addressRegion == null){
	window._addressRegion = {};
}

window.addressRegion.utils = {
	empty: function(targetElements){
		targetElements.each(function(item){
			$(item).empty().append(regionSelect.options.emptyOption);
		});
	},
	pull: function(targetElements, url, callback){
		var opt = regionSelect.options;
		$.get(url, function( data ) {
			$.each(targetElements, function(index, item){
				
				callback(item, data);
				
			});
		});
	}
};

window._addressRegion.view = {};

window._addressRegion.view.province = {
	select:{
		addItem: function(targetElements, label, value){
			
		}
	},
	modal: {
		
	},
};


















window.addressRegion.select = {
	options:{
		view:{
			emptyItem: "<option value=\"none\">Pilih:</option>",
			provinces: [],
			regencies: [],
			districts: [],
			villages: [],
		},
		url:{
			provinces: "",
			regencies: "",
			districts: "",
			villages: ""
		}
	},
	selectedProvinceIndex: -1,
	selectedRegencyIndex: -1,
	selectedDistrictIndex: -1,
	init: function(options){
		$.extend(addressRegion.select.options, options);
		
		var obj = addressRegion.select;
		//init provinces
		obj.pull(opt.provinces, opt.url.provinces);
		$.each(opt.provinces, function(index, item){
			$(item).on('change', obj.onProvinceChange);
			$(item).on('sync', obj.onProvinceSync);
		});
		
		//init regencies
		obj.empty(opt.url.regencies, opt.regencies);
		$.each(opt.provinces, function(index, item){
			$(item).on('change', obj.onRegencyChange);
			$(item).on('sync', obj.onRegencySync);
		});
		
		//init districts
		obj.empty(opt.url.districts, opt.districts);
		$.each(opt.provinces, function(index, item){
			$(item).on('change', obj.onDistrictChange);
			$(item).on('sync', obj.onDistrictSync);
		});
		
		//init villages
		obj.empty(opt.url.villages, opt.villages);
		
		return regionSelect;
	}
};

window.addressRegion.modal = {
	options:{
		emptyItem: "<option value=\"none\">Pilih:</option>",
		provinces: [],
		regencies: [],
		districts: [],
		villages: [],
		url:{
			provinces: "",
			regencies: "",
			districts: "",
			villages: ""
		}
	},
	selectedProvinceIndex: -1,
	selectedRegencyIndex: -1,
	selectedDistrictIndex: -1,
	init: function(options){
		$.extend(addressRegion.select.options, options);
		
		var obj = addressRegion.select;
		//init provinces
		obj.pull(opt.provinces, opt.url.provinces);
		$.each(opt.provinces, function(index, item){
			$(item).on('change', obj.onProvinceChange);
			$(item).on('sync', obj.onProvinceSync);
		});
		
		//init regencies
		obj.empty(opt.url.regencies, opt.regencies);
		$.each(opt.provinces, function(index, item){
			$(item).on('change', obj.onRegencyChange);
			$(item).on('sync', obj.onRegencySync);
		});
		
		//init districts
		obj.empty(opt.url.districts, opt.districts);
		$.each(opt.provinces, function(index, item){
			$(item).on('change', obj.onDistrictChange);
			$(item).on('sync', obj.onDistrictSync);
		});
		
		//init villages
		obj.empty(opt.url.villages, opt.villages);
		
		return regionSelect;
	}
};

/**
 * Region Select
 * Province, Regency, District, and Village
 *
 *
 * Usage:
 * Provide <select> element for each Province, Regency, District, and Village
 * <pre>
 * 	regionSelect.init({
 *		provinces: [$('.provinces')]	-> array
 *		regencies: [$('.regencies')]	-> array
 *		districts: [$('.districts')]	-> array
 *		villages:  [$('.villages')]		-> array
 *		url:{
 *			provinces: "" 				-> string url
 *			regencies: "" 				-> string url
 *			districts: "" 				-> string url
 *			villages:  "" 				-> string url
 *		}
 *		emptyOption: "<option value="none">pilih</option>"
 * 	})
 * </pre>
 **/
window.regionSelect = {
	options:{
		emptyOption: "<option value=\"none\">Pilih:</option>"
	},
	selectedProvinceIndex: -1,
	selectedRegencyIndex: -1,
	selectedDistrictIndex: -1,
	init: function(options){
		$.extend(regionSelect.options, options);
		
		var obj = regionSelect;
		var opt = obj.options;
		var evt = obj.event;
		
		
		//init provinces
		obj.pull(opt.provinces, opt.url.provinces);
		$.each(opt.provinces, function(index, item){
			$(item).on('change', obj.onProvinceChange);
			$(item).on('sync', obj.onProvinceSync);
		});
		
		//init regencies
		obj.empty(opt.url.regencies, opt.regencies);
		$.each(opt.provinces, function(index, item){
			$(item).on('change', obj.onRegencyChange);
			$(item).on('sync', obj.onRegencySync);
		});
		
		//init districts
		obj.empty(opt.url.districts, opt.districts);
		$.each(opt.provinces, function(index, item){
			$(item).on('change', obj.onDistrictChange);
			$(item).on('sync', obj.onDistrictSync);
		});
		
		//init villages
		obj.empty(opt.url.villages, opt.villages);
		
		return regionSelect;
	},
	pull: function(targetElements, url, value){
		var opt = regionSelect.options;
		$.get(value? url+"/"+value : url, function( data ) {
			$.each(targetElements, function(index, item){
				
				$(targetElement).empty().append(opt.emptyOption);
				
				$.each(data, function(index, item){
					$(targetElement).append("<option value='"+ item.code +"'>"+ item.name +"</option>");
				});
				
			});
		});
		return regionSelect;
	},
	empty: function(targetElements){
		$.each(targetElements, function(index, item){
			$(item).empty().append(regionSelect.options.emptyOption);
		});
		return regionSelect;
	},
	onProvinceChange: function(){
		regionSelect.selectedProvinceIndex = $(this).selectedIndex;
		$(this).trigger('sync');
	},
	onProvinceSync: function(){
		//change sibling province select
		$.each(regionSelect.options.provinces, function(index, item){
			item.selectedIndex = regionSelect.selectedProvinceIndex;
			regionSelect.empty(regionSelect.options.regencies)
						.pull(regionSelect.options.regencies, regionSelect.options.url.regencies, item.selectedIndex);
		});
	},
	onRegencyChange: function(){
		regionSelect.selectedRegencyIndex = $(this).selectedIndex;
		$(this).trigger('sync');
	},
	onRegencySync: function(){
		$.each(regionSelect.options.regencies, function(index, item){
			item.selectedIndex = regionSelect.selectedRegencyIndex;
			regionSelect.empty(regionSelect.options.districts);
			if (item.selectedIndex > -1){
				regionSelect.pull(
					regionSelect.options.districts, 
					regionSelect.options.url.districts, 
					item.selectedIndex
				);
			}
						
		});
	},
	onDistrictChange: function(){
		regionSelect.selectedDistrictIndex = $(this).selectedIndex;
		$(this).trigger('sync');
	},
	onDistrictSync: function(){
		$.each(regionSelect.options.regencies, function(index, item){
			item.selectedIndex = regionSelect.selectedDistrictIndex;
			regionSelect.empty(regionSelect.options.villages);
			
			if (item.selectedIndex > -1){
				regionSelect.pull(
					regionSelect.options.villages, 
					regionSelect.options.url.villages, 
					item.selectedIndex
				);
			}
		});
	}
};

if (window.regionModal == null){
	window.regionModal = {};
}

window.regionModal = {
	
	/**
	 *
	 */
	init: function(regionSelect){
		
	}
	
}