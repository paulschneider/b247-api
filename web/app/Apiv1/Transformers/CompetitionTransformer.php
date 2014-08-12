<?php namespace Apiv1\Transformers;

use Config;
use Carbon\Carbon;

class CompetitionTransformer extends Transformer {

    /**
     * Flag to indicate whether the promotion is still valid
     * 
     * @var boolean
     */
    private $is_valid;

    /**
     * the status of the promotion
     * @var string
     */
    private $status;

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $competition, $options = [] )
    {
        $response = [];
        
        $from = explode(' ', $competition['valid_from']);
        $to = explode(' ', $competition['valid_to']);

        return [
            'id' => $competition['id'],
            'title' => $competition['title'],
            'question' => $this->getQuestion($competition),
            'answers' => $this->getAnswers($competition),
            'terms' => $competition['terms'],
            'isValid' => $this->isValid($competition),
            'meta' => [
                'status' => $this->status,
                'validFrom' => [
                    'epoch' => (int) strtotime($competition['valid_from']),
                    'readable' => $competition['valid_from'],
                    'day' => date('Y-m-d', strtotime($from[0])),
                    'time' => date('H:i', strtotime($from[1]))
                ],
                'validTo' => [
                    'epoch' => (int) strtotime($competition['valid_to']),
                    'readable' => $competition['valid_to'],
                    'day' => date('Y-m-d', strtotime($to[0])),
                    'time' => date('H:i', strtotime($to[1]))
                ]
            ]
        ];
    }

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection( $article, $options = [] )
    {
        $response = [];

        foreach( $article['competition'] AS $competition )
        {
            $response[] = $this->transform($competition);
        }

        return $response;
    }

    /**
     * Determine and return the status of a competition
     * 
     * @param  array $competition [a competition row from the database, unformatted]
     * @return mixed
     */
    public function isValid($competition)
    {
        $validFrom = strtotime($competition['valid_from']);
        $validTo = strtotime($competition['valid_to']);

        $today = time();

        # if the promotion is still within the valid from/to range
        if($validFrom < $today && $validTo > $today)
        {
            $this->is_valid = true;
            $this->status = [
                "type" => "Running",
                "details" => "Competition started on " . $competition['valid_from'] ." and ends on ".$competition['valid_to']
            ];
        }

        // if the promotion hasn't yet begun
        if($validFrom > $today)
        {
            $this->is_valid = false;
            $this->status = [
                "type" => "Not Started",
                "details" => "Competition not open until " . $competition['valid_from']
            ];
        }

        # if the promotion has expired
        if($validTo < $today)
        {
            $this->is_valid = false;
            $this->status = [
                "type" => "Ended",
                "details" => "Competition ended on " . $competition['valid_to']
            ];
        }

        return $this->is_valid;
    }

    /**
     * Extract the question from the competition array
     * 
     * @param  array $competition [details, questions and answers for this competition]
     * @return string [the competition question]
     * 
     */
    public function getQuestion($competition)
    {
        return $competition['questions'][0]['question'];
    }

    /**
     * Retrieve and format the list of answers for this competition
     * 
     * @param array $competition [details, questions and answers for this competition]
     * @return array [a list of possible answers for this competition]
     * 
     */
    public function getAnswers($competition)
    {
        $answers = [];

        foreach($competition['questions'][0]['answers'] AS $answer)
        {
            $answers[] = [
                'id' => $answer['id'],
                'answer' => $answer['answer'],
            ];
        }

        return $answers;
    }
}
