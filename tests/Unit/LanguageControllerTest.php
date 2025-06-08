<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    public function test_sets_locale_in_session_and_redirects_back()
    {
        $previousUrl = '/';
        $this->get($previousUrl);

        $response = $this->get(route('lang.change', ['lang' => 'ar']));

        $this->assertEquals('ar', Session::get('locale'));

        $response->assertRedirect($previousUrl);
    }
}
