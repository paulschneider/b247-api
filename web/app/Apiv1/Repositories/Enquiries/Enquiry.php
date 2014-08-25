<?php namespace Apiv1\Repositories\Enquiries;

use Apiv1\Repositories\Models\BaseModel;

Class Enquiry extends BaseModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'enquiry';

	/**
	 * indicate the we want to store created_at and updated_at timestamps for each new record
	 * 
	 * @var boolean
	 */
	public $timestamps = true;

	/**
	 * by now we've validated the form input so just save it into the database
	 * 
	 * @param  array $form
	 * @return boolean
	 */
	public function store($form)
	{
		$enquiry = new Enquiry();

		$enquiry->name = $form['name'];
		$enquiry->tel = isset($form['tel']) ? $form['tel'] : "";
		$enquiry->email = $form['email'];
		$enquiry->message = $form['message'];

		return $enquiry->save();
	}
}