<?php namespace Api\Transformers;

class UserTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform($user)
    {
        return [
            'id' => $user['id']
            ,'accessKey' => $user['access_key']
            ,'firstName' => $user['first_name']
            ,'lastName' => $user['last_name']
            ,'email' => $user['email']
        ];
    }

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection($users)
    {
        // Tranform a list of users
    }
}
