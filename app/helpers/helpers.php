<?php

use App\Models\Setting;

function getSiteSettings($key){
	$siteSettings=Setting::where('_key',$key)->first();
	return $siteSettings;
}
