<?php 

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

trait ApiRestController 
{
	protected $model;

	public function __construct() {
		$this->model = self::MODEL;
	}

	public function index( Request $request ) {
		$query = $this->model::query();
		$itemsPerPage = $request->has('itemsPerPage') ? $request->itemsPerPage : 10;
		$hasSearch = $request->has('search') && !empty( $request->search );
		$hasSearchColumn = $request->has('searchColumn') && !empty( $request->searchColumn );
		$doesntHave = $request->has('doesntHave') && !empty( $request->doesntHave );
		$doesntHaveIgnore = $request->has('doesntHaveIgnore') && !empty( $request->doesntHaveIgnore );
		$orderBy = $request->has('sortDesc') && $request->sortDesc !== 'false' ? 'DESC' : 'ASC';
		$sortBy = $request->has('sortBy') && !empty( $request->sortBy ) ? $request->sortBy : false;
		if ( $doesntHave ) {
			if ( $doesntHaveIgnore ) {
				$ignoreId = $request->doesntHaveIgnore;
				$selecteQuery = $query->whereHas( $request->doesntHave, function (Builder $q) use ( $ignoreId ){
					$q->where( 'id', '=', $ignoreId );
				});
				$selected = $selecteQuery->first();
			}
			$query->orDoesntHave( $request->doesntHave );
		}
		if ( $hasSearch && $hasSearchColumn ) {
			$query->where( $request->searchColumn, 'like', '%' . $request->search . '%' );
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
		$paginate = $query->paginate( $itemsPerPage );
		if ( $doesntHaveIgnore && isset( $selected ) && !empty( $selected ) ) {
			$paginate = collect( $paginate );
			$paginate['data'] = collect($paginate['data'])->prepend( $selected->toArray() );
		}
		return $this->successResponse( $paginate );
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