<?php namespace Apiv1\Transformers;

use App;

class EventTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $events, $options = [] )
    {
        $response = [];

        foreach( $events AS $event )
        {
            $response[] = $this->transform( $event, $options );
        }

        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param sponsor
     * @return array
     */
    public function transform( $article, $options = [] )
    {      
        $event = $article['event'];

        if( empty($article['event']['cinema']) ) 
        {
            $performances = App::make( 'Apiv1\Transformers\ShowTimeTransformer' )->transformCollection($article, $options);    

            # if we don't have any performances to work with then just return out of this process
            if(! $performances) {
                return false;
            }

            # work out which performance to use as the primary data source
            # if its multi-date use the next available performance
            if(isset($performances['summary']['nextPerformance'])) {
                $performance = $performances['summary']['nextPerformance'];
            }
            # if its single date then just use that one
            else {
                $performance = $performances['summary']['firstPerformance'];   
            }

            $response = [
                'details' => [
                    'id' => $event['id'],
                    'title' => $event['title'],
                    'sefName' => $event['sef_name'],
                    'showDate' => $performance['start']['day'],
                    'showTime' => $performance['start']['time'],
                    'epoch' => strtotime($performance['start']['day'] .' ' . $performance['start']['time']),
                    'price' => $performances['summary']['fromPrice'],
                    'url' => $event['url'],
                    'performances' => $performances
                ]
            ];

            $response['venue'] = $performances['summary']['venue'];
            unset($response['details']['performances']['summary']['venue']);

            return $response;
        }
        else 
        {
            $performances = App::make('Apiv1\Transformers\CinemaListingTransformer')->transform($article, $options);

            $response = [
                'details' => [
                    'id' => $event['id'],
                    'title' => $event['title'],
                    'sefName' => $event['sef_name'],
                    'showDate' => $performances['venues'][0]['startTime']['day'],
                    'showTime' => $performances['venues'][0]['startTime']['time'],
                    'epoch' => $performances['venues'][0]['startTime']['epoch'],
                    # these two attributes (price and URL) should be removed for version two. They are not needed
                    # but left in so to not break the mobile and tablet apps
                    'price' => null,
                    'url' => null,
                ]
            ];

            $response['summary'] = $performances['summary'];

            # for cinema events we provide a list of venues where the film is showing. 
            # these were previously attached to a single venue with alternatives listed out
            $response['venues'] = $performances['venues'];

            # thats why we keep this single venue item. It should be removed for version two
            $response['venue'] = ['name' => ''];

            return $response;
        }    
    }
}