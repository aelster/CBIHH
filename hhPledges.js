// JavaScript Document

function addAction(arg) {
	document.getElementById('action').value = arg;
	form1.submit();
}

function clearSpiritOther() {
	var e = document.getElementById('spiritOther');
	e.value = '';
	e.focus();
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
		
	} else if( area == 'spirit' ) {
		e = document.getElementsByName('spirit');
		for( var i=0; i<e.length; i++ ) {
			if( e[i].id == 'other' ) {
				var f = document.getElementById('spiritOther');
				if( e[i].checked ) {
					if( f.value !== '' ) ok = 1;
				} else {
					f.value = 'Please enter description';
				}
			} else {
				if( e[i].checked ) ok = 1;
			}
		}
		e = document.getElementById('spiritNow');
		if( ok ) {
			e.className = 'buttonOk';
			e.disabled = false;
		} else {
			e.className = 'buttonNotOk';
			e.disabled = true;
		}
	}
}