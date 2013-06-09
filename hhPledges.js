// JavaScript Document

function addAction(arg) {
	document.getElementById('action').value = arg;
	form1.submit();
}

function makeActive(area) {
	//background-color: #ADB96E;
	var e, ok;
	
	if( area == 'pledges' ) {
		e = document.getElementsByName('Pledges');
		for( var i=0; i<e.length; i++ ) {
			if( e[i].checked ) {
				if( e[i].value == 'other' ) {
					var f = document.getElementById('pledgeOther');
					if( f.value > 0 ) ok = 1;
				} else {
					ok = 1;
				}
			}
		}
		e = document.getElementById('pledgeNow');
		if( ok ) {
			e.className = 'buttonOk';
			e.disabled = false;
		} else {
			e.className = 'buttonNotOk';
			e.disabled = true;
		}
	}
}