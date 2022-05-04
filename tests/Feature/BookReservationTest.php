<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response =  $this->post('/books', [
            'title' => 'Some book',
            'author' => 'Bickter'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    public function test_a_title_is_required()
    {

        $response =  $this->post('/books', [
            'title' => '',
            'author' => 'Bickter'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_an_author_is_required()
    {

        $response =  $this->post('/books', [
            'title' => 'Cool title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();


        $this->post('/books/', [
            'title' => 'Cool title',
            'author' => 'Bicker'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'Cool New title',
            'author' => 'James'
        ]);

        $this->assertEquals('Cool New title', Book::first()->title);
        $this->assertEquals('James', Book::first()->author);
    }
}
