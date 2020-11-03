<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

use App\Traits\Uuid;

class Property extends Model
{
    use SoftDeletes, Uuid;

    protected $table = 'properties';

    protected $fillable = [
        'email',
        'postal',
        'address',
        'number',
        'secondary_address',
        'neighborhood',
        'city',
        'state',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'full_address',
        'status'
    ];

    public static function rules( $id = 0, $merge = [] ) {
        return array_merge (
            [
                'email' => [ 'required', 'email' ],
                // 'address' => 'required',
                // 'neighborhood' => 'required',
                // 'city' => 'required',
                // 'state' => 'required',
            ],
            $merge
        );
    }
    public static function fields() {
        return [
            'id',
            'email',
            'postal',
            'address',
            'number',
            'secondary_address',
            'neighborhood',
            'city',
            'state',
        ];
    }
    
    public function getFullAddressAttribute() {
        return "{$this->address}, {$this->number}, {$this->city}, {$this->state}";
    }

    public function getStatusAttribute() {
        return $this->contract()->exists() ? 'Contratado' : 'Não contratado';
    }

    public function contract()
    {
        return $this->hasOne( 'App\Models\Contract' )->latest();
    }
    
}
