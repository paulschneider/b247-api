<?php namespace Apiv1\Transformers;

class UserTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $user, $options = [] )
    {
        $response = [
            'id' => $user['id']
            ,'accessKey' => $user['access_key']
            ,'firstName' => $user['first_name']
            ,'lastName' => $user['last_name']
            ,'email' => $user['email']
        ];

        if( isset($user['profile']) )
        {
            $profile = $user['profile'];

            $response['profile'] = [
                'ageGroup' => $profile['age_group_id'],
                'nickName' => $profile['nickname'],
                'facebook' => $profile['facebook'],
                'twitter' => $profile['twitter'],
                'postCode' => $profile['postcode'],
            ];
        }

        return $response;
    }

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection( $users, $options = [] )
    {
        // Transform a list of users
    }
}
