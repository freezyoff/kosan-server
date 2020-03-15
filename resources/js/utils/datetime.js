if (!window.now){
	window.now = function(){ return Math.round((new Date()).getTime() / 1000); }
}

if (!window.Time){
	
window.Time = {
	now: function(){ return Math.round((new Date()).getTime() / 1000); },
	
	toHuman: function(timestamp){
		var a = new Date(timestamp * 1000);
		var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
		var days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
		var year = a.getFullYear();
		var month = months[a.getMonth()];
		var date = a.getDate();
		var hour = a.getHours();
		var min = a.getMinutes();
		var sec = a.getSeconds();
		var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
		return time;
	},
	
	elapsed: function(timestamp){
		// record start time
		let startTime = timestamp;

		// later record end time
		let endTime = now();

		// time difference in ms
		// strip the ms
		let timeDiff = (endTime - startTime);
		
		// get seconds (Original had 'round' which incorrectly counts 0:28, 0:29, 1:30 ... 1:59, 1:0)
		let seconds = Math.round(timeDiff % 60);

		// remove seconds from the date
		timeDiff = Math.floor(timeDiff / 60);

		// get minutes
		let minutes = Math.round(timeDiff % 60);

		// remove minutes from the date
		timeDiff = Math.floor(timeDiff / 60);

		// get hours
		let hours = Math.round(timeDiff % 24);

		// remove hours from the date
		timeDiff = Math.floor(timeDiff / 24);

		// the rest of timeDiff is number of days
		let days = timeDiff ;
		
		return {
			diff: endTime - startTime,
			seconds:seconds,
			minutes:minutes,
			hours:hours,
			days:days
		}
	}
}

}