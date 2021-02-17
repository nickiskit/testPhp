function changeClass(enable, disable) {
	document.getElementById(disable+'Form').classList.add('disable'); 
	document.getElementById(disable).classList.remove('active');

	document.getElementById(enable+'Form').classList.remove('disable');
	document.getElementById(enable).classList.add('active');

	document.getElementById('message').innerText = '';
}
