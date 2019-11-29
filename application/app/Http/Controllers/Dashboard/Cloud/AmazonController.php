<?php

namespace App\Http\Controllers\Dashboard\Cloud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;

class AmazonController extends Controller
{
    function __construct()
    {
    	$this->middleware('admin');
    }

    /**
	* Get Amazon S3 settings
    */
    public function get()
    {
    	// Get Regions
    	$regions = array(
			'US East (Ohio)'            => 'us-east-2', 
			'US East (N. Virginia)'     => 'us-east-1', 
			'US West (N. California)'   => 'us-west-1', 
			'US West (Oregon)'          => 'us-west-2', 
			'Canada (Central)'          => 'ca-central-1', 
			'Asia Pacific (Mumbai)'     => 'ap-south-1', 
			'Asia Pacific (Seoul)'      => 'ap-northeast-2', 
			'Asia Pacific (Singapore)'  => 'ap-southeast-1', 
			'Asia Pacific (Sydney)'     => 'ap-southeast-2', 
			'Asia Pacific (Tokyo)'      => 'ap-northeast-1', 
			'EU (Frankfurt)'            => 'eu-central-1', 
			'EU (Ireland)'              => 'eu-west-1', 
			'EU (London)'               => 'eu-west-2', 
			'South America (São Paulo)' => 'sa-east-1',
    	);

    	return view('dashboard.clouds.amazon', compact('regions'));
    }

    /**
	* Update amazon Settings
    */
    public function post(Request $request)
    {
    	// Validate Form
    	$request->validate([
			'bucket' => 'required',
			'key'    => 'required',
			'secret' => 'required',
			'region' => 'required',
    	]);

    	// Update Settings
    	Config::write('filesystems', [
			'disks.s3.bucket' => $request->get('bucket'),
			'disks.s3.key'    => $request->get('key'),
			'disks.s3.secret' => $request->get('secret'),
			'disks.s3.region' => $request->get('region'),
    	]);

    	// Successfully Updated
    	return redirect('dashboard/settings/cloud/amazon')->with('success', 'Amazon S3 has been successfully updated.');
    }
}
