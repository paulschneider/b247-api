<?php namespace Apiv1\Repositories\Events;

use Apiv1\Repositories\Events\Event;
use Apiv1\Repositories\Models\BaseModel;
use Carbon\Carbon;

Class EventRepository extends BaseModel {

    /**
     * return a list of events along with their parent articles
     *
     * @return mixed
     */
    public function getEventsWithArticles($channel, $limit)
    {
        $result = Event::with('venue')->with(['article.location' => function($query) use ($channel) {
            $query->where('article_location.channel_id', $channel);
        }])->with('article.asset', 'article.display')
            // ->where('event.show_date', '>=', Carbon::today())
            // ->where('event.show_date', '<=', Carbon::today()->addWeeks(1))
            ->orderBy('event.show_date', 'asc')
            ->take($limit)
            ->get()
            ->toArray();

        $articles = [];

        foreach($result AS $event)
        {
            if( isset($event['article'][0]) )
            {
                $article = $event['article'][0];

                unset($event['article']);

                $article['event'] = [
                    'venue' => $event['venue']
                ];

                unset($event['venue']);

                $article['event']['details'] = $event;

                $articles[] = $article;
            }
        }

        return $articles;
    }

    public function getEventListing($limit)
    {
        return Event::with('venue')->get()->toArray();
    }

    public function getEvents()
    {
        return Event::with('venue')->alive()->orderBy('show_date', 'desc')->orderBy('show_time', 'desc')->get();
    }

    public function getEvent($eventId)
    {
        return Event::findOrFail($eventId)->whereId($eventId)->first();
    }

    public function getSimpleEvents()
    {
        return Event::alive()->active()->lists('title', 'id');
    }
}
