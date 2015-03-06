<?php namespace Apiv1\Mail\Notifications\Mandrill;

use App;

Class Client {

	protected $apiKey;
	protected $apiClient;
	protected $baseUrl = 'https://mandrillapp.com/api/1.0/';
	protected $endpoints = [
		'message' => 'messages/send.json'
	];

	public function __construct()
	{
		$this->apiKey = $_ENV['MANDRILL_API_KEY'];
		$this->apiClient = App::make('ApiClient');
	}

	public function send($email)
	{		
		$request = [
			'key' => $this->apiKey,
			'message' => [
				'html' => $email->html,
				'text' => strip_tags($email->html),
				'subject' => $email->subject,
				'from_email' => $email->fromEmail,
				'from_name' => $email->fromName,
				'to' => [
					[
						'email' => $email->toEmail,
						'name' => $email->toName,
					]
				],
				'headers' => [
					'Reply-To' => $email->fromEmail
				],
				'tags' => $email->tags // an array of tags
			]
		];

		# if we have a blind courtesy copy address then include it in the request
		if(isset($email->bcc) && !empty($email->bcc)) {
			$request['message']['bcc_address'] = $email->bcc;
		}

		# make up the Mandrill API endpoint
		$url = $this->baseUrl.$this->endpoints[$email->type];

		# make the request
		return $this->apiClient->post($url, json_encode($request));
	}
}