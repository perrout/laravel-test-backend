<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Property;

class PropertyTest extends TestCase
{
    use WithFaker;

    protected function setUpFaker() {
        $this->faker = $this->makeFaker('pt_BR');
    }

    /** @test */
    public function test_can_read_all_the_properties() {

        $properties = factory( Property::class, 4 )->create()->map(function ($property) {
            return $property->only( Property::fields() );
        });

        $jsonStructure = [ 
            'current_page', 
            'data', 
            'first_page_url', 
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ];

        $this->get( route( 'properties.index' ) )
                        ->assertStatus( 200 )
                        ->assertJsonStructure( $jsonStructure );
    }

    /** @test */
    public function test_can_create_property() {

        $data = [
            'email' => $this->faker->freeEmail,
            'postal' => $this->faker->postcode,
            'address' => $this->faker->streetName,
            'number' => $this->faker->buildingNumber,
            'secondary_address' => $this->faker->secondaryAddress,
            'neighborhood' => $this->faker->city,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
        ];

       $this->post( route('properties.store' ), $data )
            ->assertStatus( 201 )
            ->assertJson( ['message' => 'Item adicionado com sucesso!'] );

        $this->assertDatabaseHas( 'properties', $data );
    }

    /** @test */
    public function test_can_update_property() {

        $property = factory( Property::class )->create();

        $data = [
            'email' => $this->faker->freeEmail,
            'postal' => $this->faker->postcode,
            'address' => $this->faker->streetName,
            'number' => $this->faker->buildingNumber,
            'secondary_address' => $this->faker->secondaryAddress,
            'neighborhood' => $this->faker->city,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
        ];

        $this->put( route( 'properties.update', $property->id ), $data )
            ->assertStatus( 200 )
            ->assertJson( ['message' => 'Item atualizado com sucesso!'] )
            ->assertJsonFragment( $data );

        $this->assertDatabaseHas( 'properties', $data );
    }

    /** @test */
    public function test_can_show_property() {

        $property = factory( Property::class )->create();

        $this->get( route( 'properties.show', $property->id ) )
            ->assertStatus( 200 );
    }

    /** @test */
    public function test_can_delete_property() {

        $property = factory( Property::class )->create();

        $this->delete( route( 'properties.delete', $property->id ) )
            ->assertStatus( 202 )
            ->assertJson( ['message' => 'Item removido com sucesso!'] );
    }
}
