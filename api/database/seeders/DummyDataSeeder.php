<?php

namespace Database\Seeders;

use App\Repositories\Search;
use App\Repositories\SearchRepository;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    protected SearchRepository $searchRepository;
    protected Generator $faker;

    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sources = [
            Search::SOURCE_BBC,
            Search::SOURCE_CBS,
            Search::SOURCE_CNN,
            Search::SOURCE_NBC,
        ];

        for ($i=0; $i < 1000; $i++){
            $news = (new Search())
                ->setType(Search::TYPE_NEWS)
                ->setTitle($this->faker->sentence())
                ->setSource($sources[mt_rand(0, 3)])
                ->setContent($this->faker->paragraph())
                ->setLink($this->faker->url())
                ->setAvatar($this->faker->imageUrl(120, 120))
                ->setDate($this->faker->date('Y-m-d'))
            ;

            $instagram = (new Search())
                ->setType(Search::TYPE_INSTAGRAM)
                ->setTitle($this->faker->sentence())
                ->setPhoto($this->faker->imageUrl(360, 360))
                ->setVideo($this->faker->imageUrl(360, 360))
                ->setContent($this->faker->paragraph())
                ->setUsername($this->faker->word())
                ->setAvatar($this->faker->imageUrl(120, 120))
                ->setName($this->faker->words(2, true))
                ->setDate($this->faker->date('Y-m-d'))
            ;

            $twitter = (new Search())
                ->setType(Search::TYPE_TWITTER)
                ->setContent($this->faker->paragraph())
                ->setUsername($this->faker->word())
                ->setRetweet(mt_rand(0, 10000))
                ->setPhoto($this->faker->imageUrl(360, 360))
                ->setAvatar($this->faker->imageUrl(120, 120))
                ->setDate($this->faker->date('Y-m-d'))
            ;

            $this->searchRepository->persist( $news );
            $this->searchRepository->persist( $instagram );
            $this->searchRepository->persist( $twitter );
        }
    }
}
