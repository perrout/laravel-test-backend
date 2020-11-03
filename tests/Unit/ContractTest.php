<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Contract;
use App\Models\Property;

class ContractTest extends TestCase
{
    use WithFaker;

    protected function setUpFaker() {
        $this->faker = $this->makeFaker('pt_BR');
    }

    /** @test */
    public function test_can_read_all_the_contracts() {

        $contracts = factory( Contract::class, 4 )->create();

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

        $this->get( route( 'contracts.index' ) )
                        ->assertStatus( 200 )
                        ->assertJsonStructure( $jsonStructure );
    }

    /** @test */
    public function test_can_create_contract() {
        $type = $this->faker->randomElement( $array = array( 'person', 'company' ) );
        $document = $type === "person" ? $this->faker->cpf : $this->faker->cnpj;
        $property_id = factory( Property::class )->create()->id;

        $data = [
            'property_id' => $property_id,
            'type' => $type,
            'document' => $document,
            'email' => $this->faker->freeEmail,
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'description' => $this->faker->paragraphs( 5, true )
        ];

        $respose = $this->post( route('contracts.store' ), $data )
                        ->assertStatus( 201 )
                        ->assertJson( ['message' => 'Item adicionado com sucesso!'] );
    }

    /** @test */
    public function test_can_update_contract() {

        $contract = factory( Contract::class )->create();

        $type = $this->faker->randomElement( $array = array( 'person', 'company' ) );
        $document = $type === "person" ? $this->faker->cpf : $this->faker->cnpj;

        $data = [
            'property_id' => $contract->property_id,
            'type' => $type,
            'document' => $document,
            'email' => $this->faker->freeEmail,
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'description' => $this->faker->paragraphs( 5, true )
        ];

        $this->put( route( 'contracts.update', $contract->id ), $data )
            ->assertStatus( 200 )
            ->assertJson( ['message' => 'Item atualizado com sucesso!'] )
            ->assertJsonFragment( $data );
    }

    /** @test */
    public function test_can_show_contract() {

        $contract = factory( Contract::class )->create();

        $this->get( route( 'contracts.show', $contract->id ) )
            ->assertStatus( 200 );
    }

    /** @test */
    public function test_can_delete_contract() {

        $contract = factory( Contract::class )->create();

        $this->delete( route( 'contracts.delete', $contract->id ) )
            ->assertStatus( 202 )
            ->assertJson( ['message' => 'Item removido com sucesso!'] );
    }
}
