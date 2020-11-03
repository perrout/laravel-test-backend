<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Rules\Uppercase;

use App\Traits\Uuid;

class Contract extends Model
{
    use SoftDeletes, Uuid;

    protected $table = 'contracts';

    protected $fillable = [
        'property_id',
        'type',
        'document',
        'email',
        'name',
        'description'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'property_address',
        'type_text'
    ];

    public static function rules( $id = 0, $merge = [] ) {
        return array_merge (
            [
                'property_id' => [ 'required' ],
                'type' => [ 'required' ],
                'document' => [ 'required', request()->type === 'person' ? 'cpf' : 'cnpj' ],
                'email' => [ 'required', 'email' ],
                'name' => [ 'required' ],
            ],
            $merge
        );
    }
    public static function fields() {
        return [
            'id',
            'property_id',
            'type',
            'document',
            'email',
            'name',
            'description'
        ];
    }

    public function getTypeTextAttribute() {
        return $this->type === 'person' ? 'Pessoa Física' : 'Pessoa Jurídica';
    }

    public function getPropertyAddressAttribute() {
        return $this->property()->exists() ? $this->property->full_address : '';
    }

    public function property()
    {
        return $this->belongsTo( 'App\Models\Property' );
    }

}
