<?php namespace Version1\Events;

use Version1\Events\EventInterface;
use Version1\Events\Event;
use Version1\Models\BaseModel;
use \Carbon\Carbon;

Class EventRepository extends BaseModel implements EventInterface {

    /**
     * return a list of events along with their parent articles
     *
     * @return mixed
     */
    public function getEventsWithArticles($channel, $limit)
    {
        $result = Event::with('venue')->with(['article.location' => function($query) use ($channel) {
            $query->where('article_location.channel_id', $channel)->groupBy('article_location.sub_channel_id');
        }])->with('article.asset')
            ->where('event.show_date', '>=', Carbon::today())
            ->where('event.show_date', '<=', Carbon::today()->addWeeks(1))
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

    public function store($form)
    {
        if( ! empty($form['id']) )
        {
            $event = self::getEvent($form['id']);
        }
        else
        {
            $event = new Event();
        }

        if( \Config::get('app.fakeIt') )
        {
            $faker = \Faker\Factory::create();

            $event->title = ! empty($form['title']) ? $form['title'] : $faker->catchPhrase();
            $event->show_date = ! empty($form['date']) ? $form['date'] : $faker->date('Y-m-d');
            $event->show_time = ! empty($form['time']) ? $form['time'] : $faker->time('H:i:s');
            $event->price = ! empty($form['price']) ? $form['price'] : $faker->randomFloat(2, 6.99, 100.00);
            $event->url = ! empty($form['url']) ? $form['url'] : $faker->url();
        }
        else
        {
            $event->title = ! empty($form['title']) ? $form['title'] : null;
            $event->show_date = ! empty($form['date']) ? $form['date'] : null;
            $event->show_time = ! empty($form['time']) ? $form['time'] : null;
            $event->price = ! empty($form['price']) ? $form['price'] : null;
            $event->url = ! empty($form['url']) ? $form['url'] : null;
        }

        $event->venue_id = $form['venue'];
        $event->sef_name = safename($event->title);
        $event->is_active = isset($form['is_active']) ? true : false;

        $event->save();

        return $event;
    }

}
