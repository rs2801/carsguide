<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BasicTest extends DuskTestCase
{
    const JsWait = 600;
    const JsWaitApi = 1500;

    public function testLoadAppSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->assertSee('Twitter search.');
        });
    }

    public function testDefaultSearchTerm()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->assertInputValue('searchTerm', 'carsguide');
        });
    }

    public function testSearchAndShouldSeeLoadMore()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->click('.searchSubmit')
                ->pause(self::JsWaitApi)
                ->assertSee('Load more');
        });
    }

    public function testSearchAndShouldSeePaginationPageOne()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->click('.searchSubmit')
                ->pause(self::JsWaitApi)
                ->assertSeeIn('.pagination', '1');
        });
    }

    public function testLoadMoreShouldGoToPageTwo()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->click('.searchSubmit')
                ->pause(self::JsWaitApi)
                ->clickLink('Load more')
                ->pause(self::JsWaitApi)
                ->assertSeeIn('.pagination', '2');
        });
    }

    public function testSearchShouldSeeNoResultsFound()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->type('searchTerm', '"random_long_invalid_search_with_no_results"')
                ->click('.searchSubmit')
                ->pause(self::JsWaitApi)
                ->assertSee('No tweets found');
        });
    }

    public function testEmptyTermShouldSeeSearchTermIsRequird()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->keys('.searchTerm', ['{control}', 'a'])
                ->keys('.searchTerm', ['{backspace}'])
                ->pause(self::JsWait)
                ->click('.searchSubmit')
                ->pause((self::JsWait + 1000))
                ->assertSee('Search term is required');
        });
    }
}
