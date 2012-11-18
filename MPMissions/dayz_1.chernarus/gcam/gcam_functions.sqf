// GCam 2.0 Function by Pwnoz0r, VS_Shiva, edited by Crosire

fnc_keyDown = 
{
	private["_handled", "_ctrl", "_dikCode", "_shift", "_ctrlKey", "_alt"];
	
	_ctrl = _this select 0;
	_dikCode = _this select 1;
	_shift = _this select 2;
	_ctrlKey = _this select 3;
	_alt = _this select 4;
	_handled = false;

	if (!_shift && _ctrlKey && !_alt) then
	{
		if (_dikCode == 57 ) then
		{
			GCamKill = false;
			handle = [] execVM "gcam\gcam.sqf";
			_handled = true;
		};
	};

	_handled;	
};