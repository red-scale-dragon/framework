<?php

namespace Dragon\Http\Controllers\Admin;

use Dragon\Http\Controllers\AdminPageController;
use App\Http\Requests\Admin\AdminSettingsRequest;
use Dragon\Admin\Notice;
use Illuminate\Http\Request;
use Dragon\Database\Option;
use Dragon\Http\Form\Select;
use Dragon\Http\Form\Textbox;

class SettingsController extends AdminPageController {
	protected static string $successNotice = "Settings saved.";
	protected static string $pageTitle = "Admin Settings";
	protected static string $menuText = "Dragon Settings";
	protected static string $capability = "manage_options";
	protected static string $routeName = "admin-settings";
	protected static string $slug = "settings";
	
	protected array $encryptedFields = [
		'test_field',
	];
	
	public function show(Request $request) {
		$data = [
        	'title' => static::$pageTitle,
			'fields' => $this->getFields(),
		];
		
		if ($request->attributes->has('notice')) {
			$data['notice'] = $request->attributes->get('notice');
		}
		
        return view('admin.settings', $data);
    }
    
    public function store(AdminSettingsRequest $request) {
    	if ($request->attributes->get('nonce_invalid')) {
    		return $this->show($request);
    	}
    	
    	foreach ($request->validated() as $key => $val) {
    		if (in_array($key, $this->encryptedFields)) {
    			$val = encrypt($val);
    		}
    		Option::set($key, $val);
    	}
    	
    	$request->attributes->add([
    		'notice' => Notice::success(static::$successNotice),
    	]);
    	
    	return $this->show($request);
    }
    
    protected function getFields() {
    	return [
    		"Plugin Settings",
	    		Select::make('remove_migrations_on_deactivation')
		    		->options([
		    			'no' => 'No (Recommended)',
		    			'yes' => 'Yes',
		    		])
		    		->value(Option::get('remove_migrations_on_deactivation'))
		    		->label('Remove DB tables on deactivation?')
		    		->required(),
    	];
    }
}
