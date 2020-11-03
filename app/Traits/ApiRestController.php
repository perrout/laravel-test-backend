<?php 

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;

trait ApiRestController 
{
	protected $model, $create;

	public function __construct() {
		$this->model = self::MODEL;
		$this->create = self::CREATE;
	}

	public function index( Request $request ) {
		$query = $this->model::query();
		$itemsPerPage = $request->has('itemsPerPage') ? $request->itemsPerPage : 10;
		$doesntHave = $request->has('doesntHave') && !empty( $request->doesntHave );
		$orderBy = $request->has('sortDesc') && $request->sortDesc !== 'false' ? 'DESC' : 'ASC';
		$sortBy = $request->has('sortBy') && !empty( $request->sortBy ) ? $request->sortBy : false;
		if ( $doesntHave ) {
			$query->doesntHave( $request->doesntHave );
		}
        if ( $sortBy ) {
			switch( $sortBy ) {
				case 'full_address':
					$query->orderBy( 'address', $orderBy )
							->orderBy( 'number', $orderBy )
							->orderBy( 'city', $orderBy )
							->orderBy( 'state', $orderBy );
				break;
				default: 
					$query->orderBy( $sortBy, $orderBy );
			}
            
		}
		return $this->successResponse( $query->paginate( $itemsPerPage ) );
	}

	public function show( $id ) {
		if ( !$item = $this->model::find( $id ) ) {
			return $this->notFoundResponse();
		}
		return $this->successResponse(['data' => $item]);
	}

	public function store( Request $request ) {
		try {
			$v = validator( $request->only( $this->model::fields() ), $this->model::rules() );
			if ( $v->fails() ) {
				throw new Exception('ValidationException');
			}
			// $this->create::dispatch( $request->only( $this->model::fields() ) );
			$item = $this->model::create( $request->only( $this->model::fields() ) );
			return $this->successResponse( [ 'data' => $item, 'message' => 'Item adicionado com sucesso!' ], 201);
		} catch (Exception $exception) {
			$error = count( $v->messages() ) ? $v->messages() : [ 'error' => 'Ocorreu um problema ao adicionar o item.' ];
            return $this->errorResponse( $error );
		}
	}

	public function update( Request $request, $id ) {
		if( !$item = $this->model::find( $id ) ) {
			return $this->notFoundResponse();   
		}
		try {
			$v = validator( $request->only( $this->model::fields() ), $this->model::rules($id) );
			if($v->fails()) {
				throw new Exception('ValidationException');
			}
			$item->fill( $request->only( $this->model::fields() ) );
			$item->save();
			return $this->successResponse( [ 'data' => $item, 'message' => 'Item atualizado com sucesso!' ] );
		} catch (Exception $exception) {
			$error = count( $v->messages() ) ? $v->messages() : [ 'error' => 'Ocorreu um problema ao atualizar o item.' ];
            return $this->errorResponse( $error );
		}
	}

	public function destroy( $id ) {
		if ( !$item = $this->model::find( $id ) ) {
			return $this->notFoundResponse();
		}
		try {
			$item->delete();
			return $this->successResponse( [ 'message' => 'Item removido com sucesso!' ], 202 );
		} catch (Exception $exception) {
            return $this->errorResponse( [ 'error' => 'Ocorreu um problema ao remover o item.' ] );
		}
	}

	protected function notFoundResponse() {
		return response()->json(['message' => 'Item não encontrado!'], 404);
	}

	public function successResponse( $data, $code = 200 ) {
		return response()->json( $data, $code );
	}

	public function errorResponse( $data, $code = 422 ) {
		return response()->json( $data, $code );
	}
}