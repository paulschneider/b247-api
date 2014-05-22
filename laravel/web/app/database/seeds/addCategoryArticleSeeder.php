<?php

class AddCategoryArticleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        $articles = DB::table('article')->lists('id');
        $categories = DB::table('category')->lists('id');

        $totalArticles = count($articles)-1;
        $totalCategories = count($categories)-1;

        for ($i=1; $i < count($articles); $i++) {

            \Version1\Models\ArticleCategory::create([
                'article_id' => $articles[$faker->randomNumber(0, $totalArticles)]
                ,'cat_id' => $categories[$faker->randomNumber(0, $totalCategories)]
            ]);
        }

        $this->command->info('Category Articles Created');
    }

}
