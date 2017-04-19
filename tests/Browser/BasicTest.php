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

    public function testSubmitFormShouldSeeFollow()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->click('.searchSubmit')
                ->pause(self::JsWaitApi)
                ->assertSee('Next Page');
        });
    }

    public function testNextPageShouldSeePreviousPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->click('.searchSubmit')
                ->pause(self::JsWaitApi)
                ->click('.nextPage')
                ->pause(self::JsWaitApi)
                ->assertSee('Previous Page');
        });
    }

    public function testNextPageClickPreviousPageShouldHidePreviousPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->click('.searchSubmit')
                ->pause(self::JsWaitApi)
                ->click('.nextPage')
                ->pause(self::JsWaitApi)
                ->click('.previousPage')
                ->pause(self::JsWaitApi)
                ->assertDontSee('Previous Page');
        });
    }

    public function testShouldSeeNoResultsFound()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(self::JsWait)
                ->type('searchTerm', '"random long invalid search with no results"')
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
